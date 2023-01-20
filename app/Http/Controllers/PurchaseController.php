<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Purchase;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use App\Models\Purchase_detail;
use App\Models\Purchase_temporary_detail;
use Illuminate\Support\Facades\Validator;

class PurchaseController extends Controller
{
    public function getId()
    {
        $getId = Purchase::whereDate('created_at', '=', Carbon::today())
            ->where('user_id', auth()->user()->id)
            ->get();
        $prefixCount = str_pad(count($getId) + 1, 4, '0', STR_PAD_LEFT);
        $getDate = (count($getId) == 0) ? Carbon::today()->format('Ymd') : Carbon::parse($getId[0]->created_at)->format('Ymd');
        $id = '1' . $getDate . auth()->user()->id . $prefixCount;
        return $id;
    }

    public function index()
    {
        $title = 'Pembelian';

        $temporary = Purchase_temporary_detail::orderBy('created_at', 'desc')
            ->select('id', 'barcode', 'name', 'purchase_price', 'qty')
            ->selectRaw('(purchase_price*qty) AS subtotal')
            ->where('user_id', auth()->user()->id)
            ->get('barcode');

        $total = collect($temporary)->sum('subtotal');

        $product = Product::orderBy('created_at', 'desc')
            ->where('user_id', auth()->user()->id)
            ->get();

        $data = [
            'title'         => $title,
            'temporary'     => $temporary,
            'total'         => $total,
            'id'            => $this->getId(),
            'product'       => $product
        ];

        return view('purchase.index', compact('data'));
    }

    public function store(Request $request)
    {
        $temporary = Purchase_temporary_detail::where('user_id', auth()->user()->id)->get();
        if ($temporary->count()) {
            $purchase = Purchase::create([
                'code'    => $this->getId(),
                'total' => $request->total,
                'user_id'   => auth()->user()->id
            ]);

            for ($i = 0; $i < $temporary->count(); $i++) {
                Purchase_detail::create([
                    'barcode'           => $temporary[$i]->barcode,
                    'name'              => $temporary[$i]->name,
                    'purchase_price'    => $temporary[$i]->purchase_price,
                    'qty'               => $temporary[$i]->qty,
                    'purchase_id'       => $purchase->id
                ]);

                $product = Product::where('user_id', auth()->user()->id)->where('barcode', $temporary[$i]->barcode)->first();
                $product->update([
                    'stock'   => $product->stock + $temporary[$i]->qty
                ]);
            }
            Purchase_temporary_detail::where('user_id', auth()->user()->id)->delete();
            return redirect()->route('purchase');
        } else {
            return redirect()->route('purchase')->with('error', 'Data transaksi belum ada!');
        }
    }

    public function temporaryStore(Request $request)
    {
        $validated = $request->validate([
            'barcode'   => 'required|exists:products,barcode',
            'qty'       => 'required|numeric'
        ]);

        $product = Product::where('user_id', auth()->user()->id)
            ->where('barcode', $request->barcode)
            ->first();

        if ($product) {
            $temporary = Purchase_temporary_detail::where('user_id', auth()->user()->id)
                ->where('barcode', $request->barcode)
                ->first();
            if ($temporary) {
                $temporary->update([
                    'qty'   => $temporary->qty + $request->qty
                ]);
            } else {
                Purchase_temporary_detail::create([
                    'barcode'       => $product->barcode,
                    'name'          => $product->name,
                    'purchase_price' => $product->purchase_price,
                    'qty'           => $request->qty,
                    'user_id'       => auth()->user()->id
                ]);
            }

            return redirect()->route('purchase');
        }
        return redirect()->route('purchase');
    }

    public function temporaryDestroy(Purchase_temporary_detail $purchase_temporary_detail)
    {
        $purchase_temporary_detail->delete();

        return redirect()->route('purchase')->with('success', 'Data telah dihapus!');
    }

    public function temporaryUpdate(Request $request, Purchase_temporary_detail $purchase_temporary_detail)
    {
        $request->merge([
            'harga_beli' => str_replace(".", "", $request->harga_beli),
        ]);
        $validation = Validator::make($request->all(), [
            'harga_beli' => 'required|integer',
            'qty'        => 'required|numeric|min:0.1',
        ]);

        if ($validation->fails()) {
            return response()->json($validation->errors(), 422);
        }
        $purchase_temporary_detail->update([
            'purchase_price'    => $request->harga_beli,
            'qty'               => $request->qty
        ]);
    }
}

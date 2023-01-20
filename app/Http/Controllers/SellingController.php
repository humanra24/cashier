<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Selling;
use Illuminate\Http\Request;
use App\Models\Selling_detail;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use App\Models\Selling_temporary_detail;
use Illuminate\Support\Facades\Validator;

class SellingController extends Controller
{
    public function getId()
    {
        $getId = Selling::whereDate('created_at', '=', Carbon::today())
            ->where('user_id', auth()->user()->id)
            ->get();
        $prefixCount = str_pad(count($getId) + 1, 4, '0', STR_PAD_LEFT);
        $getDate = (count($getId) == 0) ? Carbon::today()->format('Ymd') : Carbon::parse($getId[0]->created_at)->format('Ymd');
        $id = '2' . $getDate . auth()->user()->id . $prefixCount;
        return $id;
    }

    public function index()
    {
        $title = 'Penjualan';

        $temporary = Selling_temporary_detail::orderBy('created_at', 'desc')
            ->select('id', 'barcode', 'name', 'selling_price', 'qty')
            ->selectRaw('(selling_price*qty) AS subtotal')
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

        return view('selling.index', compact('data'));
    }

    public function store(Request $request)
    {
        $request->merge([
            'bayar' => str_replace(".", "", $request->bayar),
            'kembalian' => str_replace(".", "", $request->kembalian),
        ]);
        $validation = $request->validate([
            'bayar'     => 'required|integer|min:' . $request->total,
            'kembalian'    => 'required|integer',
        ]);

        $temporary = Selling_temporary_detail::where('user_id', auth()->user()->id)->get();
        if ($temporary->count()) {
            $selling = Selling::create([
                'code'    => $this->getId(),
                'total' => $request->total,
                'money' => $request->bayar,
                'change' => $request->kembalian,
                'user_id'   => auth()->user()->id
            ]);

            for ($i = 0; $i < $temporary->count(); $i++) {
                Selling_detail::create([
                    'barcode'           => $temporary[$i]->barcode,
                    'name'              => $temporary[$i]->name,
                    'selling_price'    => $temporary[$i]->selling_price,
                    'qty'               => $temporary[$i]->qty,
                    'selling_id'       => $selling->id
                ]);

                $product = Product::where('user_id', auth()->user()->id)->where('barcode', $temporary[$i]->barcode)->first();
                $product->update([
                    'stock'   => $product->stock - $temporary[$i]->qty
                ]);
            }
            Selling_temporary_detail::where('user_id', auth()->user()->id)->delete();
            return redirect()->route('selling')->with('print', "print data!");
        } else {
            return redirect()->route('selling')->with('error', 'Data transaksi belum ada!');
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
            $temporary = Selling_temporary_detail::where('user_id', auth()->user()->id)
                ->where('barcode', $request->barcode)
                ->first();
            if ($temporary) {
                $temporary->update([
                    'qty'   => $temporary->qty + $request->qty
                ]);
            } else {
                Selling_temporary_detail::create([
                    'barcode'       => $product->barcode,
                    'name'          => $product->name,
                    'selling_price' => $product->selling_price,
                    'qty'           => $request->qty,
                    'user_id'       => auth()->user()->id
                ]);
            }

            return redirect()->route('selling');
        }
        return redirect()->route('selling');
    }

    public function temporaryDestroy(Selling_temporary_detail $selling_temporary_detail)
    {
        $selling_temporary_detail->delete();

        return redirect()->route('selling')->with('success', 'Data telah dihapus!');
    }

    public function temporaryUpdate(Request $request, Selling_temporary_detail $selling_temporary_detail)
    {
        $validation = Validator::make($request->all(), [
            'qty'        => 'required|numeric|min:0.1',
        ]);

        if ($validation->fails()) {
            return response()->json($validation->errors(), 422);
        }
        $selling_temporary_detail->update([
            'qty'               => $request->qty
        ]);
    }
}

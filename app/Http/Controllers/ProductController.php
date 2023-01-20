<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'Produk';
        $breadcrumb = [[
            'target' => route('dashboard'),
            'label'  => 'Dashboard'
        ], [
            'target' => '',
            'label'  => 'Produk'
        ]];

        $products = Product::orderBy('created_at', 'DESC')
            ->where('user_id', auth()->user()->id)
            ->get();

        $btn = [
            "label"     => "Tambah Produk",
            'target'    => route('product.create')
        ];

        $data = [
            'title'         => $title,
            'breadcrumb'    => $breadcrumb,
            'products'      => $products,
            'btn'           => $btn
        ];

        return view('product.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = 'Tambah Produk';
        $breadcrumb = [[
            'target' => route('dashboard'),
            'label'  => 'Dashboard'
        ], [
            'target' => route('product.index'),
            'label'  => 'Produk'
        ], [
            'target' => '',
            'label'  => 'Tambah'
        ]];

        $data = [
            'title'         => $title,
            'breadcrumb'    => $breadcrumb
        ];

        return view('product.create', compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->merge([
            'harga_beli' => str_replace(".", "", $request->harga_beli),
            'harga_jual' => str_replace(".", "", $request->harga_jual),
        ]);

        $validated = $request->validate([
            'barcode'   => 'required|max:50|unique:products,barcode',
            'nama'      => 'required|max:100|unique:products,name',
            'harga_beli'    => 'required|integer|min:0',
            'harga_jual'    => "required|integer|min:$request->harga_beli",
            'stok'          => 'required|integer|min:0'
        ]);

        // $purchase_price = str_replace(".", "", $request->harga_beli);
        // $selling_price = str_replace(".", "", $request->harga_jual);

        $validated['name'] = $request->nama;
        $validated['purchase_price'] = $request->harga_beli;
        $validated['selling_price'] = $request->harga_jual;
        $validated['stock'] = $request->stok;
        $validated['user_id'] = auth()->user()->id;

        Product::create($validated);

        return redirect()->route('product.index')->with('success', 'Data telah ditambahkan!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $title = "Ubah Produk '$product->name ($product->barcode)'";

        $breadcrumb = [[
            'target' => route('dashboard'),
            'label'  => 'Dashboard'
        ], [
            'target' => route('product.index'),
            'label'  => 'Produk'
        ], [
            'target' => '',
            'label'  => 'Edit'
        ]];

        $data = [
            'title'     => $title,
            'breadcrumb' => $breadcrumb,
            'product'   => $product
        ];

        return view('product.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $request->merge([
            'harga_beli' => str_replace(".", "", $request->harga_beli),
            'harga_jual' => str_replace(".", "", $request->harga_jual),
        ]);

        $validated = $request->validate([
            'barcode'   => "required|max:50|unique:products,barcode,$product->id,id",
            'nama'      => "required|max:100|unique:products,name,$product->id,id",
            'harga_beli'    => 'required|integer|min:0',
            'harga_jual'     => "required|integer|min:$request->harga_beli"
        ]);

        $validated['name'] = $request->nama;
        $validated['purchase_price'] = $request->harga_beli;
        $validated['selling_price'] = $request->harga_jual;
        $validated['user_id'] = auth()->user()->id;

        $product->update($validated);

        return redirect()->route('product.index')->with('success', 'Data telah diubah!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('product.index')->with('success', 'Data telah dihapus!');
    }
}

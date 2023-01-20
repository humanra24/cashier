@extends('base.index')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('product.update', ['product' => $data['product']->id]) }}" method="post">
                        @method('put')
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="barcode" class="form-label">Barcode<span
                                            class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="text" class="form-control @error('barcode') is-invalid @enderror"
                                            id="barcode" name="barcode" aria-describedby="barcodeHelp"
                                            value="{{ old('barcode', $data['product']->barcode) }}" />
                                        <button class="btn btn-outline-primary" id="generate" type="button"
                                            id="button-addon2">Generate</button>
                                    </div>
                                    @error('barcode')
                                        <div id="barcodeHelp" class="form-text text-danger">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="nama" class="form-label">Nama<span class="text-danger">*</span></label>
                                    <input type="text"
                                        class="form-control @error('nama')
                                        is-invalid
                                    @enderror"
                                        id="nama" name="nama" aria-describedby="namaHelp"
                                        value="{{ old('nama', $data['product']->name) }}" />
                                    @error('nama')
                                        <div id="namaHelp" class="form-text text-danger">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="harga_beli" class="form-label">Harga Beli<span
                                            class="text-danger">*</span></label>
                                    <input type="text"
                                        class="form-control price @error('harga_beli')
                                        is-invalid
                                    @enderror"
                                        id="harga_beli" name="harga_beli" aria-describedby="harga_beliHelp"
                                        value="{{ old('harga_beli', $data['product']->purchase_price) }}" />
                                    @error('harga_beli')
                                        <div id="harga_beliHelp" class="form-text text-danger">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="harga_jual" class="form-label">Harga Jual<span
                                            class="text-danger">*</span></label>
                                    <input type="text"
                                        class="form-control price @error('harga_jual')
                                        is-invalid
                                    @enderror"
                                        id="harga_jual" name="harga_jual" aria-describedby="harga_jualHelp"
                                        value="{{ old('harga_jual', $data['product']->selling_price) }}" />
                                    @error('harga_jual')
                                        <div id="harga_jualHelp" class="form-text text-danger">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="d-grid d-md-flex gap-2 mt-3">
                            <button type="submit" class="btn btn-primary">Ubah</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

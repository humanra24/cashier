@extends('base.index')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div id="alert">
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <strong>{{ session('success') }}</strong>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif
                    </div>
                    <div class="table-responsive">
                        <table id="dataTable" class="table table-striped" style="width:100%">
                            <thead>
                                <tr>
                                    <th data-orderable="false">Barcode</th>
                                    <th>Nama</th>
                                    <th class="text-nowrap">Harga Beli</th>
                                    <th class="text-nowrap">Harga Jual</th>
                                    <th class="text-nowrap text-center">Stok</th>
                                    <th class="text-nowrap">Tanggal Dibuat</th>
                                    <th class="text-nowrap">Tanggal Diubah</th>
                                    <th class="text-center" data-orderable="false">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data['products'] as $item)
                                    <tr>
                                        <td>{{ $item->barcode }}</td>
                                        <td>{{ $item->name }}</td>
                                        <td>Rp{{ number_format($item->purchase_price, 0, ',', '.') }}</td>
                                        <td>Rp{{ number_format($item->selling_price, 0, ',', '.') }}</td>
                                        <td class="text-nowrap text-center">{{ $item->stock }}</td>
                                        <td class="text-nowrap">{{ $item->created_at }}</td>
                                        <td class="text-nowrap">{{ $item->updated_at }}</td>
                                        <td class="d-flex justify-content-center">
                                            <a href="{{ route('product.edit', ['product' => $item->id]) }}"
                                                class="me-3 text-warning"><i class="fa-solid fa-pen-to-square"></i></a>
                                            <form class="deleteForm"
                                                action="{{ route('product.destroy', ['product' => $item->id]) }}"
                                                method="post">
                                                @method('delete')
                                                @csrf
                                                <button type="submit" class="text-danger bg-transparent border-0"><i
                                                        class="fa-solid fa-trash"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

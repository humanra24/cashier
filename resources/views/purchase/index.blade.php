@extends('base.index')

@section('content')
    <div id="alert">
        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>{{ session('error') }}</strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
    </div>
    <div class="row mb-3">
        <form action="{{ route('purchase-temporary.store') }}" method="post" class="col-md-6">
            @csrf
            <div class="row">
                <div class="col-9 col-md-6">
                    <div class="input-group">
                        <input type="text" class="form-control @error('barcode') is-invalid @enderror"
                            placeholder="Barcode" name="barcode" autofocus>
                        <button type="submit" class="btn btn-outline-primary" type="button" id="button-addon2"><i
                                class="fas fa-search"></i></button>
                    </div>
                    @error('barcode')
                        <div id="barcodeHelp" class="form-text text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-3 col-md-2">
                    <input type="number" class="form-control @error('qty') is-invalid @enderror" name="qty"
                        value="1">
                    @error('qty')
                        <div id="qtyHelp" class="form-text text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-4 my-3 my-md-0">
                    <a href="#" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#modalProduct">Cari
                        produk</a>
                </div>
            </div>
        </form>
        <div class="col-md-2">
            <form action="{{ route('purchase.store') }}" id="finish" method="post">
                @csrf
                <input type="hidden" name="total" value="{{ $data['total'] }}">
                <button type="submit" class="btn btn-primary">Selesai</button>
            </form>
        </div>
        <div class="col-md-4 text-md-end mt-3 mt-md-0">
            <h1>Rp{{ number_format($data['total'], 0, ',', '.') }}</h1>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="dataTable" class="table table-striped" style="width:100%">
                            <thead>
                                <tr>
                                    <th data-orderable="false">Barcode</th>
                                    <th data-orderable="false">Nama</th>
                                    <th class="text-nowrap" data-orderable="false">Harga</th>
                                    <th class="text-nowrap text-center" data-orderable="false">Qty</th>
                                    <th class="text-nowrap text-end" data-orderable="false">Subtotal</th>
                                    <th class="text-center" data-orderable="false">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data['temporary'] as $item)
                                    <tr>
                                        <td>{{ $item->barcode }}</td>
                                        <td>{{ $item->name }}</td>
                                        <td>Rp{{ number_format($item->purchase_price, 0, ',', '.') }}</td>
                                        <td class="text-center">{{ $item->qty }}</td>
                                        <td class="text-end">Rp{{ number_format($item->subtotal, 0, ',', '.') }}</td>
                                        <td class="d-flex justify-content-center">
                                            <a href="#" class="me-3 text-warning"
                                                onclick="edit({
                                                url:'{{ route('purchase-temporary.update', ['purchase_temporary_detail' => $item->id]) }}',
                                                name:'{{ $item->name }}',
                                                price:'{{ $item->purchase_price }}',
                                                qty:'{{ $item->qty }}'
                                            })"><i
                                                    class="fa-solid fa-pen-to-square"></i></a>
                                            <form class="deleteForm"
                                                action="{{ route('purchase-temporary.destroy', ['purchase_temporary_detail' => $item->id]) }}"
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

    {{-- modal produk --}}
    <div class="modal fade" id="modalProduct" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Produk</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table id="dataTable" class="table table-striped" style="width:100%">
                            <thead>
                                <tr>
                                    <th data-orderable="false">Barcode</th>
                                    <th data-orderable="false">Nama</th>
                                    <th class="text-nowrap" data-orderable="false">Harga</th>
                                    <th class="text-nowrap text-center" data-orderable="false">Stok</th>
                                    <th class="text-center" data-orderable="false">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data['product'] as $item)
                                    <tr>
                                        <td>{{ $item->barcode }}</td>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item->purchase_price }}</td>
                                        <td class="text-center">{{ $item->stock }}</td>
                                        <td class="d-flex justify-content-center">
                                            <form action="{{ route('purchase-temporary.store') }}" method="post">
                                                @csrf
                                                <input type="hidden" name="barcode" value="{{ $item->barcode }}">
                                                <input type="hidden" name="qty" value="1">
                                                <button type="submit" class="text-primary bg-transparent border-0">
                                                    <i class="fa-regular fa-hand-pointer fs-4"></i>
                                                </button>
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

    {{-- modal edit --}}
    <div class="modal fade" id="modalEdit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel"></h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form onsubmit="submitForm(this)" action="">
                    @method('put')
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="id">
                        <div class="mb-3">
                            <label for="harga" class="form-label">Harga Beli</label>
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon1">Rp</span>
                                <input type="text" class="form-control price" id="harga_beli" name="harga_beli"
                                    aria-describedby="harga_beliHelp" value="" />
                            </div>
                            <div id="harga_beliHelp" class="form-text text-danger"></div>
                        </div>
                        <div class="mb-3">
                            <label for="qty" class="form-label">Qty</label>
                            <input type="text" class="form-control" id="qty" name="qty">
                            <div id="qtyHelp" class="form-text text-danger"></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Ubah</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        function edit(data) {
            event.preventDefault();
            $('#modalEdit').modal('show');
            $('#modalEdit form').attr('action', data.url);
            $('#modalEdit .modal-title').html(
                `<strong>${data.name}</strong> <span class="badge bg-primary">${data.barcode}</span>`);
            $('#modalEdit .modal-body input[name=harga_beli]').val(formatRupiah(data.price))
            $('#modalEdit .modal-body input[name=qty]').val(data.qty)

            function formatRupiah(value) {
                let number_string = value.toString().replace(/[^,\d]/g, ""),
                    split = number_string.split(","),
                    sisa = split[0].length % 3,
                    rupiah = split[0].substr(0, sisa),
                    ribuan = split[0].substr(sisa).match(/\d{3}/gi);

                if (ribuan) {
                    separator = sisa ? "." : "";
                    rupiah += separator + ribuan.join(".");
                }

                rupiah = split[1] != undefined ? rupiah + "," + split[1] : rupiah;
                return rupiah;
            }
        }

        function submitForm(e) {
            event.preventDefault();
            $('#modalEdit form #harga_beliHelp').text('');
            $('#modalEdit form #qtyHelp').text('');
            let data = $(e).serialize();
            let url = $(e).attr('action');
            $.ajax({
                url: url,
                type: 'post',
                data: data,
                success: res => {
                    location.reload()
                },
                error: err => {
                    if (err.status == 422) {
                        $('#modalEdit form #harga_beliHelp').text(err.responseJSON.harga_beli);
                        $('#modalEdit form #qtyHelp').text(err.responseJSON.qty);
                    }
                }
            })
        }
    </script>
@endpush

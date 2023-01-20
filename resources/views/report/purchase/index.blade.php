@extends('base.index')

@push('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/themes/base/jquery-ui.min.css"
        integrity="sha512-ELV+xyi8IhEApPS/pSj66+Jiw+sOT1Mqkzlh8ExXihe4zfqbWkxPRi8wptXIO9g73FSlhmquFlUOuMSoXz5IRw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
@endpush

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="">
                        <div class="row mb-3 align-items-center">
                            <div class="col-md-3 mb-3">
                                <input id="tanggal_mulai" placeholder="masukkan tanggal Awal" type="text"
                                    class="form-control date @error('tanggal_mulai') is-invalid @enderror"
                                    name="tanggal_mulai" value="{{ old('tanggal_mulai', $data['start_date']) }}">
                                @error('tanggal_mulai')
                                    <div id="tanggal_mulaiHelp" class="form-text text-danger">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-md-3 mb-3">
                                <input id="tanggal_akhir" placeholder="masukkan tanggal Akhir" type="text"
                                    class="form-control date @error('tanggal_akhir') is-invalid @enderror"
                                    name="tanggal_akhir" value="{{ old('tanggal_akhir', $data['end_date']) }}">
                                @error('tanggal_akhir')
                                    <div id="tanggal_makhirHelp" class="form-text text-danger">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-md-2 d-grid mb-3">
                                <button type="submit" class="btn btn-primary">Cari</button>
                            </div>
                        </div>
                    </form>
                    <div class="table-responsive">
                        <div class="table-responsive">
                            <table id="dataTable" class="table table-striped" style="width:100%">
                                <thead>
                                    <tr>
                                        <th data-orderable="false">Id</th>
                                        <th>Total</th>
                                        <th class="text-nowrap">Tanggal Dibuat</th>
                                        <th class="text-center" data-orderable="false">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data['report'] as $item)
                                        <tr>
                                            <td>{{ $item->code }}</td>
                                            <td>{{ number_format($item->total, 0, ',', '.') }}</td>
                                            <td>{{ $item->created_at }}</td>
                                            <td class="text-center">
                                                <a href="{{ route('report.purchase.detail', ['code' => $item->code]) }}"
                                                    class="text-primary">
                                                    <i class="fas fa-eye"></i>
                                                </a>
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
    </div>
@endsection

@push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/jquery-ui.min.js"
        integrity="sha512-57oZ/vW8ANMjR/KQ6Be9v/+/h6bq9/l3f0Oc7vn6qMqyhvPd1cvKBRWWpzu0QoneImqr2SkmO4MSqU+RpHom3Q=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        $(".date").datepicker({
            dateFormat: "dd-mm-yy"
        });
    </script>
@endpush

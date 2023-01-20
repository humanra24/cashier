@extends('base.index')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="text-center text-md-end">
                        <a target="_blank" href="{{ route('report.selling.print', ['code' => $data['report']->code]) }}"><i
                                class="fas fa-print fs-3 my-3"></i></a>
                    </div>
                    <div class="table-responsive">
                        <div class="table-responsive">
                            <table id="dataTable" class="table table-striped" style="width:100%">
                                <thead>
                                    <tr>
                                        <th data-orderable="false">Barcode</th>
                                        <th class="text-nowrap">Name</th>
                                        <th class="text-nowrap">Harga</th>
                                        <th class="text-nowrap text-center">qty</th>
                                        <th class="text-end">SubTotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data['report']->details as $item)
                                        <tr>
                                            <td class="text-nowrap">{{ $item->barcode }}</td>
                                            <td class="text-nowrap">{{ $item->name }}</td>
                                            <td class="text-nowrap">
                                                Rp{{ number_format($item->selling_price, 0, ',', '.') }}</td>
                                            <td class="text-nowrap text-center">{{ $item->qty }}</td>
                                            <td class="text-end">{{ $item->qty * $item->selling_price }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="4" class="text-end">Total</td>
                                        <td class="text-end">{{ number_format($data['report']->total, 0, ',', '.') }}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="4" class="text-end">Bayar</td>
                                        <td class="text-end">{{ number_format($data['report']->money, 0, ',', '.') }}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="4" class="text-end">Kembali</td>
                                        <td class="text-end">{{ number_format($data['report']->change, 0, ',', '.') }}</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

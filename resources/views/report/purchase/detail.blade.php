@extends('base.index')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <div class="table-responsive">
                            <table id="dataTable" class="table table-striped" style="width:100%">
                                <thead>
                                    <tr>
                                        <th data-orderable="false">Barcode</th>
                                        <th class="text-nowrap">Name</th>
                                        <th class="text-nowrap">Harga</th>
                                        <th class="text-nowrap text-center">qty</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data['report']->details as $item)
                                        <tr>
                                            <td class="text-nowrap">{{ $item->barcode }}</td>
                                            <td class="text-nowrap">{{ $item->name }}</td>
                                            <td class="text-nowrap">
                                                Rp{{ number_format($item->purchase_price, 0, ',', '.') }}</td>
                                            <td class="text-nowrap text-center">{{ $item->qty }}</td>
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

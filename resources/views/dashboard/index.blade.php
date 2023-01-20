@extends('base.index')

@section('content')
    <div class="row">
        <div class="col-md-3 mb-3">
            <div class="card">
                <div class="card-header">Transaksi Pembelian hari ini</div>
                <div class="card-body">
                    <h3>{{ $data['purchase']['count'] }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card">
                <div class="card-header">Transaksi Penjualan hari ini</div>
                <div class="card-body">
                    <h3>{{ $data['selling']['count'] }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card">
                <div class="card-header">Total Pembelian hari ini</div>
                <div class="card-body">
                    <h3>{{ number_format($data['purchase']['total'], 0, ',', '.') }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card">
                <div class="card-header">Total Penjualan hari ini</div>
                <div class="card-body">
                    <h3>{{ number_format($data['selling']['total'], 0, ',', '.') }}</h3>
                </div>
            </div>
        </div>
    </div>
@endsection

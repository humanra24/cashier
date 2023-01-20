<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Nota Penjualan</title>
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Courier+Prime:wght@400;700&display=swap" rel="stylesheet">
    <style>
        @page {
            margin: 3mm
        }

        body {
            margin: 0;
            font-size: 11px;
            color: #000000;
        }

        /** Fix for Chrome issue #273306 **/
        @media print {
            body {
                width: 58mm;
            }
        }
    </style>
</head>

<body style="font-family: 'Courier Prime', monospace;">
    <div class="text-center" style="font-weight: 700;">** {{ $data['store']['name'] }} **</div>
    <div class="text-center">{{ $data['store']['address'] }}</div>
    =================================
    <div class="ms-2">
        No: {{ $data['transaction']->code }}
    </div>
    <div class="ms-2">
        Tgl: {{ Carbon\Carbon::parse($data['transaction']->created_at)->format('d/m/Y') }}
    </div>
    =================================
    <table class="table" style="color: #000000; border-color: #000000; line-height:10px;">
        <thead>
            <td>Produk</td>
            <td>Harga</td>
            <td class="text-center">Qty</td>
            <td class="text-end">Sub</td>
        </thead>
        <tbody>
            @foreach ($data['transaction']->details as $item)
                <tr>
                    <td>{{ $item->name }}</td>
                    <td>{{ number_format($item->selling_price, 0, ',', '.') }}</td>
                    <td class="text-center">{{ $item->qty }}</td>
                    <td class="text-end">{{ number_format($item->qty * $item->selling_price, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr style="border: transparent;">
                <td colspan="4" class="text-end">Total
                    {{ number_format($data['transaction']->total, 0, ',', '.') }}</td>
            </tr>
            <tr style="border: transparent">
                <td colspan="4" class="text-end">Bayar
                    {{ number_format($data['transaction']->money, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td colspan="4" class="text-end">Kembali
                    {{ number_format($data['transaction']->change, 0, ',', '.') }}</td>
            </tr>
        </tfoot>
    </table>
    <div class="text-center">Terimakasih <br> Atas Kepercayaan Anda.</div>

    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <script>
        window.print();
        window.addEventListener('afterprint', (event) => {
            window.close();
        });
    </script>
</body>

</html>

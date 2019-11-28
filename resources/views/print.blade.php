<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://fonts.googleapis.com/css?family=VT323&display=swap" rel="stylesheet">
    <title>Struk</title>
    <style>
        body {
            font-family: 'VT323', monospace;
            font-size: 23px;
        }
    </style>
</head>
<body onload="window.print()">
    <center>
        Jl. Tukad Banyu Sari No.74a, Sesetan, <br> Kec. Denpasar Sel., Kota Denpasar, Bali <br> 80223
    </center>

    <table border="0" width=100%>
        <thead>
            <tr >
                <td style="border: 0.5px; border-style: dashed; border-left: none; border-right: none" colspan="3">Bon {{ $transaction->created_at->format('d.m.y h:i:s') }} </td>
                <td style="border: 0.5px; border-style: dashed; border-left: none; border-right: none" align="right">KASIR : {{ substr($transaction->user->name, 0, 7) }}</td>
            </tr>
        </thead>
        <tbody>
            @foreach ($transaction->transactionDetail as $row)
                <tr>
                    <td style="word-break: break-all">{{ $row->product->title }}</td>
                    <td>{{ $row->qty }}</td>
                    <td align="right">{{ number_format($row->product->price) }}</td>
                    <td align="right">{{ number_format($row->subtotal) }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td style="border: 0.5px; border-style: dashed; border-left: none; border-right: none; border-bottom: none">Total item </td>
                <td style="border: 0.5px; border-style: dashed; border-left: none; border-right: none; border-bottom: none">{{ number_format($total_qty) }}</td>
                <td style="border: 0.5px; border-style: dashed; border-left: none; border-right: none; border-bottom: none" align="right"></td>
                <td style="border: 0.5px; border-style: dashed; border-left: none; border-right: none; border-bottom: none" align="right">{{ number_format($transaction->subtotal) }}</td>
            </tr>
            <tr>
                <td>Total Disc</td>
                <td align="right"></td>
                <td align="right"></td>
                <td align="right">({{ $transaction->discount }}%) {{ number_format($transaction->discount_harga) }}</td>
            </tr>
            <tr>
                <td style="border: 0.5px; border-style: dashed; border-left: none; border-right: none; border-top: none">Total Belanja </td>
                <td style="border: 0.5px; border-style: dashed; border-left: none; border-right: none; border-top: none" align="right"></td>
                <td style="border: 0.5px; border-style: dashed; border-left: none; border-right: none; border-top: none" align="right"></td>
                <td style="border: 0.5px; border-style: dashed; border-left: none; border-right: none; border-top: none" align="right">{{ number_format($transaction->total) }}</td>
            </tr>
        </tfoot>
    </table>
    <br>
    <center>
        Terima kasih <br> Selamat berbelanja kembali.
    </center>
</body>
</html>

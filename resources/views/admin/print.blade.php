<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Struk Order {{ $order->order_code }}</title>

    <style>
        body {
            font-family: monospace;
            width: 300px;
            margin: auto;
        }

        h2,
        h4 {
            text-align: center;
            margin: 0;
        }

        hr {
            border: 1px dashed #000;
        }

        table {
            width: 100%;
            font-size: 12px;
        }

        td {
            padding: 2px 0;
        }

        .right {
            text-align: right;
        }

        .center {
            text-align: center;
        }
    </style>
</head>

<body onload="window.print()">

    <h2>ECOMMERCE</h2>
    <h4>STRUK PEMBELIAN</h4>

    <hr>

    <table>
        <tr>
            <td>Order</td>
            <td class="right">{{ $order->order_code }}</td>
        </tr>
        <tr>
            <td>Tanggal</td>
            <td class="right">{{ $order->created_at->format('d/m/Y H:i') }}</td>
        </tr>
        <tr>
            <td>Customer</td>
            <td class="right">{{ $order->user->name }}</td>
        </tr>
    </table>

    <hr>

    <table>
        @foreach($order->items as $item)
        <tr>
            <td colspan="2">{{ $item->product->name }}</td>
        </tr>
        <tr>
            <td>{{ $item->qty }} x {{ number_format($item->price,0,',','.') }}</td>
            <td class="right">
                {{ number_format($item->qty * $item->price,0,',','.') }}
            </td>
        </tr>
        @endforeach
    </table>

    <hr>

    <table>
        <tr>
            <td><strong>Total</strong></td>
            <td class="right">
                <strong>Rp {{ number_format($order->total_price,0,',','.') }}</strong>
            </td>
        </tr>
        <tr>
            <td>Status</td>
            <td class="right">{{ strtoupper($order->payment_status) }}</td>
        </tr>
    </table>

    <hr>

    <p class="center">
        Terima kasih 🙏<br>
        Barang yang sudah dibeli<br>
        tidak dapat dikembalikan
    </p>

</body>

</html>
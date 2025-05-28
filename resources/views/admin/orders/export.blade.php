<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Pesanan</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #000; padding: 5px; text-align: left; }
        h2 { margin-top: 30px; }
    </style>
</head>
<body>
    <h1>Laporan Pesanan</h1>

    @foreach ($batches as $batch)
        <h2>Batch #{{ $batch->id }} - {{ $batch->user->name }}</h2>
        <p>Status: {{ ucfirst($batch->status) }} | Total: Rp{{ number_format($batch->total_price, 0, ',', '.') }}</p>

        <table>
            <thead>
                <tr>
                    <th>Produk</th>
                    <th>Kuantitas</th>
                    <th>Harga</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($batch->orders as $order)
                    <tr>
                        <td>{{ $order->product->name }}</td>
                        <td>{{ $order->quantity }}</td>
                        <td>Rp{{ number_format($order->total_price, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endforeach
</body>
</html>

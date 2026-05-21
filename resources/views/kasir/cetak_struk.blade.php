<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk {{ $order->order_number }}</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 20px; color: #000; }
        .receipt { max-width: 380px; margin: 0 auto; }
        .receipt h1, .receipt h2 { margin: 0; text-align: center; }
        .receipt p { margin: 4px 0; }
        .divider { border-top: 1px dashed #000; margin: 10px 0; }
        .items { width: 100%; border-collapse: collapse; margin-top: 8px; }
        .items th, .items td { padding: 6px 0; text-align: left; }
        .items th { font-size: 12px; }
        .items td { font-size: 13px; }
        .total { font-weight: bold; margin-top: 10px; }
        .footer { margin-top: 14px; text-align: center; font-size: 12px; }
        @media print { body { padding: 0; } .no-print { display: none; } }
    </style>
</head>
<body onload="window.print()">
    <div class="receipt">
        <h1>RUMAH CAKE SUPREZZ</h1>
        <p>NMID: ID1023273333469</p>
        <p>A01</p>
        <div class="divider"></div>
        <p><strong>No. Struk:</strong> {{ $order->order_number }}</p>
        <p><strong>Tanggal:</strong> {{ $order->created_at->format('d/m/Y H:i') }}</p>
        <p><strong>Nama:</strong> {{ $order->customer_name }}</p>
        @if($order->no_whatsapp)
            <p><strong>WA:</strong> {{ $order->no_whatsapp }}</p>
        @endif
        <p><strong>Metode:</strong> {{ $order->payment_method === 'tunai' ? 'Tunai' : ucfirst($order->payment_method) }}</p>
        <div class="divider"></div>
        <table class="items">
            <thead>
                <tr>
                    <th>Item</th>
                    <th style="text-align:right;">Jumlah</th>
                    <th style="text-align:right;">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->items as $item)
                    <tr>
                        <td>{{ \Illuminate\Support\Str::limit($item->menu->name, 24) }}</td>
                        <td style="text-align:right;">{{ $item->quantity }}</td>
                        <td style="text-align:right;">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="divider"></div>
        <p class="total">Total: Rp {{ number_format($order->total_amount, 0, ',', '.') }}</p>
        @if($order->notes)
            <p><strong>Catatan:</strong> {{ $order->notes }}</p>
        @endif
        <div class="divider"></div>
        <p class="footer">Terima kasih telah berbelanja!</p>
        <p class="footer">www.rumahcakesuprezz.id</p>
        <div class="no-print" style="text-align:center; margin-top: 20px;">
            <button onclick="window.print()" style="padding: 8px 14px; background: #111; color: #fff; border:none; border-radius:6px; cursor:pointer;">Cetak Ulang</button>
        </div>
    </div>
</body>
</html>

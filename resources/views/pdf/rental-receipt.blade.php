<!doctype html>
<html lang="ms">
<head>
    <meta charset="utf-8">
    <title>{{ $receipt->receipt_number }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Helvetica', 'Arial', sans-serif; font-size: 12px; line-height: 1.5; color: #1a1a2e; padding: 0; }
        @page { size: A5; margin: 16px; }

        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #f0ad4e; padding-bottom: 12px; }
        .header h1 { font-size: 20px; font-weight: 800; color: #d35400; margin-bottom: 2px; }
        .header p { font-size: 10px; color: #666; }

        .title { text-align: center; margin-bottom: 16px; }
        .title span { font-size: 14px; font-weight: 700; text-transform: uppercase; letter-spacing: 2px; color: #d35400; border: 2px solid #d35400; padding: 4px 24px; border-radius: 4px; }

        .info { display: flex; gap: 16px; margin-bottom: 16px; }
        .info .left { flex: 1; }
        .info .right { text-align: right; font-size: 10px; }
        .info .left strong { font-size: 10px; text-transform: uppercase; color: #999; display: block; margin-bottom: 2px; }
        .info .left span { display: block; font-size: 13px; font-weight: 600; }

        table { width: 100%; border-collapse: collapse; margin-bottom: 16px; }
        thead th { font-size: 10px; text-transform: uppercase; font-weight: 700; color: #999; padding: 8px 6px; border-bottom: 2px solid #f0ad4e; text-align: left; }
        thead th:last-child { text-align: right; }
        tbody td { padding: 8px 6px; font-size: 11px; border-bottom: 1px solid #eee; vertical-align: top; }
        tbody td:last-child { text-align: right; font-weight: 600; }
        tbody td .label { font-size: 9px; color: #888; }
        tbody td .value { font-weight: 600; font-size: 13px; }

        .totals { border-top: 2px solid #f0ad4e; padding-top: 8px; }
        .totals .row { display: flex; justify-content: space-between; padding: 3px 0; font-size: 12px; }
        .totals .row.total { font-size: 16px; font-weight: 800; color: #d35400; border-bottom: 2px solid #d35400; padding-bottom: 6px; }
        .totals .row.balance { margin-top: 8px; font-size: 14px; font-weight: 700; }

        .footer { margin-top: 24px; text-align: center; font-size: 9px; color: #aaa; border-top: 1px solid #eee; padding-top: 8px; }
    </style>
</head>
<body>

    <div class="header">
        <h1>BARAKAH TRANSPORT</h1>
        <p>No. 123, Jalan Contoh, 50000 Kuala Lumpur | +60 12-345 6789 | admin@barakahtransport.com</p>
    </div>

    <div class="title"><span>Resit Rasmi</span></div>

    <div class="info">
        <div class="left">
            <strong>Kepada</strong>
            <span>{{ $receipt->customer_name }}</span>
            <span style="font-weight:400;font-size:11px;">{{ $receipt->customer_phone }}</span>
        </div>
        <div class="right">
            <strong style="color:#999;">No. Resit:</strong> {{ $receipt->receipt_number }}<br>
            <strong style="color:#999;">Tarikh:</strong> {{ $receipt->created_at->format('d/m/Y') }}<br>
            <strong style="color:#999;">Bayaran:</strong> {{ match($receipt->payment_method) { 'cash' => 'Tunai', 'transfer' => 'Bank Transfer', 'card' => 'Kad', default => $receipt->payment_method } }}
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Perihal</th>
                <th style="text-align:center">Tempoh</th>
                <th style="text-align:center">Harga</th>
                <th style="text-align:right">Jumlah</th>
            </tr>
        </thead>
        <tbody>
            @foreach($receipt->items as $item)
            <tr>
                <td>
                    <div class="value">Sewaan {{ ucfirst($item->category) }}</div>
                    <div class="label">Model: {{ $item->model_unit }}</div>
                    @if($item->quantity > 1)<div class="label">Kuantiti: {{ $item->quantity }}</div>@endif
                    <div class="label">{{ $item->start_date->format('d/m/Y') }} → {{ $item->end_date->format('d/m/Y') }}</div>
                </td>
                <td style="text-align:center">{{ $item->duration_days }} Hari</td>
                <td style="text-align:center">{{ number_format($item->price_per_day, 2) }}{{ $item->price_type === 'flat' ? ' (Tetap)' : '' }}</td>
                <td style="text-align:right">{{ number_format($item->total_price, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="totals">
        <div class="row"><span>Jumlah Keseluruhan</span><span>RM {{ number_format($receipt->total_amount, 2) }}</span></div>
        <div class="row"><span>Deposit Dibayar</span><span>- RM {{ number_format($receipt->deposit_amount, 2) }}</span></div>
        <div class="row balance"><span>BAKI PERLU DIBAYAR</span><span>RM {{ number_format($receipt->balance_amount, 2) }}</span></div>
    </div>

    <div class="footer">
        Resit ini adalah cetakan komputer dan tidak memerlukan tandatangan. | Dicetak: {{ date('d/m/Y H:i') }}
    </div>

</body>
</html>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Resit: {{ $receipt->receipt_number }}</title>
    <style>
        body { font-family: sans-serif; font-size: 13px; line-height: 1.45; color: #333; margin: 0; padding: 20px; }
        @page { size: A5; margin: 16px; }

        .header { text-align: center; margin-bottom: 28px; border-bottom: 2px solid #eee; padding-bottom: 18px; }
        .logo { font-size: 22px; font-weight: bold; color: #556ee6; margin-bottom: 4px; }
        .company-info { font-size: 11px; color: #555; }

        .receipt-info { margin-bottom: 28px; overflow: hidden; }
        .receipt-title { float: right; font-size: 16px; color: #888; text-transform: uppercase; letter-spacing: 1px; font-weight: bold; }
        .info-left { float: left; width: 50%; }
        .info-right { float: right; width: 40%; text-align: right; }
        .info-left strong, .info-right strong { display: block; margin-bottom: 2px; }

        table { width: 100%; border-collapse: collapse; margin-bottom: 28px; }
        th { background: #f8f9fa; padding: 9px 10px; text-align: left; border-bottom: 2px solid #ddd; font-size: 11px; text-transform: uppercase; color: #666; }
        td { padding: 9px 10px; border-bottom: 1px solid #eee; font-size: 12px; vertical-align: top; }
        tfoot td { padding: 10px; }
        .total-row td { font-weight: bold; font-size: 15px; border-top: 2px solid #ddd; background: #fffbe6; }

        .disclaimer { margin-top: 40px; font-size: 11px; color: #888; }
        .footer { position: fixed; bottom: 0; left: 0; right: 0; text-align: center; font-size: 10px; color: #aaa; border-top: 1px solid #eee; padding-top: 8px; }
    </style>
</head>
<body>

    <div class="header">
        <div class="logo">BARAKAH TRANSPORT</div>
        <div class="company-info">
            No. 123, Jalan Contoh, 50000 Kuala Lumpur<br>
            Tel: +60 12-345 6789 | Email: admin@barakahtransport.com
        </div>
    </div>

    <div class="receipt-info">
        <div class="receipt-title">RESIT RASMI</div>

        <div class="info-left">
            <strong>KEPADA:</strong>
            {{ $receipt->customer_name }}<br>
            {{ $receipt->customer_phone }}
        </div>

        <div class="info-right">
            <strong>No. Resit:</strong> {{ $receipt->receipt_number }}<br>
            <strong>Tarikh:</strong> {{ $receipt->created_at->format('d/m/Y') }}<br>
            <strong>Bayaran:</strong> {{ match($receipt->payment_method) { 'cash' => 'Tunai', 'transfer' => 'Bank Transfer', 'card' => 'Kad', default => $receipt->payment_method } }}
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Perihal</th>
                <th style="text-align:center">Tempoh</th>
                <th style="text-align:right">Harga Sehari</th>
                <th style="text-align:right">Jumlah</th>
            </tr>
        </thead>
        <tbody>
            @foreach($receipt->items as $item)
            <tr>
                <td>
                    <strong>Sewaan {{ ucfirst($item->category) }}</strong><br>
                    Model/Unit: {{ $item->model_unit }}<br>
                    <small>Dari {{ $item->start_date->format('d/m/Y') }} hingga {{ $item->end_date->format('d/m/Y') }}</small>
                </td>
                <td style="text-align:center">{{ $item->duration_days }} Hari</td>
                <td style="text-align:right">
                    {{ number_format($item->price_per_day, 2) }}
                    @if($item->price_type == 'flat')
                        (Tetap)
                    @elseif($item->quantity > 1)
                        (x{{ $item->quantity }})
                    @endif
                </td>
                <td style="text-align:right">{{ number_format($item->total_price, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3" style="text-align:right"><strong>Jumlah Keseluruhan (MYR)</strong></td>
                <td style="text-align:right"><strong>{{ number_format($receipt->total_amount, 2) }}</strong></td>
            </tr>
            <tr>
                <td colspan="3" style="text-align:right">Deposit Dibayar</td>
                <td style="text-align:right">- {{ number_format($receipt->deposit_amount, 2) }}</td>
            </tr>
            <tr class="total-row">
                <td colspan="3" style="text-align:right">Baki Perlu Dibayar</td>
                <td style="text-align:right">{{ number_format($receipt->balance_amount, 2) }}</td>
            </tr>
        </tfoot>
    </table>

    <div class="disclaimer">
        <em>Resit ini adalah cetakan komputer dan tidak memerlukan tandatangan.</em>
    </div>

    <div class="footer">
        Dicetak pada {{ date('d/m/Y H:i:s') }}
    </div>

</body>
</html>

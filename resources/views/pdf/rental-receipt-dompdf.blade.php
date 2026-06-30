<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <title>Resit #{{ $receipt->receipt_number }}</title>
    <style>
        body { font-family: 'Helvetica', 'Arial', sans-serif; font-size: 12px; color: #2c3e50; margin: 0; padding: 0; }
        @page { size: A4 portrait; margin: 15mm 20mm; }

        table { border-collapse: collapse; }

        .header-table { width: 100%; border-bottom: 2px solid #6a1b24; margin-bottom: 20px; }
        .header-table td { padding-bottom: 15px; vertical-align: middle; }
        .company-name { font-size: 20px; font-weight: 800; color: #6a1b24; text-transform: uppercase; margin: 0; letter-spacing: 0.5px; }
        .company-sub { margin: 5px 0 0; font-size: 12px; color: #555; }

        .title-bar { background-color: #6a1b24; color: #fff; text-align: center; padding: 8px 0; font-size: 16px; font-weight: bold; letter-spacing: 2px; text-transform: uppercase; margin-bottom: 25px; -webkit-print-color-adjust: exact; print-color-adjust: exact; }

        .info-grid-table { width: 100%; margin-bottom: 30px; }
        .info-grid-table td { width: 48%; vertical-align: top; }
        .info-grid-table td.spacer { width: 4%; }
        .info-box h3 { font-size: 14px; color: #6a1b24; border-bottom: 1px solid #d4af37; padding-bottom: 5px; margin-top: 0; margin-bottom: 10px; text-transform: uppercase; }
        .info-table { width: 100%; border-collapse: collapse; }
        .info-table td { padding: 4px 0; vertical-align: top; }
        .label { font-weight: 600; color: #666; width: 90px; }

        .item-table { width: 100%; border-collapse: collapse; margin-bottom: 30px; }
        .item-table th { background-color: #6a1b24; color: #fff; padding: 12px 10px; text-align: left; font-weight: 600; text-transform: uppercase; font-size: 11px; border: 1px solid #6a1b24; -webkit-print-color-adjust: exact; print-color-adjust: exact; }
        .item-table td { padding: 12px 10px; border: 1px solid #ddd; color: #333; }
        .col-center { text-align: center; }
        .col-right { text-align: right; }

        .totals-wrap-table { width: 100%; margin-bottom: 50px; }
        .totals-table { width: 350px; border-collapse: collapse; }
        .totals-table td { padding: 8px 10px; border-bottom: 1px solid #eee; }
        .total-label { text-align: right; font-weight: 600; color: #555; }
        .total-value { text-align: right; font-weight: 700; color: #333; }
        .row-balance { background-color: #fff3cd; border-top: 2px solid #d4af37; -webkit-print-color-adjust: exact; print-color-adjust: exact; }
        .row-balance .total-label { color: #6a1b24; font-size: 14px; padding-top: 15px; padding-bottom: 15px; }
        .row-balance .total-value { color: #6a1b24; font-size: 18px; font-weight: 900; padding-top: 15px; padding-bottom: 15px; }

        .footer { text-align: center; font-size: 11px; color: #888; border-top: 1px solid #eee; padding-top: 20px; }
        .thank-you { font-size: 14px; font-weight: bold; color: #6a1b24; margin-bottom: 5px; font-style: italic; }
    </style>
</head>
<body>

    <table class="header-table">
        <tr>
            <td style="width: 50%; text-align: left;"><img src="{{ public_path('images/barakah-transport-logo.jpg') }}" width="100" height="100" alt="Logo"></td>
            <td style="width: 50%; text-align: right;">
                <div class="company-name">Barakah Transport & Cengal Homestay</div>
                <div class="company-sub">32300 Pulau Pangkor, Perak, Malaysia<br>Telefon: 013-463 2056<br>Email: admin@barakahtransport.com</div>
            </td>
        </tr>
    </table>

    <div class="title-bar">Resit Rasmi</div>

    <table class="info-grid-table">
        <tr>
            <td class="info-box">
                <h3>Maklumat Pelanggan</h3>
                <table class="info-table">
                    <tr><td class="label">Nama:</td><td><strong>{{ $receipt->customer_name }}</strong></td></tr>
                    <tr><td class="label">No. Telefon:</td><td>{{ $receipt->customer_phone }}</td></tr>
                    <tr><td class="label">Kaedah:</td><td>{{ match($receipt->payment_method) { 'cash' => 'Tunai', 'transfer' => 'Bank Transfer', 'card' => 'Kad', default => ucfirst($receipt->payment_method) } }}</td></tr>
                </table>
            </td>
            <td class="spacer"></td>
            <td class="info-box">
                <h3>Maklumat Resit</h3>
                <table class="info-table">
                    <tr><td class="label">No. Resit:</td><td><strong>{{ $receipt->receipt_number }}</strong></td></tr>
                    <tr><td class="label">Tarikh:</td><td>{{ $receipt->created_at->format('d/m/Y') }}</td></tr>
                    <tr><td class="label">Masa:</td><td>{{ $receipt->created_at->format('H:i A') }}</td></tr>
                </table>
            </td>
        </tr>
    </table>

    <table class="item-table">
        <thead>
            <tr>
                <th style="width:5%;text-align:center">No</th>
                <th style="width:50%">Butiran & Deskripsi</th>
                <th style="width:10%;text-align:center">Unit</th>
                <th style="width:15%;text-align:right">Kadar (RM)</th>
                <th style="width:20%;text-align:right">Jumlah (RM)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($receipt->items as $index => $item)
            <tr>
                <td class="col-center">{{ $index + 1 }}</td>
                <td>
                    <span style="font-weight:bold;color:#6a1b24;">{{ ucfirst($item->category) }}</span> - {{ $item->model_unit }}
                    <div style="font-size:11px;color:#666;margin-top:4px;">{{ $item->start_date->format('d/m/Y') }} - {{ $item->end_date->format('d/m/Y') }}<br><em>(Durasi: {{ $item->duration_days }} Hari)</em></div>
                </td>
                <td class="col-center">{{ $item->quantity }}</td>
                <td class="col-right">{{ number_format($item->price_per_day, 2) }}</td>
                <td class="col-right"><strong>{{ number_format($item->total_price, 2) }}</strong></td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <table class="totals-wrap-table">
        <tr>
            <td></td>
            <td style="width: 350px;">
                <table class="totals-table">
                    <tr><td class="total-label">Jumlah Keseluruhan</td><td class="total-value">{{ number_format($receipt->total_amount, 2) }}</td></tr>
                    <tr><td class="total-label">Deposit</td><td class="total-value" style="color:#d63031;">- {{ number_format($receipt->deposit_amount, 2) }}</td></tr>
                    <tr class="row-balance"><td class="total-label">BAKI PERLU DIBAYAR</td><td class="total-value">RM {{ number_format($receipt->balance_amount, 2) }}</td></tr>
                </table>
            </td>
        </tr>
    </table>

    <div class="footer">
        <div class="thank-you">Terima kasih kerana memilih Barakah Transport!</div>
        <div>Resit ini adalah cetakan komputer dan sah tanpa tandatangan.</div>
    </div>

</body>
</html>

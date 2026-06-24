<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resit #{{ $receipt->receipt_number }}</title>
    <style>
        :root {
            --primary-maroon: #6a1b24;
            --accent-gold: #d4af37;
            --text-dark: #2c3e50;
            --text-light: #ffffff;
            --bg-light: #f8f9fa;
        }

        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            font-size: 12px;
            color: var(--text-dark);
            margin: 0;
            padding: 0;
            background-color: #eee;
        }

        .receipt-page {
            width: 210mm;
            min-height: 297mm;
            background: white;
            margin: 20px auto;
            padding: 15mm 20mm;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            position: relative;
            box-sizing: border-box;
            overflow: hidden;
        }

        .watermark {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-45deg);
            width: 80%;
            opacity: 0.03;
            z-index: 0;
            pointer-events: none;
        }

        .header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
            position: relative;
            z-index: 1;
            border-bottom: 2px solid var(--primary-maroon);
            padding-bottom: 15px;
        }

        .logo-section img {
            max-width: 140px;
            height: auto;
        }

        .company-details {
            text-align: right;
        }

        .company-name {
            font-size: 20px;
            font-weight: 800;
            color: var(--primary-maroon);
            text-transform: uppercase;
            margin: 0;
            letter-spacing: 0.5px;
        }

        .company-sub {
            margin: 5px 0 0;
            font-size: 12px;
            color: #555;
            line-height: 1.4;
        }

        .title-bar {
            background-color: var(--primary-maroon);
            color: var(--text-light);
            text-align: center;
            padding: 8px 0;
            font-size: 16px;
            font-weight: bold;
            letter-spacing: 2px;
            text-transform: uppercase;
            margin-bottom: 25px;
            border-radius: 4px;
            position: relative;
            z-index: 1;
        }

        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 40px;
            margin-bottom: 30px;
            position: relative;
            z-index: 1;
        }

        .info-box h3 {
            font-size: 14px;
            color: var(--primary-maroon);
            border-bottom: 1px solid var(--accent-gold);
            padding-bottom: 5px;
            margin-top: 0;
            margin-bottom: 10px;
            text-transform: uppercase;
        }

        .info-table {
            width: 100%;
            border-collapse: collapse;
        }

        .info-table td {
            padding: 4px 0;
            vertical-align: top;
        }

        .label {
            font-weight: 600;
            color: #666;
            width: 90px;
        }

        .item-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
            position: relative;
            z-index: 1;
        }

        .item-table th {
            background-color: var(--primary-maroon);
            color: var(--text-light);
            padding: 12px 10px;
            text-align: left;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 11px;
            border: 1px solid var(--primary-maroon);
        }

        .item-table td {
            padding: 12px 10px;
            border: 1px solid #ddd;
            color: #333;
        }

        .item-table tr:nth-child(even) {
            background-color: #f8f9fa;
        }

        .item-table tr:hover {
            background-color: #fff8f8;
        }

        .col-center { text-align: center; }
        .col-right { text-align: right; }

        .totals-container {
            display: flex;
            justify-content: flex-end;
            position: relative;
            z-index: 1;
        }

        .totals-table {
            width: 350px;
            border-collapse: collapse;
        }

        .totals-table td {
            padding: 8px 10px;
            border-bottom: 1px solid #eee;
        }

        .total-label {
            text-align: right;
            font-weight: 600;
            color: #555;
        }

        .total-value {
            text-align: right;
            font-weight: 700;
            color: #333;
        }

        .row-deposit .total-value {
            color: #d63031;
        }

        .row-balance {
            background-color: #fff3cd;
            border-top: 2px solid var(--accent-gold);
        }

        .row-balance .total-label {
            color: var(--primary-maroon);
            font-size: 14px;
            padding-top: 15px;
            padding-bottom: 15px;
        }

        .row-balance .total-value {
            color: var(--primary-maroon);
            font-size: 18px;
            font-weight: 900;
            padding-top: 15px;
            padding-bottom: 15px;
        }

        .footer {
            margin-top: 50px;
            text-align: center;
            font-size: 11px;
            color: #888;
            border-top: 1px solid #eee;
            padding-top: 20px;
            position: relative;
            z-index: 1;
        }

        .thank-you {
            font-size: 14px;
            font-weight: bold;
            color: var(--primary-maroon);
            margin-bottom: 5px;
            font-style: italic;
        }

        @media print {
            body {
                background: white;
                margin: 0;
                padding: 0;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }
            .receipt-page {
                width: 100%;
                margin: 0;
                padding: 10mm 15mm;
                box-shadow: none;
                min-height: auto;
            }
            .btn-noprint {
                display: none !important;
            }
            @page {
                margin: 0;
                size: A4 portrait;
            }
        }
    </style>
</head>
<body onload="window.print()">

    <div class="receipt-page">
        <img src="{{ asset('images/logo-putih.png') }}" class="watermark" alt="Watermark">

        <header class="header">
            <div class="logo-section">
                <img src="{{ asset('images/logo-putih.png') }}" alt="Logo">
            </div>
            <div class="company-details">
                <h1 class="company-name">Barakah Transport & Cengal Homestay</h1>
                <p class="company-sub">
                    32300 Pulau Pangkor, Perak, Malaysia<br>
                    Telefon: 013-463 2056<br>
                    Email: admin@barakahtransport.com
                </p>
            </div>
        </header>

        <div class="title-bar">
            Resit Rasmi
        </div>

        <div class="info-grid">
            <div class="info-box">
                <h3>Maklumat Pelanggan</h3>
                <table class="info-table">
                    <tr>
                        <td class="label">Nama:</td>
                        <td><strong>{{ $receipt->customer_name }}</strong></td>
                    </tr>
                    <tr>
                        <td class="label">No. Telefon:</td>
                        <td>{{ $receipt->customer_phone }}</td>
                    </tr>
                    <tr>
                        <td class="label">Kaedah:</td>
                        <td>{{ match($receipt->payment_method) { 'cash' => 'Tunai', 'transfer' => 'Bank Transfer', 'card' => 'Kad', default => ucfirst($receipt->payment_method) } }}</td>
                    </tr>
                </table>
            </div>

            <div class="info-box">
                <h3>Maklumat Resit</h3>
                <table class="info-table">
                    <tr>
                        <td class="label">No. Resit:</td>
                        <td><strong>{{ $receipt->receipt_number }}</strong></td>
                    </tr>
                    <tr>
                        <td class="label">Tarikh:</td>
                        <td>{{ $receipt->created_at->format('d/m/Y') }}</td>
                    </tr>
                    <tr>
                        <td class="label">Masa:</td>
                        <td>{{ $receipt->created_at->format('H:i A') }}</td>
                    </tr>
                </table>
            </div>
        </div>

        <table class="item-table">
            <thead>
                <tr>
                    <th style="width: 5%; text-align: center;">No</th>
                    <th style="width: 50%;">Butiran & Deskripsi</th>
                    <th style="width: 10%; text-align: center;">Unit</th>
                    <th style="width: 15%; text-align: right;">Kadar (RM)</th>
                    <th style="width: 20%; text-align: right;">Jumlah (RM)</th>
                </tr>
            </thead>
            <tbody>
                @foreach($receipt->items as $index => $item)
                <tr>
                    <td class="col-center">{{ $index + 1 }}</td>
                    <td>
                        <span style="font-weight: bold; color: var(--primary-maroon);">{{ ucfirst($item->category) }}</span> - {{ $item->model_unit }}
                        <div style="font-size: 11px; color: #666; margin-top: 4px;">
                            {{ $item->start_date->format('d/m/Y') }} - {{ $item->end_date->format('d/m/Y') }}
                            <br>
                            <em>(Durasi: {{ $item->duration_days }} Hari)</em>
                        </div>
                    </td>
                    <td class="col-center">{{ $item->quantity }}</td>
                    <td class="col-right">{{ number_format($item->price_per_day, 2) }}</td>
                    <td class="col-right"><strong>{{ number_format($item->total_price, 2) }}</strong></td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="totals-container">
            <table class="totals-table">
                <tr>
                    <td class="total-label">Jumlah Keseluruhan</td>
                    <td class="total-value">{{ number_format($receipt->total_amount, 2) }}</td>
                </tr>
                <tr class="row-deposit">
                    <td class="total-label">Deposit</td>
                    <td class="total-value">- {{ number_format($receipt->deposit_amount, 2) }}</td>
                </tr>
                <tr class="row-balance">
                    <td class="total-label">BAKI PERLU DIBAYAR</td>
                    <td class="total-value">RM {{ number_format($receipt->balance_amount, 2) }}</td>
                </tr>
            </table>
        </div>

        <div class="footer">
            <div class="thank-you">Terima kasih kerana memilih Barakah Transport!</div>
            <div>Resit ini adalah cetakan komputer dan sah tanpa tandatangan.</div>
        </div>

    </div>

</body>
</html>

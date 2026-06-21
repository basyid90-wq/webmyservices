<!doctype html>
<html lang="ms">
<head>
    <meta charset="utf-8">
    <title>{{ $typeLabel }} - {{ $document->doc_no }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Poppins:wght@500;600;700&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Inter', sans-serif;
            background: #f8fafc;
            color: #0f172a;
            font-size: 13px;
            line-height: 1.6;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            padding: 24px;
        }
        .page {
            max-width: 720px;
            margin: 0 auto;
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 1px 3px rgba(0,0,0,.06), 0 6px 16px rgba(0,0,0,.04);
            overflow: hidden;
        }

        /* ---- TOP BAR ---- */
        .topbar {
            background: #0f172a;
            color: #fff;
            padding: 20px 32px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .topbar .brand {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .topbar .brand img {
            width: 40px;
            height: 40px;
            object-fit: contain;
            background: #fff;
            border-radius: 8px;
            padding: 3px;
        }
        .topbar .brand h1 {
            font-family: 'Poppins', sans-serif;
            font-size: 20px;
            font-weight: 700;
            color: #fff;
            margin: 0;
        }
        .topbar .brand p {
            font-size: 11px;
            color: #94a3b8;
            margin: 1px 0 0 0;
        }
        .topbar .tag {
            font-family: 'Poppins', sans-serif;
            font-size: 13px;
            font-weight: 700;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: #38bdf8;
        }

        /* ---- BODY ---- */
        .body { padding: 28px 32px; }

        /* ---- META ROW ---- */
        .meta-row {
            display: flex;
            gap: 32px;
            padding-bottom: 20px;
            border-bottom: 1px solid #e2e8f0;
            margin-bottom: 20px;
        }
        .meta-row .bill { flex: 1; }
        .meta-row .bill h3 {
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: .1em;
            color: #94a3b8;
            font-weight: 600;
            margin-bottom: 6px;
        }
        .meta-row .bill .name { font-size: 16px; font-weight: 700; color: #0f172a; }
        .meta-row .bill span { font-size: 12px; color: #64748b; display: block; margin-top: 2px; }

        .meta-row .info { text-align: right; font-size: 12px; }
        .meta-row .info .r { display: flex; justify-content: flex-end; gap: 12px; padding: 3px 0; }
        .meta-row .info .r .lbl { color: #94a3b8; }
        .meta-row .info .r .val { font-weight: 600; color: #0f172a; }
        .meta-row .info .r .big { font-size: 17px; font-weight: 700; color: #0f172a; }

        /* ---- TABLE ---- */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table thead th {
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: .06em;
            font-weight: 600;
            color: #94a3b8;
            padding: 10px 12px;
            border-bottom: 2px solid #e2e8f0;
            text-align: left;
        }
        table thead th:last-child { text-align: right; }
        table thead th:nth-child(2),
        table thead th:nth-child(3) { text-align: center; }
        table tbody td {
            padding: 10px 12px;
            font-size: 13px;
            color: #334155;
            border-bottom: 1px solid #f1f5f9;
        }
        table tbody td:last-child { text-align: right; font-weight: 500; }
        table tbody td:nth-child(2),
        table tbody td:nth-child(3) { text-align: center; color: #64748b; }

        /* ---- TOTALS ---- */
        .footer-row {
            display: flex;
            gap: 32px;
        }
        .footer-row .notes {
            flex: 1;
            font-size: 12px;
            color: #64748b;
        }
        .footer-row .sums {
            flex: 0 0 240px;
        }
        .footer-row .sums .sr {
            display: flex;
            justify-content: space-between;
            padding: 4px 0;
            font-size: 12px;
            border-bottom: 1px solid #f1f5f9;
        }
        .footer-row .sums .sr .l { color: #94a3b8; }
        .footer-row .sums .sr .v { font-weight: 600; color: #334155; }
        .footer-row .sums .grand {
            font-size: 16px;
            font-weight: 700;
            color: #0f172a;
            border-bottom: 2px solid #0f172a;
            padding-top: 8px;
            margin-top: 4px;
        }

        /* ---- BOTTOM BAR ---- */
        .bottombar {
            background: #f8fafc;
            border-top: 1px solid #e2e8f0;
            padding: 20px 32px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .bottombar .bank {
            font-size: 13px;
            font-weight: 600;
            color: #0f172a;
        }
        .bottombar .bank span { color: #64748b; font-weight: 400; }
        .bottombar .bank img {
            vertical-align: middle;
            margin-left: 12px;
            width: 56px;
            height: 56px;
            object-fit: contain;
            border-radius: 6px;
            border: 1px solid #e2e8f0;
            padding: 2px;
            background: #fff;
        }
        .bottombar .timestamp {
            font-size: 11px;
            color: #94a3b8;
            text-align: right;
        }

        /* ---- BUTTONS ---- */
        .actions {
            padding: 16px 32px 24px;
            display: flex;
            justify-content: center;
            gap: 8px;
        }
        .actions a, .actions button {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 20px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 500;
            text-decoration: none;
            cursor: pointer;
            border: 1px solid #e2e8f0;
            background: #fff;
            color: #475569;
            font-family: 'Inter', sans-serif;
            transition: all .15s;
        }
        .actions a:hover, .actions button:hover { background: #f1f5f9; }
        .actions .btn-print { background: #0f172a; color: #fff; border-color: #0f172a; }
        .actions .btn-print:hover { background: #1e293b; }

        @media print {
            body { background: #fff; padding: 0; display: flex; align-items: center; justify-content: center; min-height: 100vh; -webkit-print-color-adjust: exact; print-color-adjust: exact; }
            .page { box-shadow: none; border-radius: 0; max-width: 720px; width: 100%; }
            .topbar { background: #0f172a !important; -webkit-print-color-adjust: exact; print-color-adjust: exact; }
            .bottombar { background: #f8fafc !important; -webkit-print-color-adjust: exact; print-color-adjust: exact; }
            .actions { display: none !important; }
            @page { size: A4; margin: 0; }
        }
    </style>
</head>
<body>

<div class="page">

    <!-- TOP BAR -->
    <div class="topbar">
        <div class="brand">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" onerror="this.style.display='none'">
            <div>
                <h1>Webmy Services</h1>
                <p>No 2-2A Taman Desa Pangkor, 32300 Pulau Pangkor, Perak &nbsp;|&nbsp; 019-4920559 &nbsp;|&nbsp; basyid90@gmail.com</p>
            </div>
        </div>
        <div class="tag">{{ $typeLabel }}</div>
    </div>

    <!-- BODY -->
    <div class="body">

        <!-- META -->
        <div class="meta-row">
            <div class="bill">
                <h3>Bill To</h3>
                @if($document->client)
                    <div class="name">{{ $document->client->name }}</div>
                    @if($document->client->company)<span>{{ $document->client->company }}</span>@endif
                    @if($document->client->email)<span>{{ $document->client->email }}</span>@endif
                    @if($document->client->phone)<span>{{ $document->client->phone }}</span>@endif
                    @if($document->client->address)<span>{{ $document->client->address }}</span>@endif
                @else
                    <div class="name">{{ $document->bill_to_name ?: '-' }}</div>
                    @if($document->bill_to_phone)<span>{{ $document->bill_to_phone }}</span>@endif
                    @if($document->bill_to_address)<span>{{ $document->bill_to_address }}</span>@endif
                    @if($document->bill_to_email)<span>{{ $document->bill_to_email }}</span>@endif
                @endif
            </div>
            <div class="info">
                <div class="r"><span class="lbl">No Dokumen</span><span class="val">{{ $document->doc_no }}</span></div>
                <div class="r"><span class="lbl">Tarikh</span><span class="val">{{ $document->doc_date?->format('d M Y') }}</span></div>

                @if($document->doc_type === 'QUOTE' && $document->valid_until)
                <div class="r"><span class="lbl">Sah Sehingga</span><span class="val">{{ $document->valid_until->format('d M Y') }}</span></div>
                @endif

                @if($document->doc_type === 'INVOICE' && $document->due_date)
                <div class="r"><span class="lbl">Tarikh Bayar</span><span class="val">{{ $document->due_date->format('d M Y') }}</span></div>
                @endif

                @if($document->doc_type === 'RECEIPT' && $document->paid_amount !== null)
                <div class="r"><span class="lbl">Jumlah Bayar</span><span class="val big">{{ number_format((float)$document->paid_amount, 2) }}</span></div>
                @endif

                <div class="r"><span class="lbl">Status</span><span class="val">{{ $document->status }}</span></div>

                @if($document->relatedDocument)
                <div class="r"><span class="lbl">Rujuk</span><span class="val">{{ $document->relatedDocument->doc_no }}</span></div>
                @endif
            </div>
        </div>

        <!-- ITEMS TABLE -->
        <table>
            <thead>
                <tr>
                    <th>Perihal</th>
                    <th>Kuantiti</th>
                    <th>Harga / Unit</th>
                    <th>Jumlah</th>
                </tr>
            </thead>
            <tbody>
                @forelse($document->items as $item)
                <tr>
                    <td>{{ $item->item_desc }}</td>
                    <td>{{ number_format((float)$item->qty, 2) }}</td>
                    <td>{{ number_format((float)$item->unit_price, 2) }}</td>
                    <td>{{ number_format((float)$item->line_total, 2) }}</td>
                </tr>
                @empty
                <tr><td colspan="4" style="text-align:center;color:#94a3b8;padding:24px;">Tiada item</td></tr>
                @endforelse
            </tbody>
        </table>

        <!-- TOTALS -->
        <div class="footer-row">
            <div class="notes">
                @if($document->notes)<strong>Catatan</strong><br>{{ $document->notes }}@endif
            </div>
            <div class="sums">
                <div class="sr"><span class="l">Subtotal</span><span class="v">{{ number_format((float)$document->subtotal, 2) }}</span></div>
                <div class="sr"><span class="l">Diskaun</span><span class="v">{{ number_format((float)$document->discount_amount, 2) }}</span></div>
                <div class="sr"><span class="l">Cukai ({{ number_format((float)$document->tax_percent, 2) }}%)</span><span class="v">{{ number_format((float)$document->tax_amount, 2) }}</span></div>
                <div class="sr grand"><span>Grand Total ({{ $document->currency ?? 'MYR' }})</span><span>{{ number_format((float)$document->grand_total, 2) }}</span></div>

                @if($document->doc_type === 'RECEIPT')
                <div class="sr"><span class="l">Kaedah Bayaran</span><span class="v">{{ $document->payment_method ?: '-' }}</span></div>
                <div class="sr"><span class="l">Rujukan Bayaran</span><span class="v">{{ $document->payment_ref ?: '-' }}</span></div>
                @endif
            </div>
        </div>

    </div>

    <!-- BOTTOM BAR -->
    <div class="bottombar">
        <div class="bank">
            @if($document->doc_type !== 'RECEIPT')
                <span>Pembayaran ke</span> Maybank 558266320419 (Webmy Services)
                <img src="{{ asset('images/qr-code.png') }}" alt="QR" onerror="this.style.display='none'">
            @endif
        </div>
        <div class="timestamp">
            Dijana pada {{ $now }}
        </div>
    </div>

    <!-- ACTIONS -->
    <div class="actions">
        <a href="javascript:history.back()">&#8592; Kembali</a>
        <button class="btn-print" onclick="window.print()">Cetak</button>
        <a href="{{ route('filament.admin.resources.documents.index') }}">Senarai</a>
    </div>

</div>

</body>
</html>

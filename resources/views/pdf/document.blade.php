<!doctype html>
<html lang="ms">
<head>
    <meta charset="utf-8">
    <title>{{ $document->doc_no }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Helvetica', 'Arial', sans-serif; color: #0f172a; font-size: 11px; line-height: 1.5; padding: 0; }
        @page { size: A4; margin: 0; }

        .topbar {
            background: #0f172a; color: #fff; padding: 14px 28px;
            display: flex; justify-content: space-between; align-items: center;
            -webkit-print-color-adjust: exact; print-color-adjust: exact;
        }
        .brand { display: flex; align-items: center; gap: 10px; }
        .brand .logo {
            width: 36px; height: 36px; background: #fff; border-radius: 6px;
            display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 14px; color: #0f172a;
        }
        .brand h1 { font-size: 18px; font-weight: 700; color: #fff; }
        .brand p { font-size: 9px; color: #94a3b8; margin-top: 1px; }
        .tag { font-size: 12px; font-weight: 700; letter-spacing: 0.08em; text-transform: uppercase; color: #38bdf8; }

        .body { padding: 24px 28px; }

        .meta-row { display: flex; gap: 28px; padding-bottom: 16px; border-bottom: 1px solid #e2e8f0; margin-bottom: 16px; }
        .bill { flex: 1; }
        .bill h3 { font-size: 9px; text-transform: uppercase; letter-spacing: .1em; color: #94a3b8; font-weight: 600; margin-bottom: 4px; }
        .bill .name { font-size: 14px; font-weight: 700; }
        .bill span { font-size: 10px; color: #64748b; display: block; margin-top: 1px; }
        .info { text-align: right; font-size: 10px; }
        .info .r { display: flex; justify-content: flex-end; gap: 10px; padding: 2px 0; }
        .info .r .lbl { color: #94a3b8; }
        .info .r .val { font-weight: 600; }

        table { width: 100%; border-collapse: collapse; margin-bottom: 16px; }
        thead th {
            font-size: 9px; text-transform: uppercase; letter-spacing: .05em; font-weight: 600;
            color: #94a3b8; padding: 8px 10px; border-bottom: 2px solid #e2e8f0; text-align: left;
        }
        thead th:last-child, thead th:nth-child(2), thead th:nth-child(3) { text-align: center; }
        thead th:last-child { text-align: right; }
        tbody td { padding: 8px 10px; font-size: 11px; color: #334155; border-bottom: 1px solid #f1f5f9; }
        tbody td:last-child { text-align: right; font-weight: 500; }
        tbody td:nth-child(2), tbody td:nth-child(3) { text-align: center; color: #64748b; }

        .footer-row { display: flex; gap: 28px; }
        .notes { flex: 1; font-size: 10px; color: #64748b; }
        .sums { flex: 0 0 200px; }
        .sums .sr { display: flex; justify-content: space-between; padding: 3px 0; font-size: 10px; border-bottom: 1px solid #f1f5f9; }
        .sums .sr .l { color: #94a3b8; }
        .sums .sr .v { font-weight: 600; }
        .sums .grand { font-size: 14px; font-weight: 700; border-bottom: 2px solid #0f172a; padding-top: 6px; margin-top: 3px; }

        .bottombar {
            background: #f8fafc; border-top: 1px solid #e2e8f0; padding: 14px 28px;
            display: flex; justify-content: space-between; align-items: center;
            -webkit-print-color-adjust: exact; print-color-adjust: exact;
        }
        .bottombar .bank { font-size: 11px; font-weight: 600; }
        .bottombar .bank span { color: #64748b; font-weight: 400; }
        .bottombar .timestamp { font-size: 9px; color: #94a3b8; text-align: right; }
    </style>
</head>
<body>

<div class="topbar">
    <div class="brand">
        <div class="logo">W</div>
        <div>
            <h1>Webmy Services</h1>
            <p>No 2-2A Taman Desa Pangkor, 32300 Pulau Pangkor, Perak | 019-4920559 | basyid90@gmail.com</p>
        </div>
    </div>
    <div class="tag">Invois</div>
</div>

<div class="body">

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
            @endif
        </div>
        <div class="info">
            <div class="r"><span class="lbl">No Dokumen</span><span class="val">{{ $document->doc_no }}</span></div>
            <div class="r"><span class="lbl">Tarikh</span><span class="val">{{ $document->doc_date?->format('d M Y') }}</span></div>
            @if($document->due_date)
            <div class="r"><span class="lbl">Tarikh Bayar</span><span class="val">{{ $document->due_date->format('d M Y') }}</span></div>
            @endif
            <div class="r"><span class="lbl">Status</span><span class="val">{{ $document->status }}</span></div>
        </div>
    </div>

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
                <td>{{ number_format((float)$item->qty, 0) }}</td>
                <td>{{ number_format((float)$item->unit_price, 2) }}</td>
                <td>{{ number_format((float)$item->line_total, 2) }}</td>
            </tr>
            @empty
            <tr><td colspan="4" style="text-align:center;color:#94a3b8;padding:24px;">Tiada item</td></tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer-row">
        <div class="notes">@if($document->notes){{ $document->notes }}@endif</div>
        <div class="sums">
            <div class="sr"><span class="l">Subtotal</span><span class="v">{{ number_format((float)$document->subtotal, 2) }}</span></div>
            <div class="sr"><span class="l">Diskaun</span><span class="v">{{ number_format((float)$document->discount_amount, 2) }}</span></div>
            <div class="sr"><span class="l">Cukai ({{ number_format((float)$document->tax_percent, 2) }}%)</span><span class="v">{{ number_format((float)$document->tax_amount, 2) }}</span></div>
            <div class="sr grand"><span>Grand Total ({{ $document->currency ?? 'MYR' }})</span><span>{{ number_format((float)$document->grand_total, 2) }}</span></div>
        </div>
    </div>

</div>

<div class="bottombar">
    <div class="bank">
        <span>Pembayaran ke</span> Maybank 558266320419 (Webmy Services)
    </div>
    <div class="timestamp">Dijana pada {{ now()->format('d M Y H:i') }}</div>
</div>

</body>
</html>

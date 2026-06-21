<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Invoice {{ $invoice->invoice_number }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Poppins', sans-serif;
            background: #fff;
            color: #1f2937;
            font-size: 12px;
        }
        .page { max-width: 210mm; margin: 0 auto; padding: 14mm 14mm; }

        .header { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 24px; }
        .header-l { display: flex; align-items: center; gap: 14px; }
        .header-l img { width: 52px; height: 52px; object-fit: contain; }
        .header-l h2 { font-family: 'Poppins', sans-serif; font-weight: 700; font-size: 24px; color: #111827; margin: 0; }
        .header-l p { font-family: 'Poppins', sans-serif; font-size: 10px; color: #6b7280; margin: 2px 0 0 0; line-height: 1.5; }
        .badge {
            font-family: 'Poppins', sans-serif;
            border: 1.5px solid #111827;
            padding: 4px 10px;
            border-radius: 6px;
            font-weight: 700;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: .04em;
            color: #111827;
        }

        .info-row { display: flex; gap: 24px; margin-bottom: 20px; padding-bottom: 14px; border-bottom: 1px solid #e5e7eb; }
        .bill { flex: 1; }
        .bill label { font-family: 'Poppins', sans-serif; font-size: 10px; text-transform: uppercase; color: #9ca3af; letter-spacing: 1px; font-weight: 600; display: block; margin-bottom: 4px; }
        .bill .name { font-size: 14px; font-weight: 600; color: #111827; }
        .bill span { font-size: 11px; color: #6b7280; display: block; }
        .meta-r { text-align: right; white-space: nowrap; }
        .meta-r .row { font-size: 11px; padding: 2px 0; }
        .meta-r .lbl { color: #9ca3af; margin-right: 8px; }
        .meta-r .val { font-weight: 600; color: #111827; }

        table.items { width: 100%; border-collapse: collapse; margin-bottom: 16px; }
        table.items th {
            font-family: 'Poppins', sans-serif;
            background: #f9fafb;
            border: 1px solid #e5e7eb;
            padding: 7px 10px;
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: .5px;
            font-weight: 600;
            color: #6b7280;
        }
        table.items th:first-child { text-align: left; }
        table.items th:nth-child(2),
        table.items th:nth-child(3) { text-align: center; white-space: nowrap; }
        table.items th:last-child { text-align: right; white-space: nowrap; }
        table.items td {
            font-family: 'Poppins', sans-serif;
            border: 1px solid #e5e7eb;
            padding: 7px 10px;
            font-size: 11px;
            color: #1f2937;
        }
        table.items td:nth-child(2),
        table.items td:nth-child(3) { text-align: center; white-space: nowrap; }
        table.items td:last-child { text-align: right; white-space: nowrap; }

        .bottom { display: flex; gap: 20px; margin-bottom: 16px; }
        .notes-box { flex: 1; font-size: 11px; color: #6b7280; }
        .sum-box { min-width: 180px; }
        .sum-box .r { font-size: 11px; padding: 3px 0; border-bottom: 1px solid #f3f4f6; }
        .sum-box .r .t { color: #6b7280; }
        .sum-box .r .v { font-weight: 600; color: #111827; float: right; }
        .sum-box .grand { font-size: 14px; font-weight: 700; border-bottom-width: 2px; border-color: #111827; margin-top: 2px; padding-top: 5px; }

        .mid { text-align: center; margin-top: 14px; }
        .mid .bank { font-size: 12px; font-weight: 700; color: #111827; margin-bottom: 10px; }
        .mid img { width: 90px; height: 90px; object-fit: contain; }

        @page { size: A4; margin: 0; }
        @media print { body { -webkit-print-color-adjust: exact; print-color-adjust: exact; } }
    </style>
</head>
<body>
<div class="page">

    <div class="header">
        <div class="header-l">
            <img src="{{ public_path('images/logo.png') }}" alt="Logo" onerror="this.style.display='none'">
            <div>
                <h2>Webmy Services</h2>
                <p>No 2-2A Taman Desa Pangkor, 32300 Pulau Pangkor, Perak<br>Tel: 019-4920559 &nbsp;|&nbsp; Emel: basyid90@gmail.com</p>
            </div>
        </div>
        <div class="badge">INVOIS</div>
    </div>

    <div class="info-row">
        <div class="bill">
            <label>Bill To</label>
            <div class="name">{{ $invoice->client->name }}</div>
            @if($invoice->client->company)<span>{{ $invoice->client->company }}</span>@endif
            <span>{{ $invoice->client->email }}</span>
            @if($invoice->client->phone)<span>{{ $invoice->client->phone }}</span>@endif
            @if($invoice->client->address)<span>{{ $invoice->client->address }}</span>@endif
        </div>
        <div class="meta-r">
            <div class="row"><span class="lbl">No Invois</span><span class="val">{{ $invoice->invoice_number }}</span></div>
            <div class="row"><span class="lbl">Tarikh</span><span class="val">{{ $invoice->issue_date->format('d M Y') }}</span></div>
            <div class="row"><span class="lbl">Tarikh Bayar</span><span class="val">{{ $invoice->due_date->format('d M Y') }}</span></div>
            <div class="row"><span class="lbl">Status</span><span class="val">{{ ucfirst($invoice->status) }}</span></div>
        </div>
    </div>

    <table class="items">
        <thead><tr><th>Perihal</th><th>Kuantiti</th><th>Harga/Unit</th><th>Jumlah</th></tr></thead>
        <tbody>
            @foreach($invoice->items as $item)
            <tr>
                <td>{{ $item->description }}</td>
                <td>{{ $item->quantity }}</td>
                <td>{{ number_format($item->unit_price, 2) }}</td>
                <td>{{ number_format($item->subtotal, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="bottom">
        <div class="notes-box">
            @if($invoice->notes)<strong>Nota:</strong><br>{{ $invoice->notes }}@endif
        </div>
        <div class="sum-box">
            <div class="r"><span class="t">Subtotal</span><span class="v">{{ number_format($invoice->subtotal, 2) }}</span></div>
            @if($invoice->tax_rate > 0)
            <div class="r"><span class="t">Cukai ({{ $invoice->tax_rate }}%)</span><span class="v">{{ number_format($invoice->tax_amount, 2) }}</span></div>
            @endif
            @if($invoice->discount > 0)
            <div class="r"><span class="t">Diskaun</span><span class="v">{{ number_format($invoice->discount, 2) }}</span></div>
            @endif
            <div class="r grand"><span class="t">Grand Total (MYR)</span><span class="v">{{ number_format($invoice->total, 2) }}</span></div>
        </div>
    </div>

    <div class="mid">
        <div class="bank">Pembayaran: Maybank 558266320419 (Webmy Services)</div>
        <img src="{{ public_path('images/qr-code.png') }}" alt="QR" onerror="this.style.display='none'">
    </div>

</div>
</body>
</html>

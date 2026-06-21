<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Carbon\Carbon;

class DocumentController extends Controller
{
    public function print(Document $document)
    {
        $document->load('items', 'client', 'relatedDocument');

        $now = Carbon::now('Asia/Kuala_Lumpur')->format('d M Y');

        $typeLabel = match ($document->doc_type) {
            'QUOTE'   => 'Sebutharga',
            'INVOICE' => 'Invois',
            'RECEIPT' => 'Resit',
            default   => $document->doc_type,
        };

        return view('documents.print', compact('document', 'now', 'typeLabel'));
    }

    public function convert(Document $document)
    {
        $convert = request()->query('convert', request()->type ?? '');

        if ($convert === 'invoice' && $document->doc_type === 'QUOTE') {
            $new = $document->convertTo('INVOICE');
            return redirect()->route('documents.print', $new);
        }

        if ($convert === 'receipt' && $document->doc_type === 'INVOICE') {
            $new = $document->convertTo('RECEIPT');
            $document->update(['status' => 'Paid']);
            return redirect()->route('documents.print', $new);
        }

        return redirect()->back()->with('error', 'Gagal melakukan penukaran dokumen.');
    }
}

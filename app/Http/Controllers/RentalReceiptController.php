<?php

namespace App\Http\Controllers;

use App\Models\RentalReceipt;
use Barryvdh\DomPDF\Facade\Pdf;

class RentalReceiptController extends Controller
{
    public function download(RentalReceipt $rentalReceipt)
    {
        $rentalReceipt->load('items');
        $pdf = Pdf::loadView('pdf.rental-receipt-dompdf', ['receipt' => $rentalReceipt]);
        return $pdf->download("{$rentalReceipt->receipt_number}.pdf");
    }

    public function print(RentalReceipt $rentalReceipt)
    {
        $rentalReceipt->load('items');
        return view('pdf.rental-receipt', ['receipt' => $rentalReceipt]);
    }
}

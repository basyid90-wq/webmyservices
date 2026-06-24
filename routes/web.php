<?php

use App\Http\Controllers\BookingController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\RentalReceiptController;
use App\Models\Project;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/portfolio', function () {
    $projects = Project::where('is_published', true)->orderBy('sort_order')->latest()->get();
    return Inertia::render('Portfolio', ['projects' => $projects]);
})->name('portfolio');

Route::get('/portfolio/{project:slug}', function (Project $project) {
    return Inertia::render('ProjectDetail', ['project' => $project->load('client')]);
})->name('project.detail');

Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
Route::post('/contact', [HomeController::class, 'contactSubmit'])->name('contact.submit');
Route::post('/pricing-inquiry', [HomeController::class, 'pricingInquiry'])->name('pricing.inquiry');

Route::get('/invoices/{invoice}/pdf', [InvoiceController::class, 'download'])->name('invoices.pdf');
Route::get('/documents/{document}/print', [DocumentController::class, 'print'])->name('documents.print');
Route::get('/documents/{document}/convert', [DocumentController::class, 'convert'])->name('documents.convert');

Route::get('/rental/{rentalReceipt}/pdf', [RentalReceiptController::class, 'download'])->name('rental.download');
Route::get('/rental/{rentalReceipt}/print', [RentalReceiptController::class, 'print'])->name('rental.print');

Route::get('/terms', function () { return Inertia::render('Terms'); })->name('terms');
Route::get('/privacy', function () { return Inertia::render('Privacy'); })->name('privacy');
Route::redirect('/maintenance', '/#maintenance', 301);

Route::get('/booking', [BookingController::class, 'catalog'])->name('booking.catalog');
Route::get('/booking/room/{room:slug}', [BookingController::class, 'room'])->name('booking.room');
Route::post('/booking/availability/{room}', [BookingController::class, 'checkAvailability'])->name('booking.availability');
Route::get('/booking/summary', [BookingController::class, 'summary'])->name('booking.summary');
Route::get('/booking/checkout', function (\Illuminate\Http\Request $request) {
    return \Inertia\Inertia::render('Booking/Checkout');
})->name('booking.checkout');
Route::post('/booking/checkout', [BookingController::class, 'checkout'])->name('booking.checkout.submit');
Route::get('/booking/orders/{booking:booking_number}/success', [BookingController::class, 'success'])->name('booking.success');

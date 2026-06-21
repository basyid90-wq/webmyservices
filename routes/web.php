<?php

use App\Http\Controllers\DocumentController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InvoiceController;
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
Route::post('/documents/{document}/convert', [DocumentController::class, 'convert'])->name('documents.convert');

Route::get('/terms', function () { return Inertia::render('Terms'); })->name('terms');
Route::get('/privacy', function () { return Inertia::render('Privacy'); })->name('privacy');
Route::get('/maintenance', function () { return Inertia::render('Maintenance'); })->name('maintenance');

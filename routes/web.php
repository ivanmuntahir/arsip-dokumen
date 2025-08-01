<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PDFController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/download', [App\Http\Controllers\PDFController::class, 'downloadpdf'])->name('download.laporan');

Route::get('/download-filtered', [PDFController::class, 'downloadpdfFiltered'])->name('download.laporan.surat.masuk.filtered');

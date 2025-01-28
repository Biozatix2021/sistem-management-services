<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AlatController;
use App\Http\Controllers\DataUjiFungsiController;
use App\Http\Controllers\InstalasiAlatController;
use App\Http\Controllers\PerusahaanController;
use App\Http\Controllers\TeknisiController;
use App\Http\Controllers\RumahSakitController;
use App\Http\Controllers\SopAlatController;
use App\Http\Controllers\TemplateUjiFungsiController;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('alat', AlatController::class)->names('alat');
Route::resource('teknisi', TeknisiController::class)->names('teknisi');
Route::resource('rumah-sakit', RumahSakitController::class)->names('rumah-sakit');
Route::resource('sop-alat', SopAlatController::class)->names('sop-alat');
Route::resource('data-uji-fungsi', DataUjiFungsiController::class)->names('data-uji-fungsi');
Route::get('form-uji-fungsi', [DataUjiFungsiController::class, 'form_qc'])->name('form-qc');
// Route::resource('uji-fungsi', UjiFungsiController::class)->names('uji-fungsi');
Route::resource('template-uji-fungsi', TemplateUjiFungsiController::class)->names('template-uji-fungsi');
Route::resource('instalasi-alat', InstalasiAlatController::class)->names('instalasi-alat');
Route::get('data-perusahaan', [PerusahaanController::class, 'index'])->name('perusahaan');
Route::post('perusahaan/store', [PerusahaanController::class, 'store'])->name('perusahaan.store');
Route::delete('perusahaan/delete/{id}', [PerusahaanController::class, 'destroy'])->name('perusahaan.delete');

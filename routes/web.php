<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\AlatController;
use App\Http\Controllers\DataUjiFungsiController;
use App\Http\Controllers\GaransiController;
use App\Http\Controllers\InstalasiAlatController;
use App\Http\Controllers\PerusahaanController;
use App\Http\Controllers\TeknisiController;
use App\Http\Controllers\RumahSakitController;
use App\Http\Controllers\SopAlatController;
use App\Http\Controllers\TemplateUjiFungsiController;



Route::get('cek-auth', [AuthController::class, 'authenticate'])->name('cek-auth');
Route::post('logout-auth', [AuthController::class, 'logout'])->name('logout');


// Route::group(['middleware' => ['auth']], function () {

Route::get('/', function () {
    return view('welcome');
});

Route::resource('alat', AlatController::class)->names('alat');
Route::resource('teknisi', TeknisiController::class)->names('teknisi');
Route::resource('rumah-sakit', RumahSakitController::class)->names('rumah-sakit');
Route::resource('data-garansi', GaransiController::class)->names('data-garansi');
Route::resource('sop-alat', SopAlatController::class)->names('sop-alat');
Route::resource('data-uji-fungsi', DataUjiFungsiController::class)->names('data-uji-fungsi');
Route::get('form-uji-fungsi', [DataUjiFungsiController::class, 'form_qc'])->name('form-qc');
Route::get('validate-no-seri', [DataUjiFungsiController::class, 'validate_no_seri'])->name('validate-no-seri');
Route::post('upload-foto', [DataUjiFungsiController::class, 'upload_foto'])->name('upload-foto');
// Route::resource('uji-fungsi', UjiFungsiController::class)->names('uji-fungsi');
Route::resource('template-uji-fungsi', TemplateUjiFungsiController::class)->names('template-uji-fungsi');
Route::resource('instalasi-alat', InstalasiAlatController::class)->names('instalasi-alat');
Route::get('data-perusahaan', [PerusahaanController::class, 'index'])->name('perusahaan');
Route::post('perusahaan/store', [PerusahaanController::class, 'store'])->name('perusahaan.store');
Route::delete('perusahaan/delete/{id}', [PerusahaanController::class, 'destroy'])->name('perusahaan.delete');
// });

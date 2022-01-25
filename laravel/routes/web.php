<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\GenerateQR;
use App\Http\Controllers\ScannerQR;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/generate', function () {
    return view('generate');
});

Route::get('/scan', function () {
    return view('scan');
});

Route::get('qr-form', [GenerateQR::class, 'generateForm']);
Route::post('qr-form', [GenerateQR::class, 'generatePost'])->name('qr.form');

Route::get('qr-scan', [ScannerQR::class, 'scannerPost']);
Route::post('qr-scan', [ScannerQR::class, 'QRscanner'])->name('qr.scan');

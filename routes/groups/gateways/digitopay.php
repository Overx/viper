<?php


use App\Http\Controllers\Gateway\DigitoPayController;
use Illuminate\Support\Facades\Route;

Route::post('digitopay/qrcode-pix', [DigitoPayController::class, 'getQRCodePix']);
Route::post('digitopay/consult-status-transaction', [DigitoPayController::class, 'consultStatusTransactionPix']);
Route::any('digitopay/callback', [DigitoPayController::class, 'callbackMethod']);
Route::any('digitopay/payment', [DigitoPayController::class, 'callbackMethodPayment']);


Route::get('digitopay/withdrawal/{id}', [DigitoPayController::class, 'withdrawalFromModal'])->name('digitopay.withdrawal');
Route::get('digitopay/cancelwithdrawal/{id}', [DigitoPayController::class, 'cancelWithdrawalFromModal'])->name('digitopay.cancelwithdrawal');

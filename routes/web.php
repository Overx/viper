<?php

use App\Http\Controllers\Panel\AffiliateController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('/clear', function() {
    Artisan::command('clear', function () {
        Artisan::call('optimize:clear');
        echo 'Tudo apagado com sucesso';
    });

    dd("LIMPOU");
});

include_once(__DIR__ . '/groups/auth/login.php');
include_once(__DIR__ . '/groups/auth/social.php');
include_once(__DIR__ . '/groups/auth/register.php');

/// PAINEL DE USUÁRIOS
Route::prefix('painel')
    ->as('panel.')
    ->middleware(['auth'])
    ->group(function ()
    {
        include_once(__DIR__ . '/groups/panel/wallet.php');
        include_once(__DIR__ . '/groups/panel/profile.php');
        include_once(__DIR__ . '/groups/panel/notifications.php');
        include_once(__DIR__ . '/groups/panel/affiliates.php');
    });

/// HOME
Route::middleware(['web'])
    ->as('web.')
    ->group(function ()
    {
        include_once(__DIR__ . '/groups/web/home.php');
        include_once(__DIR__ . '/groups/web/category.php');
    });

/// GATEWAY DE PAGAMENTO
include_once(__DIR__ . '/groups/gateways/digitopay.php');

/// PAINEL DE AFILIADOS
Route::prefix('painel')
    ->as('panel.')
    ->group(function ()
    {
        Route::prefix('affiliates')
            ->as('affiliates.')
            ->group(function () {
                Route::post('/join', [AffiliateController::class, 'joinAffiliate'])->name('join');
            });
    });


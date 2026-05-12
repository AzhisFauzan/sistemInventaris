<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MaintenanceCtrl;
use App\Http\Middleware\ApiMiddleware;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

Route::post('/terima-pengaduan', [MaintenanceCtrl::class, 'api_terima_pengaduan'])
    ->middleware(ApiMiddleware::class);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
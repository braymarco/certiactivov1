<?php

use App\Http\Controllers\Api\PurchaseTokenController;
use App\Http\Controllers\Api\ReportController;
use App\Http\Controllers\Api\WebhookController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/generate/', [PurchaseTokenController::class,'generate']);
Route::get('/verify/', [PurchaseTokenController::class,'check']);
Route::get('/pending/', [ReportController::class,'created']);
Route::prefix('/webhook')->group(function () {
    Route::post('/uanataca',[WebhookController::class, 'uanataca'])->name('webhook.uanataca');
    Route::post('/uanataca_documentation',[WebhookController::class, 'uanatacaDocumentation'])->name('webhook.uanataca_documentation');
});

<?php

use App\Http\Controllers\Admin\SolicitudController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HelperController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\SignatureRequestController;
use Illuminate\Support\Facades\Route;

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


Route::get('/test', [HelperController::class, 'test']);
Route::get('/', [MainController::class, 'main'])->name('main');
Route::prefix('/link')->group(function () {
    Route::get('/query_name', [SignatureRequestController::class, 'getName'])->name('identification.name');
    Route::get('/{purchaseToken}', [SignatureRequestController::class, 'selectType'])->name('purchase-token.type');
    Route::get('/{type}/{purchaseToken}', [SignatureRequestController::class, 'requisitos'])->name('signature-request.requirements');
    Route::post('/{type}/{purchaseToken}', [SignatureRequestController::class, 'generar'])->name('purchase-token.verify');

});
Route::prefix('/document')->group(function () {
    Route::get('/{token}', [SignatureRequestController::class, 'actualizarDocumentoVista'])->name('document.view');
    Route::post('/{token}', [SignatureRequestController::class, 'actualizarDocumento'])->name('document.view_post');
    Route::get('/{token}/download', [SignatureRequestController::class, 'downloadPreviusDocument'])->name('document.descargar_documento_previo');
});
Route::prefix('/solicitud')->group(function () {
    Route::get('/{token}', [\App\Http\Controllers\SolicitudController::class, 'solicitud'])
        ->name('solicitud_cliente.view');
});
Route::get('/login', [AuthController::class, 'index'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::prefix('/admin')->middleware('auth')->group(function () {
    Route::middleware('adminMiddleware')->group(function () {
        Route::get('/', [DashboardController::class, 'solicitudes'])->name('dashboard');
        Route::get('/requisitos/{documentoId}', [SolicitudController::class, 'descargarRequisito'])->name('requisito.descargar');
        Route::post('/pedir_cambio_requisito', [SolicitudController::class, 'pedirCambioRequisito'])->name('solicitud.pedir_cambio_requisito');
        Route::post('/cambiar_archivo_requisito', [SolicitudController::class, 'cambiarArchivoRequisito'])->name('solicitud.cambiar_archivo_requisito');
        Route::post('/aprobar_requisitos', [SolicitudController::class, 'aprobarRequisitos'])->name('solicitud.aprobar_requisito');
        Route::post('/actualizarDatos', [SolicitudController::class, 'actualizarDatos'])->name('solicitud.actualizarDatos');
        Route::prefix('/solicitud/{id}')->group(function () {
            Route::get('/', [SolicitudController::class, 'solicitud'])->name('solicitud');
            Route::post('/actualizar_estado', [SolicitudController::class, 'actualizarEstadoSolicitud'])->name('solicitud.actualizar_estado');
            Route::post('/enviar_proveedor', [SolicitudController::class, 'enviarProveedor'])->name('solicitud.firma_enviar_proveedor');
            Route::post('/check_status', [SolicitudController::class, 'checkStatus'])->name('solicitud.check_status');
            Route::post('/firma_emitida', [SolicitudController::class, 'firmaEmitida'])->name('solicitud.firma_emitida');
            Route::post('/proveedor_cambio_doc', [SolicitudController::class, 'proveedorCambioDocumentacion'])->name('solicitud.proveedor_cambio_doc');

        });
    });
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
});


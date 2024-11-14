<?php
use App\Http\Controllers\CuentasBancariasController;
use App\Http\Controllers\OrdenDePagoController;
use App\Http\Controllers\Tasa;
use Illuminate\Support\Facades\Route;

/* Route::get('/user', function (Request $request) {
    return response()->json(['mensaje'=>'texto', 200]);
}); #esto funciona solamente sin el middleware */
#->middleware('auth:sanctum');

Route::get('/consultar_cuentas_bancarias', [CuentasBancariasController::class, 'consultar_cuentas_bancarias'])->name('ConsultarCuentasBancarias');

Route::post('/registrar_orden_de_pago', [OrdenDePagoController::class, 'registrar']);

Route::get('/tasa', [Tasa::class, 'consultar_tasa']);


<?php
use App\Http\Controllers\CuentasBancariasController;
use App\Http\Controllers\OrdenDePagoController;
use App\Http\Controllers\ReportesTesoreria;
use App\Http\Controllers\Tasa;
use App\Models\CuentasContable;
use Illuminate\Support\Facades\Route;

/* Route::get('/user', function (Request $request) {
    return response()->json(['mensaje'=>'texto', 200]);
}); #esto funciona solamente sin el middleware */
#->middleware('auth:sanctum');

Route::get('/consultar_cuentas_bancarias', [CuentasBancariasController::class, 'consultar_cuentas_bancarias'])->name('ConsultarCuentasBancarias');

Route::post('/registrar_orden_de_pago', [OrdenDePagoController::class, 'registrar']);

Route::get('/tasa', [Tasa::class, 'consultar_tasa']);

//selectores
Route::get('/consultar_cuentas_contables',  [CuentasContable::class, 'consultar']);
//reportes

Route::get('/consultar_ordenes_de_pago', [ReportesTesoreria::class, 'consultarOrdenesDePago']);
Route::get('/consultar_ordenes_de_pago_ultimas', [ReportesTesoreria::class, 'consultarUltimasOrdenes']);

//administrar

Route::post('/asignar_cuenta_contable_a_orden', [OrdenDePagoController::class, 'asignarCuentaContable']);



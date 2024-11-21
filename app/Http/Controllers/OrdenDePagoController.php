<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\CuentasBancariasController;
use App\Http\Controllers\Tasa;
use App\Models\OrdenDePagoElectronico;
use Illuminate\Http\Request;
use Inertia\Inertia;

class OrdenDePagoController extends Controller
{
    public function viewWithApiData()
    {
        //$cuentas_bancarias = CuentasBancariasController::consultar_cuentas_bancarias(); //llamada estatica, error //instanciar objeto, luego llamar sus metodos
        $cuentas = new CuentasBancariasController;
        $tasasInstance = new Tasa;

        $tasas = $tasasInstance->consultar_tasa();
        $cuentasNaviarca = $cuentas->consultar_cuentas_bancarias_naviarca();
        $cuentasGc = $cuentas->consultar_cuentas_bancarias_gc();


        return Inertia::render('RegistrarOrdenDePago', ['cuentasNaviarca' => $cuentasNaviarca, 'cuentasGc' => $cuentasGc, 'tasas' => $tasas]);
    }

    public function registrar(Request $request)
    {
        $validatedData = $request->validate([
            'items' => 'array|min:1',
            'items.*.rif' => 'required|string',
            'items.*.fecha' => 'required|date',
            'items.*.tipo' => 'required|string',
            'items.*.beneficiario' => 'required|string',
            'items.*.factura' => 'required|string',
            'items.*.monto_total' => 'required|string',
            'items.*.retencion_islr' => 'required|string',
            'items.*.autorizacion' => 'required|string',
            'items.*.transferencia' => 'required|numeric',
            'items.*.comision_bancaria' => 'required|numeric',
            'items.*.concepto' => '',
            'items.*.banco_nombre' => 'required|string',
            'items.*.codigo_cuenta' => 'required|string',
            'items.*.tipo_cuenta' => 'required|string',
            'items.*.numero_orden_de_pago' => 'string'
        ]);

        $ordenDePagos = collect($validatedData["items"])->map(function ($item) {
            return OrdenDePagoElectronico::create($item);
        });

        return response()->json([
            'message' => 'Ordenes de pago electrónicas registradas exitosamente.',
            'num_records_saved' => count($ordenDePagos),
            'saved_records' => $ordenDePagos,
        ], 201);
    }
}

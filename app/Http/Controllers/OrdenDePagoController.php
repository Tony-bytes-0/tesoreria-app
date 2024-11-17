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
        $data = $request->validate([
            'items' => 'array',
            'items.*.referencia' => 'string',
            'items.*.factura' => 'required|string',
            'items.*.tipo' => 'required|string',
            'items.*.beneficiario' => 'required|string',
            'items.*.autorizacion' => 'required|string',
            'items.*.fecha' => 'required|date',
            'items.*.transferencia' => 'required|numeric',
            'items.*.comision_bancaria' => 'required|numeric',
            'items.*.retencion_islr' => 'required|string',
            #'cuenta_bancaria' => 'array',
            #'cuenta_bancaria.*.banco_id' => 'string',
            'cuenta_bancaria.*.banco_nombre' => 'string',
            'cuenta_bancaria.*.codigo_cuenta' => 'string',
            'cuenta_bancaria.*.tipo_cuenta' => 'string',
        ]);
        dd($data['items']);
        OrdenDePagoElectronico::create($data);
    }
}

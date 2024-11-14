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
            'orden' => 'required|string',
            'factura'
            => 'required|string',
            'tipo' => 'required|string',
            'referencia'
            => 'required|string',
            'beneficiario'
            => 'required|string',
            'autorizacion'
            => 'required|string',
            'registro_contable'
            => 'required|string',
            'fecha'
            => 'required|string',
            'transferencia'
            => 'required|string',
            'divisas'
            => 'required|string',
            'comision_bancaria'
            => 'required|string',
            'retencion_islr' => 'required|string'
        ]);

        OrdenDePagoElectronico::create($data);
    }
}

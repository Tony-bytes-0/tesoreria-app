<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\CuentasBancariasController;
use Inertia\Inertia;

class OrdenDePagoController extends Controller
{
    public function viewWithApiData()
    {
        //$cuentas_bancarias = CuentasBancariasController::consultar_cuentas_bancarias(); //llamada estatica, error //instanciar objeto, luego llamar sus metodos
        $cuentas = new CuentasBancariasController;

        $cuentasNaviarca = $cuentas->consultar_cuentas_bancarias_naviarca();
        $cuentasGc = $cuentas->consultar_cuentas_bancarias_gc();


        return Inertia::render('RegistrarOrdenDePago', ['cuentasNaviarca' => $cuentasNaviarca, 'cuentasGc' => $cuentasGc]);
    }
}

<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Http\Controllers\CuentasBancariasController;
use Inertia\Inertia;

class OrdenDePagoController extends Controller {
        public function viewWithApiData()
    {
        //$cuentas_bancarias = CuentasBancariasController::consultar_cuentas_bancarias(); //llamada estatica, error //instanciar objeto, luego llamar sus metodos
        $cuentas_bancarias_instance = new CuentasBancariasController;
        $cuentas = $cuentas_bancarias_instance->consultar_cuentas_bancarias_naviarca();
        return Inertia::render('RegistrarOrdenDePago', ['cuentasBancarias'=>$cuentas]);
    }
}


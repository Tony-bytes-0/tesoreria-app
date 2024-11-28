<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\CuentasBancariasController;
use App\Http\Controllers\Tasa;
use App\Models\Beneficiario_cuentas;
use App\Models\OrdenDePagoElectronico;
use App\Models\ProcesoOrdenDePago;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;


class OrdenDePagoController extends Controller
{
    public function viewRegistrarOrdenDePago()
    {
        //$cuentas_bancarias = CuentasBancariasController::consultar_cuentas_bancarias(); //llamada estatica, error //instanciar objeto, luego llamar sus metodos
        $cuentas = new CuentasBancariasController;
        $tasasInstance = new Tasa;
        $beneficiario_cuentas = Beneficiario_cuentas::all();

        $tasas = $tasasInstance->consultar_tasa();
        $cuentasNaviarca = $cuentas->consultar_cuentas_bancarias_naviarca();
        $cuentasGc = $cuentas->consultar_cuentas_bancarias_gc();


        return Inertia::render('RegistrarOrdenDePago', [
            'cuentasNaviarca' => $cuentasNaviarca,
            'cuentasGc' => $cuentasGc,
            'tasas' => $tasas,
            'beneficiarios' => $beneficiario_cuentas
        ]);
    }

    public function registrar(Request $request)
    {
        $validatedData = $request->validate([
            'items' => 'array|min:1',
            'items.*.rif' => 'required|string',
            'items.*.fecha' => 'required|date',
            'items.*.tipo' => 'required|string',
            'items.*.tasa' => 'required|numeric',
            'items.*.banco_nombre' => 'required|string',
            'items.*.codigo_cuenta' => 'required|string',
            'items.*.tipo_cuenta' => 'string',
            //'items.*.beneficiario' => '',
            'items.*.id_beneficiario' => 'required|numeric',
            'items.*.factura' => 'required|string',
            'items.*.monto_total' => 'required|string',
            'items.*.retencion_islr' => 'required|string',
            'items.*.autorizacion' => 'required|string',
            'items.*.transferencia' => 'required|numeric',
            'items.*.comision_bancaria' => 'required|numeric',
            'items.*.concepto' => '',
        ]);

        $transactionResult = DB::transaction(function () use ($validatedData) {

            $totalSum = 0;
            foreach ($validatedData['items'] as $value) {
                if (isset($value['transferencia']) && is_numeric($value['transferencia'])) {
                    $totalSum += $value['transferencia'];
                } else {
                    //
                }
            }
            $procesoOrdenes = ProcesoOrdenDePago::create(['total' => $totalSum, 'numero_orden_de_pago' => '1' ]);


            $ordenDePagos = collect($validatedData["items"])->map(function ($item) use($procesoOrdenes)  {
                $item['id_proceso'] = $procesoOrdenes['id'];
                return OrdenDePagoElectronico::create($item);
            });

            return ['orden_de_pagos' => $ordenDePagos, 'proceso_ordenes' => $procesoOrdenes];
        });

        return response()->json([
            'message' => 'Ordenes de pago electrónicas registradas exitosamente.',
            'num_records_saved' => count($transactionResult['orden_de_pagos']),
            'saved_records' => $transactionResult['orden_de_pagos'],
            'numero_orden_de_pago' => $transactionResult['proceso_ordenes']['id']
        ], 201);
    }
}

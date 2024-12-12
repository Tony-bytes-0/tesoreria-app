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

            'items.*.id_beneficiario' => 'required|numeric',
            'items.*.factura' => 'required|string|nullable',
            'items.*.monto_total' => 'required|string',
            'items.*.retencion_islr' => 'string|nullable',
            'items.*.autorizacion' => 'string|nullable',
            'items.*.transferencia' => 'required|numeric',
            'items.*.comision_bancaria' => 'required|numeric',
            'items.*.numero_personas' => 'nullable',
            'items.*.concepto' => 'nullable',

            'properties.concepto' => 'string|nullable',
            'properties.rif' => 'required|string',
            'properties.fecha' => 'required|date',
            'properties.tipo' => 'required|string',
            'properties.tasa' => 'required|numeric',
            'properties.banco_nombre' => 'required|string',
            'properties.codigo_cuenta' => 'required|string',
            'properties.tipo_cuenta' => 'string',
        ]);


        $transactionResult = DB::transaction(function () use ($validatedData) {
 
            $totalSum = 0; // para agregarle un monto total al proceso orden de pago, deberia tener los demas totales
            foreach ($validatedData['items'] as $value) {
                if (isset($value['transferencia']) && is_numeric($value['transferencia'])) {
                    $totalSum += $value['transferencia'];
                } else {
                    //
                }
            }
            
            $procesoOrdenes = ProcesoOrdenDePago::create(['total' => $totalSum, 'concepto' => $validatedData['properties']['concepto']]);

            $ordenDePagos = collect($validatedData["items"])->map(function ($item) use ($procesoOrdenes, $validatedData) {
                $item['id_proceso'] = $procesoOrdenes['id'];
                unset($validatedData['properties']['concepto']);//elimino el concepto, se repite en items y properties
                
                return OrdenDePagoElectronico::create(array_merge($item, $validatedData['properties']));
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

    public function asignarCuentaContable(Request $request)
    {
        $validatedData = $request->validate([
            'id_ordenes' => 'array|min:1',
            'id_cuenta_contable' => 'required | numeric'
        ]);
        $updatedValues = collect($validatedData['id_ordenes'])->map(function ($item) use ($validatedData) {

            //return OrdenDePagoElectronico::get()->whereIn('id', $item); //->update(['id_cuenta_contable' => $validatedData['id_cuenta_contable']]);
            return OrdenDePagoElectronico::where('id', $item)->update(['id_cuenta_contable' => $validatedData['id_cuenta_contable']]);
        });
        //dd($updatedValues);
        return response()->json([
            'message' => 'mensaje estatic',
            
        ], 201);
    }
}

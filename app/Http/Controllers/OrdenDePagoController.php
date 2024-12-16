<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\CuentasBancariasController;
use App\Http\Controllers\Tasa;
use App\Models\Beneficiario_cuentas;
use App\Models\CuentasBancaria;
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
        $tasasInstance = new Tasa;
        $beneficiario_cuentas = Beneficiario_cuentas::all();
        $tasas = $tasasInstance->consultar_tasa();
        $naviarca = CuentasBancaria::where('empresa_id', '=', 'J080056043')->get();
        $grancacique = CuentasBancaria::where('empresa_id', '=', 'J303876056')->get();

        return Inertia::render('RegistrarOrdenDePago', [
            'cuentasNaviarca' => $naviarca,
            'cuentasGc' => $grancacique,
            'tasas' => $tasas,
            'beneficiarios' => $beneficiario_cuentas
        ]);
    }

    public function registrar(Request $request)
    {
        $validatedData = $request->validate([
            'items' => 'array|min:1',

            'items.*.beneficiario_id' => 'required|numeric',
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
            'properties.cuenta_bancaria_id' => 'required|numeric'
            //'properties.banco_nombre' => 'required|string',
            //'properties.codigo_cuenta' => 'required|string',
            //'properties.tipo_cuenta' => 'string',
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

            $procesoOrdenes = ProcesoOrdenDePago::create(['total' => $totalSum, 'concepto' => $validatedData['properties']['concepto'] , 'secuencia' => '1']);

            $ordenDePagos = collect($validatedData["items"])->map(function ($item) use ($procesoOrdenes, $validatedData) {
                $item['proceso_id'] = $procesoOrdenes['id'];
                $item['secuencia'] = '1';
                unset($validatedData['properties']['concepto']); //elimino el concepto, se repite en items y properties

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
            'ordenes_id' => 'array|min:1',
            'cuenta_contable_id' => 'required | numeric'
        ]);
        $updatedValues = collect($validatedData['ordenes_id'])->map(function ($item) use ($validatedData) {

            //return OrdenDePagoElectronico::get()->whereIn('id', $item); //->update(['cuenta_contable_id' => $validatedData['cuenta_contable_id']]);
            return OrdenDePagoElectronico::where('id', $item)->update(['cuenta_contable_id' => $validatedData['cuenta_contable_id']]);
        });
        //dd($updatedValues);
        return response()->json([
            'message' => 'mensaje estatic',

        ], 201);
    }
}

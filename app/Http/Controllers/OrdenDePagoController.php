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
            'properties.cuenta_bancaria_id' => 'required|numeric',
        ]);


        $transactionResult = DB::transaction(function () use ($validatedData) {

            $totalValues = [
                'transferencia' => 0,
                'monto_total' => 0,
                'retencion_islr' => 0,
                'comision_bancaria' => 0
            ];

            foreach ($validatedData['items'] as $value) {
                if (isset($value['transferencia']) && is_numeric($value['transferencia'])) {
                    $totalValues['transferencia'] += (float)$value['transferencia'];
                }
                if (isset($value['monto_total']) && is_numeric($value['monto_total'])) {
                    $totalValues['monto_total'] += (float)$value['monto_total'];
                }
                if (isset($value['retencion_islr']) && is_numeric($value['retencion_islr'])) {
                    $totalValues['retencion_islr'] += (float)$value['retencion_islr'];
                }
                if (isset($value['comision_bancaria']) && is_numeric($value['comision_bancaria'])) {
                    $totalValues['comision_bancaria'] += (float)$value['comision_bancaria'];
                }
            }
            //proceso de pago con el mismo rif y cuenta bancaria, obtener numero de proceso.secuencia
            //Ultimo numero de secuencia, comparar rif y cuenta_bancaria = request
            $procesoLastEntry = ProcesoOrdenDePago::where('rif', '=', $validatedData['properties']['rif'])
                ->where('cuenta_bancaria_id', '=', $validatedData['properties']['cuenta_bancaria_id'])
                ->where('tipo', '=', $validatedData['properties']['tipo'])
                ->whereNotNull('secuencia')
                ->orderBy('secuencia', 'desc')->limit(1)
                ->get();
            $secuencia = ($procesoLastEntry->first() ?? null)->secuencia ?? 1;
            $lastProcesoId = $procesoLastEntry->first()->id ?? 1;
            //obtener el numero de secuencia de las ordenes de pago asociadas al ultimo proceso de pago, ordenados por orden.secuencia
            //Ultimo numero de secuencia de la orden de pago presente en el ultimo proceso orden de pagos.
            $ordenLastEntry = OrdenDePagoElectronico::where('proceso_id', '=', $lastProcesoId)
                ->whereNotNull('secuencia')
                ->orderBy('secuencia', 'desc')->limit(1);
            $lastOrdenSecuencia = ($ordenLastEntry->first() ?? null)->secuencia ?? 1;
            $procesoOrdenesArrayData = array_merge($totalValues, $validatedData['properties']);
            $procesoOrdenesArrayData['secuencia'] = $secuencia + 1;
            $procesoOrdenes = ProcesoOrdenDePago::create($procesoOrdenesArrayData);

            $ordenDePagos = collect($validatedData["items"])
                ->map(function ($item) use ($procesoOrdenes, $lastOrdenSecuencia, &$counter) {
                    $counter++;
                    $item['proceso_id'] = $procesoOrdenes['id'];
                    $item['secuencia'] = $lastOrdenSecuencia + $counter;
                    return OrdenDePagoElectronico::create($item);
                })
                ->all();
            return ['ordenes' => $ordenDePagos, 'proceso' => $procesoOrdenes];
        });

        return response()->json([
            'message' => 'Ordenes de pago electrónicos registradas exitosamente.',
            'registros_guardados' => count($transactionResult['ordenes']),
            'ordenes' => $transactionResult['ordenes'],
            'proceso' => $transactionResult['proceso'],
            'primera_orden' => reset($transactionResult['ordenes'])['secuencia'],
            'ultima_orden' => $transactionResult['ordenes'][array_key_last($transactionResult['ordenes'])]['secuencia'],
            //'orden_secuencia' => $transactionResult['orden_de_pagos']['secuencia'],
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

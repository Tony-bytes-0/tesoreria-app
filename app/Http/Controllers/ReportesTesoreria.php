<?php

namespace App\Http\Controllers;

use App\Models\CuentasBancaria;
use App\Models\CuentasContable;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\OrdenDePagoElectronico;
use App\Models\ProcesoOrdenDePago;
use Illuminate\Support\Facades\DB;

class ReportesTesoreria extends Controller
{

    public function viewConsultarOrdenesDePago()
    {
        //$ordenesArray = OrdenDePagoElectronico::get();
        $cuentasContables = CuentasContable::get();
        $naviarca = CuentasBancaria::where('empresa_id', '=', 'J080056043')->where('activo', '=', true)->get();
        $grancacique = CuentasBancaria::where('empresa_id', '=', 'J303876056')->where('activo', '=', true)->get();
        return Inertia::render('reportes tesoreria/OrdenesDePago', [
            'cuentasContables' => $cuentasContables,
            'cuentasNaviarca' => $naviarca,
            'cuentasGc' => $grancacique,
        ]);
    }

    public function consultarOrdenesDePago(Request $request)
    {
        $validated = $request->validate([
            'rif' => 'string|required',
            'cuenta_bancaria_id' => 'numeric|required',
            'tipo' => 'string|required',
            'secuencia' => 'numeric|required',
        ]);
        $proceso = ProcesoOrdenDePago::where('rif', '=', $validated['rif'])
        ->where('tipo', '=', $validated['tipo'])
        ->where('cuenta_bancaria_id', '=', $validated['cuenta_bancaria_id'])
        ->where('secuencia', '=', $validated['secuencia'])
        ->orderBy('id', 'desc')
        ->first();
        if (!$proceso) {
            return response()->json([
                'message' => 'Sin registros',
                'data' => null,
            ], 404);
        }
        $procesoId = $proceso->first()->id ?? 1;
        $ordenesArray = OrdenDePagoElectronico::with('beneficiario', 'cuenta_contable', 'cuenta_bancaria')
        ->where('proceso_id','=',$procesoId)->get();
        return response()->json([
            'proceso' => $proceso,
            'ordenes' => $ordenesArray,
            'message' => 'Busqueda exitosa'
        ], 201);
    }

    public function consultarUltimasOrdenes(Request $request)
    {
        
        $ordenesArray = OrdenDePagoElectronico::with(['beneficiario', 'cuenta_bancaria', 'cuenta_contable'])->orderBy('id', 'desc')->paginate(50);
        return response()->json([
            'items' => $ordenesArray,
        ], 201);
    }
}

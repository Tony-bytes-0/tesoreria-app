<?php

namespace App\Http\Controllers;

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
        return Inertia::render('reportes tesoreria/OrdenesDePago', [
            'cuentasContables' => $cuentasContables
        ]);
    }

    public function consultarOrdenesDePago(Request $request)
    {
        $validated = $request->validate([
            'id_proceso' => 'numeric',
            'per_page' => 'numeric',
            'page' => 'numeric',
        ]);
        $ordenesArray = OrdenDePagoElectronico::with('beneficiario', 'cuenta_contable')->where('id_proceso', '=', $validated['id_proceso'])->orderBy('id')->orderBy('id')->paginate(perPage: $validated['per_page'], page: $validated['page']);
        $conceptoGeneral = ProcesoOrdenDePago::find($validated['id_proceso']);
        if ($ordenesArray->isEmpty()) {
            return response()->json([
                'message' => 'No existe el proceso orden de pago numero: ' . $validated['id_proceso'],
            ], 204);
        }
        return response()->json([
            'items' => $ordenesArray,
            'proceso_orden_de_pago' => $conceptoGeneral
        ], 201);
    }

    public function consultarUltimasOrdenes(Request $request)
    {
        $ordenesArray = OrdenDePagoElectronico::with('beneficiario', 'cuenta_contable')->orderBy('id', 'desc')->paginate(perPage: 50, page: 1);
        return response()->json([
            'items' => $ordenesArray,
        ], 201);
    }
}

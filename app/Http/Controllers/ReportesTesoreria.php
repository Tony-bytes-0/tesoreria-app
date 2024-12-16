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
            'proceso_id' => 'numeric',
            'per_page' => 'numeric',
            'page' => 'numeric',
        ]);
        $ordenesArray = OrdenDePagoElectronico::with('beneficiario', 'cuenta_contable')->where('proceso_id', '=', $validated['proceso_id'])->orderBy('id')->orderBy('id')->paginate(perPage: $validated['per_page'], page: $validated['page']);
        $conceptoGeneral = ProcesoOrdenDePago::find($validated['proceso_id']);
        if ($ordenesArray->isEmpty()) {
            return response()->json([
                'message' => 'No existe el proceso orden de pago numero: ' . $validated['proceso_id'],
            ], 204);
        }
        return response()->json([
            'items' => $ordenesArray,
            'proceso_orden_de_pago' => $conceptoGeneral
        ], 201);
    }

    public function consultarUltimasOrdenes(Request $request)
    {
        $ordenesArray = OrdenDePagoElectronico::with('beneficiario_cuenta', 'cuenta_contable', 'cuentas_bancarias')->orderBy('id', 'desc')->paginate(perPage: 50, page: 1);
        return response()->json([
            'items' => $ordenesArray,
        ], 201);
    }
}

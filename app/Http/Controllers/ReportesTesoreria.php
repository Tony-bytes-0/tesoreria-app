<?php

namespace App\Http\Controllers;

use App\Models\CuentasContable;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\OrdenDePagoElectronico;
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
        //>with('beneficiario', 'cuenta_contable')->where('id_proceso', '=', $validated['id_proceso'])->orderBy('id');
        //$ordenesArray = OrdenDePagoElectronico::with('beneficiario', 'cuenta_contable')->where('id_proceso', '=', $validated['id_proceso'])->orderBy('id')->paginate(perPage: $validated['per_page'], page: $validated['page']);
        $ordenesArray = OrdenDePagoElectronico::with('beneficiario', 'cuenta_contable')->where('id_proceso', '=', $validated['id_proceso'])->orderBy('id')->orderBy('id')->paginate(perPage: $validated['per_page'], page: $validated['page']);
        
        if ($ordenesArray->isEmpty()) {
            return response()->json([
                'message' => 'No existe el proceso orden de pago numero: ' . $validated['id_proceso'],
            ], 204);
        }
        return response()->json([
            'items' => $ordenesArray
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

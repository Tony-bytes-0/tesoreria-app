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
        //$ordenesArray = OrdenDePagoElectronico::with('beneficiario', 'cuenta_contable')->where('id_proceso', '=', $validated['id_proceso'])->orderBy('id')->paginate(perPage: $validated['per_page'], page: $validated['page']);
        $ordenesArray = OrdenDePagoElectronico::with('beneficiario', 'cuenta_contable')->get();
        //>with('beneficiario', 'cuenta_contable')->where('id_proceso', '=', $validated['id_proceso'])->orderBy('id');
        if ($ordenesArray->isEmpty()) {
            return response()->json([
                'message' => 'No existe el proceso orden de pago numero: ' . $validated['id_proceso'],
            ], 204);
        }
        return response()->json([
            'items' => $ordenesArray
        ], 201);
    }

    //public function consultarUltimasOrdenes(Request)
}

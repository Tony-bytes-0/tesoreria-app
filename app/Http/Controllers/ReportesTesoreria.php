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
            'perPage' => 'numeric|required',
            'page' => 'numeric|required',
        ]);
        $ordenesArray = OrdenDePagoElectronico::with('beneficiario')->orderBy('id')->paginate(perPage: $validated['perPage'], page: $validated['page']);
        //$ordenesArray = DB::table('orden_de_pago_electronicos')->orderBy('id')->simplePaginate();
        return response()->json([
            'items' => $ordenesArray
        ], 201);
    }
}

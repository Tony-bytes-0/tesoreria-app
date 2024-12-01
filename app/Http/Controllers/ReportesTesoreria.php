<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\OrdenDePagoElectronico;
use Illuminate\Support\Facades\DB;

class ReportesTesoreria extends Controller
{

    public function viewConsultarOrdenesDePago()
    {

        $ordenesArray = OrdenDePagoElectronico::get();
        return Inertia::render('reportes tesoreria/OrdenesDePago', [
            'ordenesDePago' => $ordenesArray
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

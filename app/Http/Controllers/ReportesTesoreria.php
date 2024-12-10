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
            'id_proceso' => 'required|numeric',
            'per_page' => 'numeric|required',
            'page' => 'numeric|required',
        ]);
        $ordenesArray = OrdenDePagoElectronico::with('beneficiario')->where('id_proceso', '=', $validated['id_proceso'])->orderBy('id')->paginate(perPage: $validated['per_page'], page: $validated['page']);
        //$ordenesArray = DB::table('orden_de_pago_electronicos')->orderBy('id')->simplePaginate();
        if($ordenesArray->isEmpty()){
            return response()->json([
                'message' => 'No existe el proceso orden de pago numero: '.$validated['id_proceso'],
            ], 204);
        }
        return response()->json([
            'items' => $ordenesArray
        ], 201);
    }

    //public function consultarUltimasOrdenes(Request)
}

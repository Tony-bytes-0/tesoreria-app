<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\OrdenDePagoElectronico;

class ReportesTesoreria extends Controller
{
    
    public function viewConsultarOrdenesDePago(){

        $ordenesArray = OrdenDePagoElectronico::get();
        return Inertia::render('reportes tesoreria/OrdenesDePago', [
            'ordenesDePago'=> $ordenesArray
        ]);
    }

    public function consultarOrdenesDePago(){
        $ordenesArray = OrdenDePagoElectronico::get();
    }
}

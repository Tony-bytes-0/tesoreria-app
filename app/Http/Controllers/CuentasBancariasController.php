<?php

namespace App\Http\Controllers;

use App\Models\CuentasBancaria;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CuentasBancariasController extends Controller
{
    public function consultar_cuentas_bancarias(){
        
        $naviarca = CuentasBancaria::where('empresa_id', '=', 'J080056043')->get();
        $grancacique = CuentasBancaria::where('empresa_id', '=', 'J303876056')->get();
        //$serviencomiendas = CuentasBancaria::where('empresa_id', '=', ' RIF SERVIENCOMIENDAS')->get();
        return response()->json([
            'cuentasNaviarca'=> $naviarca,
            'cuentasGc' => $grancacique,
            //'cuentasServiencomiendas' => $serviencomiendas,
        ]);
    }

}

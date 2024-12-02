<?php

namespace App\Http\Controllers;

use App\Models\CuentasContable;
use Illuminate\Http\Request;

class CuentasContablesController extends Controller
{
    public function consultar(Request $request){
        $cuentaContableInstance = CuentasContable::get();

        dd($cuentaContableInstance);

        return response()->json([
            'cuentas_contables' => $cuentaContableInstance['']
        ], status: 201);
    }
}

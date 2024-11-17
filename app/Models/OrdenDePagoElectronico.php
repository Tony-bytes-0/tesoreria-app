<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrdenDePagoElectronico extends Model
{
    //protected $table = 'orden_de_pago_electronicos';

    protected $fillable = [
        'fecha',
        'tipo',
        'factura',
        'monto_total',
        'retencion_islr',
        'transferencia',
        'comision_bancaria',
        'registro_contable',
        'autorizacion',
        'rif',
        'banco_nombre',
        'codigo_cuenta',
        'tipo_cuenta',
        'beneficiario',
        'concepto',
        'numero_orden_de_pago'
    ];
}

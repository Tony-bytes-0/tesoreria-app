<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrdenDePagoElectronico extends Model
{
    //protected $table = 'orden_de_pago_electronicos';
    protected $primaryKey = 'orden';
    protected $fillable = ['fecha', 'tipo', 'orden', 'factura',
     'monto_total', 'retencion_islr', 'transferencia', 'divisas' ,
     'comision_bancaria', 'registro_contable', 'autorizacion',
    'rif', 'cuenta_bancaria', 
    ];
}

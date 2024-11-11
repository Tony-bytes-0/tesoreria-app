<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrdenDePagoElectronico extends Model
{
    //protected $table = 'orden_de_pago_electronicos';
    protected $primaryKey = 'numero_orden';
    protected $fillable = ['referencia_profit', 'autorizacion', 'monto_transferencia', 'monto_divisas', 'comision_bancaria', 'retencion_islr', 'registro_contable'];

}

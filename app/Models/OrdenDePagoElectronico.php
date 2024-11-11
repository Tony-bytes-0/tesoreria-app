<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrdenDePagoElectronico extends Model
{
    //protected $table = 'orden_de_pago_electronicos';
    protected $primaryKey = 'orden';
    protected $fillable = ['orden', 'factura', 'tipo', 'referencia',
     'beneficiario', 'autorizacion', 'registro_contable', 'fecha' ,
     'transferencia', 'divisas', 'comision_bancaria', 'retencion_islr'];
}

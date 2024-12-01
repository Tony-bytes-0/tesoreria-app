<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
        'tasa',
        'numero_orden_de_pago',
        'id_beneficiario',
        'id_proceso',
        //'perPage', 'page'
    ];

    public function beneficiario()
    {
        return $this->hasMany(Beneficiario_cuentas::class, 'id');
    }
    public function id_proceso()
    {
        return $this->hasMany(ProcesoOrdenDePago::class);
    }
}

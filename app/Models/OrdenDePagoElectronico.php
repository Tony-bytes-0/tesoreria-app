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
        'numero_personas',
        'id_beneficiario',
        'id_proceso',
        'id_cuenta_contable',
        //'perPage', 'page'
    ];

    public function beneficiario()
    {
        return $this->belongsTo(Beneficiario_cuentas::class, 'id_beneficiario', 'id');
    }
    public function proceso_id()
    {
        return $this->hasMany(ProcesoOrdenDePago::class);
    }
    public function cuenta_contable(){
        return $this->belongsTo( CuentasContable::class, 'id_cuenta_contable', 'id');
    }
}

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
        'id_beneficiario',
        'tasa'
    ];

    public function id_beneficiario()
    {
        return $this->hasMany(Beneficiario_cuentas::class);
    }
    public function referencia_proceso_orden_de_pago()
    {
        return $this->belongsTo(ProcesoOrdenDePago::class);
    }
}

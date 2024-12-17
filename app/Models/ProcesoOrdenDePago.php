<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProcesoOrdenDePago extends Model
{
    protected $fillable = [
        //'numero_orden_de_pago',
        'concepto',
        'secuencia',
        'monto_total',
        'transferencia',
        'comision_bancaria',
        'retencion_islr',
        'rif'

    ];
    public function proceso_id()
    {
        return $this->belongsTo(OrdenDePagoElectronico::class);
    }
    public function cuenta_id()
    {
        return $this->belongsTo(CuentasBancaria::class);
    }
}

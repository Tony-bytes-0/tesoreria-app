<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProcesoOrdenDePago extends Model
{
    protected $fillable = [
        'total',
        //'numero_orden_de_pago',
        'concepto',
        'secuencia',
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

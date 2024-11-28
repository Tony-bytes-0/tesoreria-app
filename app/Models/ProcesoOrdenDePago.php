<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProcesoOrdenDePago extends Model
{
    protected $fillable = [
        'total',
        //'numero_orden_de_pago',
        'concepto',
        'numero_orden_de_pago',
    ];
    public function id_proceso()
    {
        return $this->belongsTo(OrdenDePagoElectronico::class);
    }
}

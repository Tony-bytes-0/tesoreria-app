<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProcesoOrdenDePago extends Model
{
    protected $filleable = [
        'total','numero_orden_de_pago','concepto'
    ];
    public function numero_orden_de_pago()
    {
        return $this->hasMany(OrdenDePagoElectronico::class);
    }
}

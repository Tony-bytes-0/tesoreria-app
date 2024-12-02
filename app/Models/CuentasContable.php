<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CuentasContable extends Model
{
    //
    public function id_orden()
    {
        return $this->belongsTo(OrdenDePagoElectronico::class);
    }
}

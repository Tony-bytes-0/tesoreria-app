<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Beneficiario_cuentas extends Model
{
    protected $fillable = [
        'rif',
        'descripcion',
        'codigo_cuenta',
        'tipo_cuenta',
        'inactivo',
        'telefono',
        'responsable',
        'email',
    ];
    public function orden()
    {
        return $this->belongsTo(OrdenDePagoElectronico::class);
    }
}

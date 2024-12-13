<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CuentasBancaria extends Model
{
    protected $fillable = [
        'banco_id',
        'codigo_cuenta',
        'moneda_id',
        'deleted_at',
        'empresa_id',
    ];
}

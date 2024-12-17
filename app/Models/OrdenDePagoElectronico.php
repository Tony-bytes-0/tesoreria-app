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
        'beneficiario_id',
        'proceso_id',
        'cuenta_contable_id',
        'cuenta_bancaria_id',
        'secuencia',
        //'perPage', 'page'
    ];

    public function beneficiario()
    {
        return $this->belongsTo(Beneficiario_cuentas::class);
    }
    public function proceso()
    {
        return $this->hasMany(ProcesoOrdenDePago::class, 'id', 'proceso_id');
    }
    public function cuenta_bancaria()
    {
        return $this->belongsTo(CuentasBancaria::class );
    }
    public function cuenta_contable()
    {
        return $this->belongsTo(CuentasContable::class );
    }
}

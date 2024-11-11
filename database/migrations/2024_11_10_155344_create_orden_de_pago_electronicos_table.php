<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orden_de_pago_electronicos', function (Blueprint $table) {
            // ['referencia_profit', 'autorizacion', 'monto_transferencia', 'monto_divisas', 'comision_bancaria', 'retencion_islr', 'registro_contable']
            //$table->id();
            $table->timestamps();
            $table->string('rif');
            $table->string('cuenta_bancaria');
            $table->integer('orden');
            $table->integer('factura');
            $table->date('fecha');
            $table->string('tipo');
            $table->string('referencia');
            $table->string('beneficiario');
            $table->string('autorizacion');
            $table->string('registro_contable');
            $table->bigInteger('transferencia');
            $table->bigInteger('divisas');
            $table->bigInteger('comision_bancaria');
            $table->bigInteger('retencion_islr');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orden_de_pago_electronicos');
    }
};

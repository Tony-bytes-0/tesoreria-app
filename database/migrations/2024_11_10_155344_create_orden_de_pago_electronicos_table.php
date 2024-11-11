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
            $table->integer('orden');
            $table->integer('factura');
            $table->integer('numero_orden');
            $table->timestamps();
            $table->string('referencia_profit');
            $table->string('autorizacion');
            $table->string('registro_contable');
            $table->bigInteger('monto_transferencia');
            $table->bigInteger('monto_divisas');
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

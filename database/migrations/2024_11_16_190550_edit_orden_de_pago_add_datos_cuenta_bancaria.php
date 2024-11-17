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
        Schema::table('orden_de_pago_electronicos', function(Blueprint $table){
            $table->dropColumn('orden');
            $table->dropColumn('registro_contable');
            $table->dropColumn('cuenta_bancaria');
            #$table->renamecolumn(' ', ' ');# banco
            $table->string('banco_nombre');
            $table->string('codigo_cuenta');
            $table->string('tipo_cuenta');
            #columna adicional, concepto y numero_orden_de_pago
            $table->string('concepto');
            $table->dropColumn('referencia');
            $table->string('numero_orden_de_pago');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orden_de_pago_electronicos', function ($table) {
            $table->bigInteger('orden');
            $table->string('orden');
            $table->bigInteger('cuenta_bancaria');
            #banco
            $table->dropColumn('banco_nombre');
            $table->dropColumn('codigo_cuenta');
            $table->dropColumn('tipo_cuenta');
            #columna adicional, concepto
            $table->dropColumn('concepto');
            $table->dropColumn('numero_orden_de_pago');
            $table->string('referencia');
        });
    }
};

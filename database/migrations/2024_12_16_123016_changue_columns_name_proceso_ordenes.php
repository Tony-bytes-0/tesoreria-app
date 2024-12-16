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
            //$table->dropForeign('id_beneficiario');
            $table->foreignId('beneficiario_id')->nullable();
            $table->foreign('beneficiario_id')->references('id')->on('beneficiario_cuentas');

            //$table->dropForeign('id_proceso');
            $table->foreignId('proceso_id')->nullable();
            $table->foreign('proceso_id')->references('id')->on('proceso_orden_de_pagos');

            //$table->dropForeign('id_cuenta_contable');
            $table->foreignId('cuenta_contable_id')->nullable();
            $table->foreign('cuenta_contable_id')->references('id')->on('cuentas_contables');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orden_de_pago_electronicos', function (Blueprint $table) {
            $table->dropForeign(['beneficiario_id']);
            $table->dropForeign(['proceso_id']);
            $table->dropForeign(['cuenta_contable_id']);

            //$table->foreign('id_beneficiario')->references('id')->on('beneficiario_cuentas');
            //$table->foreign('id_proceso')->references('id')->on('proceso_orden_de_pagos');
            //$table->foreign('id_cuenta_contable')->references('id')->on('cuentas_contables');
        });
    }
};

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
            $table->string('concepto')->nullable()->change();
            $table->string('codigo_cuenta_beneficiario')->nullable();
            $table->string('identificacion_beneficiario')->nullable();
            $table->float('tasa')->nullable();
        });

        Schema::create('beneficiario_cuentas', function(Blueprint $table) {
            $table->id();
            $table->string('rif');
            $table->string('descripcion');
            $table->string('codigo_cuenta');
            $table->string('tipo_cuenta');
            $table->boolean('inactivo');
            $table->string('telefono');
            $table->string('responsable');
            $table->string('email');

            //$this->
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orden_de_pago_electronicos', function (Blueprint $table) {
            $table->string('concepto')->change();
            $table->dropColumn('codigo_cuenta_beneficiario');
            $table->dropColumn('identificacion_beneficiario');
            $table->dropColumn('tasa');
        }); {
            Schema::dropIfExists('beneficiario_cuentas');
        }
    }
};

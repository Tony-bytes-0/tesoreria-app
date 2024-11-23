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
        Schema::table('orden_de_pago_electronicos', function(blueprint $table) {
            $table->dropColumn('codigo_cuenta_beneficiario');
            $table->dropColumn('identificacion_beneficiario');
        });
    }

    public function down(): void
    {
        Schema::table('orden_de_pago_electronicos', function (blueprint $table) {
            $table->string('codigo_cuenta_beneficiario');
            $table->string('identificacion_beneficiario');
        });
    }
};

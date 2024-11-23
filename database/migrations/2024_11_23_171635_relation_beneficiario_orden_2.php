<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RelationBeneficiarioOrden2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::table('orden_de_pago_electronicos', function (Blueprint $table) {
            $table->foreignId('beneficiario_cuentas_id')
                ->constrained('beneficiario_cuentas');
                //->onDelete('cascade');
                //->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('orden_de_pago_electronicos', function (Blueprint $table) {
            $table->dropForeign(['beneficiario_cuentas_id']);
        });
    }
};

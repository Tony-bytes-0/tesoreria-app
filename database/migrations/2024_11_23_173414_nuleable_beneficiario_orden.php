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
        Schema::table('orden_de_pago_electronicos', function (Blueprint $table) {
            $table->string('beneficiario')->nullable()->change();
            $table->renameColumn('beneficiario_cuentas_id', 'id_beneficiario');
            $table->dropColumn('beneficiario_cuentas');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table(
            'orden_de_pago_electronicos',
            function (Blueprint $table) {
                $table->renameColumn('id_beneficiario', 'beneficiario_cuentas_id');
                $table->foreignId('beneficiario_cuentas');
            }
        );
    }
};

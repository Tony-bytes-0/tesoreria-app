<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RelationBeneficiarioOrden extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        // Step 1 & 2: Remove null values and add the foreign key constraint
        Schema::table('orden_de_pago_electronicos', function (Blueprint $table) {
            $table->foreignId('beneficiario_cuentas')->constrained();
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
            // Remove unique constraint if added
            $table->dropUnique(['id_beneficiario']);
        });
    }
};

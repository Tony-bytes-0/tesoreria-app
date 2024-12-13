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
        schema::table('cuentas_bancarias', function(Blueprint $table){
            $table->string('banco_nombre')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        schema::table('cuentas_bancarias', function (Blueprint $table) {
            $table->dropColumn('banco_nombre');
        });
    }
};

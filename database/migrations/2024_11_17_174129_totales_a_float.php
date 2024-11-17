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
        Schema::table('orden_de_pago_electronicos', function(Blueprint $table) {
           $table->float('monto_total')->change();
            $table->float('comision_bancaria')->change();
            $table->float('retencion_islr')->change();
            $table->float('transferencia')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orden_de_pago_electronicos', function (Blueprint $table) {
            $table->bigInteger('monto_total')->change();
            $table->bigInteger('comision_bancaria')->change();
            $table->bigInteger('retencion_islr')->change();
            $table->bigInteger('transferencia')->change();
        });
    }
};

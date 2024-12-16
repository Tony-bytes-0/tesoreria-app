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
            //$table->dropForeign('id_beneficiario');
            //$table->integer('id_beneficiario')->nullable()->unsigned()->change();
            $table->dropForeign(['id_proceso']);  
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};

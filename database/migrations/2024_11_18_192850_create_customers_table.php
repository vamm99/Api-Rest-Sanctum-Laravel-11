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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('uid')->unique();
            $table->string('nombre');
            $table->string('apellido');
            $table->string('cc');
            $table->string('telefono');
            $table->string('email')->unique();
            $table->timestamps();
            $table->decimal('saldo_acumulado', 8, 2)->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('contadores', function (Blueprint $table) {
            $table->id();
            $table->string('numero_contador', 50)->unique();
            $table->string('nome_proprietario', 255);
            $table->text('endereco');
            $table->decimal('saldo_kwh', 10, 2)->default(0);
            $table->string('password')->nullable();
            $table->rememberToken();
            $table->timestamps();

            $table->index('numero_contador');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contadores');
    }
};

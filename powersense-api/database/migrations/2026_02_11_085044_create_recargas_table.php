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
        Schema::create('recargas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('contador_id')->constrained('contadores')->onDelete('cascade');
            $table->string('codigo_recarga', 100)->unique();
            $table->decimal('valor_mt', 10, 2);
            $table->decimal('kwh', 10, 2);
            $table->timestamp('data_recarga');
            $table->enum('status', ['pendente', 'confirmado', 'cancelado'])->default('confirmado');
            $table->timestamps();

            $table->index('contador_id');
            $table->index('data_recarga');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recargas');
    }
};

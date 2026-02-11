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
        Schema::create('consumos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('contador_id')->constrained('contadores')->onDelete('cascade');
            $table->decimal('kwh_consumido', 10, 2);
            $table->decimal('potencia_kw', 10, 2)->nullable();
            $table->timestamp('data_hora');
            $table->timestamp('created_at')->useCurrent();

            $table->index(['contador_id', 'data_hora']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('consumos');
    }
};

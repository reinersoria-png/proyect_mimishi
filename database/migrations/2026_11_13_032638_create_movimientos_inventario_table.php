<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('movimientos_inventario', function (Blueprint $table) {
            $table->id();

            $table->foreignId('inventario_id')
                ->constrained('inventarios')
                ->restrictOnDelete();

            $table->foreignId('user_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->string('tipo_movimiento', 30);

            $table->unsignedInteger('cantidad');

            $table->unsignedInteger('stock_anterior');
            $table->unsignedInteger('stock_posterior');

            $table->string('tipo_referencia', 50)->nullable();
            $table->unsignedBigInteger('referencia_id')->nullable();

            $table->text('motivo')->nullable();

            $table->timestamps();

            $table->index(['inventario_id', 'created_at']);
            $table->index(['tipo_referencia', 'referencia_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('movimientos_inventario');
    }
};

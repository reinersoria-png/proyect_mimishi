<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pagos', function (Blueprint $table) {
            $table->id();

            $table->foreignId('pedido_id')
                ->constrained('pedidos')
                ->restrictOnDelete();

            $table->string('metodo_pago', 50);
            $table->string('pasarela', 50)->nullable();

            $table->string('referencia_transaccion', 150)
                ->nullable()
                ->unique();

            $table->decimal('monto', 10, 2);
            $table->string('moneda', 3)->default('PEN');

            $table->string('estado', 30)->default('pendiente');

            $table->text('mensaje_respuesta')->nullable();

            $table->timestamp('fecha_pago')->nullable();

            $table->timestamps();

            $table->index(['pedido_id', 'estado']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pagos');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reembolsos', function (Blueprint $table) {
            $table->id();

            $table->foreignId('pago_id')
                ->constrained('pagos')
                ->restrictOnDelete();

            $table->foreignId('solicitado_por')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->foreignId('autorizado_por')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->decimal('monto', 10, 2);

            $table->text('motivo');

            $table->string('estado', 30)
                ->default('pendiente');

            $table->string('referencia_reembolso', 150)
                ->nullable()
                ->unique();

            $table->text('observaciones')->nullable();

            $table->timestamp('fecha_autorizacion')->nullable();
            $table->timestamp('fecha_reembolso')->nullable();

            $table->timestamps();

            $table->index(['pago_id', 'estado']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reembolsos');
    }
};

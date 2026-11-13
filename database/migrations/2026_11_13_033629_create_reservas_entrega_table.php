<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reservas_entrega', function (Blueprint $table) {
            $table->id();

            $table->foreignId('envio_id')
                ->constrained('envios')
                ->restrictOnDelete();

            $table->foreignId('horario_entrega_id')
                ->constrained('horarios_entrega')
                ->restrictOnDelete();

            $table->foreignId('programado_por')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->foreignId('reserva_anterior_id')
                ->nullable()
                ->constrained('reservas_entrega')
                ->nullOnDelete();

            $table->string('estado', 30)
                ->default('reservada');

            $table->string('motivo_reprogramacion', 150)
                ->nullable();

            $table->timestamp('fecha_reserva')
                ->useCurrent();

            $table->timestamp('fecha_cancelacion')
                ->nullable();

            $table->text('observaciones')->nullable();

            $table->timestamps();

            $table->index(['envio_id', 'estado']);
            $table->index(['horario_entrega_id', 'estado']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reservas_entrega');
    }
};

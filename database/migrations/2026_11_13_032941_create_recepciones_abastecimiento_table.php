<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('recepciones_abastecimiento', function (Blueprint $table) {
            $table->id();

            $table->string('numero_recepcion', 30)->unique();

            $table->foreignId('solicitud_abastecimiento_id')
                ->constrained('solicitudes_abastecimiento')
                ->restrictOnDelete();

            $table->foreignId('recibido_por')
                ->constrained('users')
                ->restrictOnDelete();

            $table->timestamp('fecha_recepcion');

            $table->string('estado', 30)->default('pendiente');

            $table->text('observaciones')->nullable();

            $table->timestamps();

            $table->index([
                'solicitud_abastecimiento_id',
                'estado'
            ], 'recepciones_solicitud_estado_idx');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('recepciones_abastecimiento');
    }
};

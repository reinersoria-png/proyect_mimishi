<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('solicitudes_abastecimiento', function (Blueprint $table) {
            $table->id();

            $table->string('numero_solicitud', 30)->unique();

            $table->foreignId('proveedor_id')
                ->constrained('users')
                ->restrictOnDelete();

            $table->foreignId('solicitado_por')
                ->constrained('users')
                ->restrictOnDelete();

            $table->string('estado', 30)->default('pendiente');

            $table->decimal('total_estimado', 12, 2)->default(0);

            $table->date('fecha_entrega_estimada')->nullable();

            $table->timestamp('fecha_respuesta')->nullable();

            $table->text('observaciones')->nullable();

            $table->text('motivo_rechazo')->nullable();

            $table->timestamps();

            $table->index(['proveedor_id', 'estado']);
            $table->index(['solicitado_por', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('solicitudes_abastecimiento');
    }
};

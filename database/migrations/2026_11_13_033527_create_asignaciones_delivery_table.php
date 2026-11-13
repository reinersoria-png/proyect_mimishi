<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('asignaciones_delivery', function (Blueprint $table) {
            $table->id();

            $table->foreignId('envio_id')
                ->constrained('envios')
                ->restrictOnDelete();

            $table->foreignId('transportista_id')
                ->constrained('transportistas')
                ->restrictOnDelete();

            $table->foreignId('asignado_por')
                ->constrained('users')
                ->restrictOnDelete();

            $table->timestamp('fecha_asignacion')
                ->useCurrent();

            $table->timestamp('fecha_aceptacion')->nullable();

            $table->timestamp('fecha_finalizacion')->nullable();

            $table->string('estado', 30)
                ->default('asignado');

            $table->text('observaciones')->nullable();

            $table->timestamps();

            $table->index(['envio_id', 'estado']);
            $table->index(['transportista_id', 'estado']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('asignaciones_delivery');
    }
};

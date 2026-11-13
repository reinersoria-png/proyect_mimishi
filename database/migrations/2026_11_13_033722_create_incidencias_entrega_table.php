<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('incidencias_entrega', function (Blueprint $table) {
            $table->id();

            $table->foreignId('envio_id')
                ->constrained('envios')
                ->restrictOnDelete();

            $table->foreignId('reportado_por')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->foreignId('resuelto_por')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->string('tipo_incidencia', 50);

            $table->text('descripcion');

            $table->string('estado', 30)
                ->default('pendiente');

            $table->string('accion_tomada', 150)
                ->nullable();

            $table->timestamp('fecha_incidencia')
                ->useCurrent();

            $table->timestamp('fecha_resolucion')
                ->nullable();

            $table->text('observaciones')->nullable();

            $table->timestamps();

            $table->index(['envio_id', 'estado']);
            $table->index(['tipo_incidencia', 'estado']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('incidencias_entrega');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('seguimiento_envios', function (Blueprint $table) {
            $table->id();

            $table->foreignId('envio_id')
                ->constrained('envios')
                ->restrictOnDelete();

            $table->foreignId('registrado_por')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->string('estado', 50);

            $table->string('ubicacion', 200)->nullable();

            $table->text('descripcion')->nullable();

            $table->timestamp('fecha_evento')
                ->useCurrent();

            $table->boolean('visible_cliente')
                ->default(true);

            $table->timestamps();

            $table->index(['envio_id', 'fecha_evento']);
            $table->index(['envio_id', 'visible_cliente']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('seguimiento_envios');
    }
};

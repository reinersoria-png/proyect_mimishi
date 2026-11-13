<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reclamo_seguimientos', function (Blueprint $table) {
            $table->id();

            $table->foreignId('reclamo_id')
                ->constrained('reclamos')
                ->restrictOnDelete();

            $table->foreignId('registrado_por')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->string('estado_anterior', 30)->nullable();

            $table->string('estado_nuevo', 30);

            $table->text('descripcion');

            $table->boolean('visible_cliente')
                ->default(true);

            $table->timestamp('fecha_evento')
                ->useCurrent();

            $table->timestamps();

            $table->index(['reclamo_id', 'fecha_evento']);
            $table->index(['reclamo_id', 'visible_cliente']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reclamo_seguimientos');
    }
};

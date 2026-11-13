<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('recepcion_detalles', function (Blueprint $table) {
            $table->id();

            $table->foreignId('recepcion_abastecimiento_id')
                ->constrained('recepciones_abastecimiento')
                ->restrictOnDelete();

            $table->foreignId('abastecimiento_detalle_id')
                ->constrained('abastecimiento_detalles')
                ->restrictOnDelete();

            $table->unsignedInteger('cantidad_recibida');

            $table->unsignedInteger('cantidad_aceptada');

            $table->unsignedInteger('cantidad_rechazada')
                ->default(0);

            $table->text('observaciones')->nullable();

            $table->timestamps();

            $table->unique([
                'recepcion_abastecimiento_id',
                'abastecimiento_detalle_id'
            ], 'recepcion_detalle_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('recepcion_detalles');
    }
};

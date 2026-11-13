<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('abastecimiento_detalles', function (Blueprint $table) {
            $table->id();

            $table->foreignId('solicitud_abastecimiento_id')
                ->constrained('solicitudes_abastecimiento')
                ->restrictOnDelete();

            $table->foreignId('producto_id')
                ->constrained('productos')
                ->restrictOnDelete();

            $table->unsignedInteger('cantidad_solicitada');

            $table->decimal('costo_unitario', 10, 2);

            $table->decimal('subtotal', 12, 2);

            $table->timestamps();

            $table->unique([
                'solicitud_abastecimiento_id',
                'producto_id'
            ], 'abastecimiento_producto_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('abastecimiento_detalles');
    }
};

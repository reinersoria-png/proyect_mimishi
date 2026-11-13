<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('comprobantes', function (Blueprint $table) {
            $table->id();

            $table->foreignId('pedido_id')
                ->constrained('pedidos')
                ->restrictOnDelete();

            $table->string('tipo_comprobante', 20);

            $table->string('serie', 10);
            $table->unsignedInteger('correlativo');

            $table->string('tipo_documento', 10);
            $table->string('numero_documento', 20);

            $table->string('nombre_razon_social', 200);

            $table->string('direccion_fiscal')
                ->nullable();

            $table->decimal('subtotal', 12, 2);
            $table->decimal('igv', 12, 2);
            $table->decimal('total', 12, 2);

            $table->string('moneda', 3)->default('PEN');

            $table->string('estado', 30)
                ->default('pendiente');

            $table->timestamp('fecha_emision')->nullable();

            $table->string('codigo_sunat', 100)->nullable();

            $table->text('respuesta_sunat')->nullable();

            $table->string('ruta_xml')->nullable();
            $table->string('ruta_pdf')->nullable();
            $table->string('ruta_cdr')->nullable();

            $table->timestamps();

            $table->unique(['serie', 'correlativo']);

            $table->index(['pedido_id', 'tipo_comprobante']);
            $table->index(['numero_documento', 'fecha_emision']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('comprobantes');
    }
};

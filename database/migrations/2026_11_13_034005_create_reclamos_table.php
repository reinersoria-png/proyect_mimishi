<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reclamos', function (Blueprint $table) {
            $table->id();

            $table->string('numero_reclamo', 30)->unique();

            $table->foreignId('user_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->foreignId('pedido_id')
                ->nullable()
                ->constrained('pedidos')
                ->restrictOnDelete();

            $table->string('tipo', 20);

            $table->string('nombre_cliente', 150);
            $table->string('tipo_documento', 20);
            $table->string('numero_documento', 20);

            $table->string('email', 150);
            $table->string('telefono', 20)->nullable();
            $table->string('direccion_cliente')->nullable();

            $table->string('bien_contratado', 30);
            $table->decimal('monto_reclamado', 12, 2)->nullable();

            $table->text('descripcion');
            $table->text('pedido_cliente');

            $table->string('estado', 30)->default('pendiente');

            $table->foreignId('atendido_por')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->text('respuesta')->nullable();

            $table->timestamp('fecha_presentacion')
                ->useCurrent();

            $table->timestamp('fecha_respuesta')->nullable();

            $table->timestamps();

            $table->index(['user_id', 'estado']);
            $table->index(['tipo', 'estado']);
            $table->index('fecha_presentacion');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reclamos');
    }
};

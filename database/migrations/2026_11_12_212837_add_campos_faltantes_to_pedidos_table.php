<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pedidos', function (Blueprint $table) {
            $table->string('numero_pedido', 30)->unique();

            $table->foreignId('user_id')
                ->constrained('users')
                ->restrictOnDelete();

            $table->decimal('subtotal', 10, 2);
            $table->decimal('descuento', 10, 2)->default(0);
            $table->decimal('costo_envio', 10, 2)->default(0);
            $table->decimal('total', 10, 2);

            $table->string('estado', 30)->default('pendiente_pago');

            $table->string('destinatario', 150);
            $table->string('telefono_entrega', 20);
            $table->string('departamento_entrega', 100);
            $table->string('provincia_entrega', 100);
            $table->string('distrito_entrega', 100);
            $table->string('direccion_entrega');
            $table->string('referencia_entrega')->nullable();

            $table->text('observaciones')->nullable();

            $table->timestamp('fecha_pago')->nullable();
            $table->timestamp('fecha_cancelacion')->nullable();

            $table->index(['user_id', 'estado']);
        });
    }

    public function down(): void
    {
        Schema::table('pedidos', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropIndex(['user_id', 'estado']);

            $table->dropColumn([
                'numero_pedido',
                'user_id',
                'subtotal',
                'descuento',
                'costo_envio',
                'total',
                'estado',
                'destinatario',
                'telefono_entrega',
                'departamento_entrega',
                'provincia_entrega',
                'distrito_entrega',
                'direccion_entrega',
                'referencia_entrega',
                'observaciones',
                'fecha_pago',
                'fecha_cancelacion'
            ]);
        });
    }
};


<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('envios', function (Blueprint $table) {
            $table->id();

            $table->string('numero_envio', 30)->unique();

            $table->foreignId('pedido_id')
                ->constrained('pedidos')
                ->restrictOnDelete();

            $table->foreignId('zona_entrega_id')
                ->constrained('zonas_entrega')
                ->restrictOnDelete();

            $table->foreignId('transportista_id')
                ->nullable()
                ->constrained('transportistas')
                ->restrictOnDelete();

            $table->string('tipo_envio', 30);

            $table->string('estado', 30)
                ->default('pendiente');

            $table->string('codigo_seguimiento', 100)
                ->nullable()
                ->unique();

            $table->decimal('costo_envio', 10, 2)
                ->default(0);

            $table->timestamp('fecha_programada')->nullable();

            $table->timestamp('fecha_despacho')->nullable();

            $table->timestamp('fecha_entrega')->nullable();

            $table->text('observaciones')->nullable();

            $table->timestamps();

            $table->index(['pedido_id', 'estado']);
            $table->index(['transportista_id', 'estado']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('envios');
    }
};

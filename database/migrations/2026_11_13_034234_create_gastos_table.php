
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('gastos', function (Blueprint $table) {
            $table->id();

            $table->string('codigo_gasto', 30)->unique();

            $table->foreignId('registrado_por')
                ->constrained('users')
                ->restrictOnDelete();

            $table->string('categoria', 100);

            $table->string('concepto', 200);

            $table->text('descripcion')->nullable();

            $table->decimal('monto', 12, 2);

            $table->string('moneda', 3)->default('PEN');

            $table->date('fecha_gasto');

            $table->string('metodo_pago', 50)->nullable();

            $table->string('tipo_comprobante', 30)->nullable();

            $table->string('numero_comprobante', 50)->nullable();

            $table->string('proveedor_beneficiario', 200)
                ->nullable();

            $table->string('ruta_comprobante')->nullable();

            $table->string('estado', 30)
                ->default('registrado');

            $table->text('observaciones')->nullable();

            $table->timestamps();

            $table->index(['categoria', 'fecha_gasto']);
            $table->index(['registrado_por', 'fecha_gasto']);
            $table->index(['estado', 'fecha_gasto']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('gastos');
    }
};

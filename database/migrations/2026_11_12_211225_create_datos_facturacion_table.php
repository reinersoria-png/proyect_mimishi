<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('datos_facturacion', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->enum('tipo_documento', [
                'DNI',
                'RUC'
            ]);

            $table->string('numero_documento', 11);
            $table->string('nombre_razon_social', 200);
            $table->string('direccion_fiscal', 255)->nullable();

            $table->timestamps();

            $table->unique([
                'user_id',
                'tipo_documento',
                'numero_documento'
            ], 'datos_facturacion_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('datos_facturacion');
    }
};

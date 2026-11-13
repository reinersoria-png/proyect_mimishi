<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('zonas_entrega', function (Blueprint $table) {
            $table->id();

            $table->string('nombre', 150);

            $table->string('departamento', 100);
            $table->string('provincia', 100);
            $table->string('distrito', 100)->nullable();

            $table->string('tipo_entrega', 30);

            $table->decimal('costo_envio', 10, 2)->default(0);

            $table->unsignedInteger('tiempo_estimado_dias')
                ->nullable();

            $table->boolean('activo')->default(true);

            $table->text('observaciones')->nullable();

            $table->timestamps();

            $table->index([
                'departamento',
                'provincia',
                'distrito'
            ], 'zonas_ubicacion_idx');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('zonas_entrega');
    }
};

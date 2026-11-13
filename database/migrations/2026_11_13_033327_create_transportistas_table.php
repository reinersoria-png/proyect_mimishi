<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transportistas', function (Blueprint $table) {
            $table->id();

            $table->string('tipo', 30);

            $table->foreignId('user_id')
                ->nullable()
                ->unique()
                ->constrained('users')
                ->restrictOnDelete();

            $table->string('nombre', 150);

            $table->string('documento_identidad', 20)
                ->nullable();

            $table->string('telefono', 20)->nullable();

            $table->string('email', 150)->nullable();

            $table->string('empresa', 150)->nullable();

            $table->string('placa_vehiculo', 15)->nullable();

            $table->string('tipo_vehiculo', 50)->nullable();

            $table->boolean('activo')->default(true);

            $table->text('observaciones')->nullable();

            $table->timestamps();

            $table->index(['tipo', 'activo']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transportistas');
    }
};

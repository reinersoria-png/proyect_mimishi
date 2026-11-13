
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('horarios_entrega', function (Blueprint $table) {
            $table->id();

            $table->foreignId('zona_entrega_id')
                ->constrained('zonas_entrega')
                ->restrictOnDelete();

            $table->date('fecha');

            $table->time('hora_inicio');
            $table->time('hora_fin');

            $table->unsignedInteger('capacidad_maxima');

            $table->boolean('activo')->default(true);

            $table->text('observaciones')->nullable();

            $table->timestamps();

            $table->unique([
                'zona_entrega_id',
                'fecha',
                'hora_inicio',
                'hora_fin'
            ], 'horarios_entrega_unique');

            $table->index(['fecha', 'activo']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('horarios_entrega');
    }
};


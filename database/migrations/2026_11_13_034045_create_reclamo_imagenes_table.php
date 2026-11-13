
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reclamo_imagenes', function (Blueprint $table) {
            $table->id();

            $table->foreignId('reclamo_id')
                ->constrained('reclamos')
                ->restrictOnDelete();

            $table->string('nombre_archivo', 255);

            $table->string('ruta_imagen');

            $table->string('tipo_archivo', 50);

            $table->unsignedBigInteger('tamano_bytes');

            $table->text('descripcion')->nullable();

            $table->timestamps();

            $table->index('reclamo_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reclamo_imagenes');
    }
};

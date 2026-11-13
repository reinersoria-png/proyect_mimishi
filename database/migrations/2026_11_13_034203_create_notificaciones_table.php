
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notificaciones', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->string('tipo', 50);

            $table->string('titulo', 150);

            $table->text('mensaje');

            $table->string('tipo_referencia', 50)->nullable();

            $table->unsignedBigInteger('referencia_id')->nullable();

            $table->string('url_destino')->nullable();

            $table->boolean('leida')->default(false);

            $table->timestamp('fecha_lectura')->nullable();

            $table->timestamps();

            $table->index(['user_id', 'leida']);
            $table->index(['tipo_referencia', 'referencia_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notificaciones');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('productos', function (Blueprint $table) {
            $table->id(); // <--- ¡Esta línea faltaba!

            // Relación con Categorías (Ubicaciones)
            $table->foreignId('categoria_id')
                  ->constrained('categorias')
                  ->onDelete('cascade');

            $table->string('codigo')->nullable(); // Ej: TG-ADM-0001
            $table->string('nombre');
            $table->string('marca')->nullable();
            $table->string('modelo')->nullable();
            $table->string('serie')->nullable();
            $table->integer('stock')->default(1);
            $table->string('imagen')->nullable();
            $table->enum('estado', ['Activo', 'Inactivo'])->default('Activo');

            $table->timestamps();
            $table->softDeletes(); // Borrado suave
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('productos');
    }
};

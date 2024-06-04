<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('productos', function (Blueprint $table) {
            $table->id(); // Define el campo id_producto como la clave primaria
            $table->string('nombre');
            $table->text('descripcion')->nullable();
            $table->string('imagen_url', 255)->nullable(); // Agrega el campo imagen_url
            $table->decimal('precio', 8, 2); // Define el campo precio con dos decimales
            $table->integer('cantidad');
            $table->timestamps(); // Define los campos created_at y updated_at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('productos');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePedidosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pedidos', function (Blueprint $table) {
            $table->id(); // Define el campo id_punventa como la clave primaria
            $table->string('descripcion');
            $table->decimal('total', 10, 2);
            $table->decimal('dinero', 10, 2);
            $table->text('extras')->nullable();
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
        Schema::dropIfExists('pedidos');
    }
}

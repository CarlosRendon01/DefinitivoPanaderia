<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;



class CreateLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

     
    public function up()
    {
        Schema::create('logs', function (Blueprint $table) {
            $table->id(); // ID autoincremental como llave primaria
            $table->timestamps(); // Campos opcionales para la fecha de creación y actualización
            $table->string('action');
            $table->string('table');
            $table->unsignedBigInteger('record_id');
            $table->text('executedSQL');
            $table->text('reverseSQL');
            $table->string('user_name')->nullable(); // Agregar campo para almacenar el nombre de usuario
          
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('logs');
    }
}
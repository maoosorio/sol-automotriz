<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrasladosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('traslados', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sucursal_origen')->constrained('sucursales');
            $table->foreignId('sucursal_destino')->constrained('sucursales');
            $table->foreignId('vehiculo_id')->constrained('vehiculos');
            $table->foreignId('usuario_id')->constrained('users');
            $table->string('observaciones');
            $table->string('link');
            $table->string('estado');
            $table->timestamps();
            $table->unique( array('id','sucursal_origen','sucursal_destino') );
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('traslados');
    }
}

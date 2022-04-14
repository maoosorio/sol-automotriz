<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEtapasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('etapas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('proceso_id')->constrained('procesos');
            $table->string('etapa')->nullable();
            $table->string('valor')->nullable();
            $table->integer('proceso_padre')->nullable();
            $table->foreignId('usuario_id')->constrained('users');
            $table->timestamps();
        });

        // Schema::create('etapas', function (Blueprint $table) {
        //     $table->id();
        //     $table->foreignId('vehiculo_id')->constrained('vehiculos');
        //     $table->integer('proceso')->nullable();
        //     $table->string('etapa1')->nullable();
        //     $table->string('valor1')->nullable();
        //     $table->string('etapa2')->nullable();
        //     $table->string('valor2')->nullable();
        //     $table->string('etapa3')->nullable();
        //     $table->string('valor3')->nullable();
        //     $table->string('etapa4')->nullable();
        //     $table->string('valor4')->nullable();
        //     $table->string('etapa5')->nullable();
        //     $table->string('valor5')->nullable();
        //     $table->string('link')->nullable();
        //     $table->foreignId('usuario_id')->constrained('usuarios');
        //     $table->timestamps();
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('etapas');
    }
}

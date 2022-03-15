<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActividadesTecnicosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('actividades_tecnicos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('actividad_id')->constrained('actividades');
            $table->foreignId('horario_id')->constrained('horarios');
            $table->foreignId('vehiculo_id')->constrained('vehiculos');
            $table->string('actividad');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('actividades_tecnicos');
    }
}

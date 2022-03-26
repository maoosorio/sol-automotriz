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
            $table->decimal('valor_metrico', $precision = 8, $scale = 2)->nullable($value = true);
            $table->boolean('vmes')->nullable();
            $table->decimal('valor_monetario', 8, 2)->nullable($value = true);
            $table->boolean('vmos')->nullable();
            $table->string('actividad');
            $table->timestamps();
            $table->unique( array('actividad_id','horario_id', 'vehiculo_id') );
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

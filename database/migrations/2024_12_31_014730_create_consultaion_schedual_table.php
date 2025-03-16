<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConsultaionSchedualTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('consultaion_schedual', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->time('time');

            $table->unsignedBigInteger('consultaion_id');

            // Foreign keys
            $table->foreign('consultaion_id')
                ->references('id')
                ->on('consultaion')
                ->onDelete('cascade');

            $table->boolean('available');

            $table->unique(['consultaion_id', 'date', 'time'], 'unique_consultaion_date_time');



            
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
        Schema::dropIfExists('consultaion_schedual');
    }
}

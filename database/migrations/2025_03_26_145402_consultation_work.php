<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ConsultationWork extends Migration
{
    public function up()
    {
        Schema::create('consultation_works', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->text('description')->nullable();
            $table->string('image')->nullable(); // Store image path
            $table->string('main_image')->nullable(); // Store main image path
            $table->timestamps();
        });

        Schema::create('consultation_work_steps', function (Blueprint $table) {
            $table->id();
            $table->foreignId('consultation_work_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('image')->nullable(); // Store image path for the step
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
        //
    }
}

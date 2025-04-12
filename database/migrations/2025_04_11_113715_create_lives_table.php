<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLivesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lives', function (Blueprint $table) {
            $table->id();
            $table->string('main_image');
            $table->double('price');
            $table->string('title_ar');
            $table->string('title_en');
            $table->longText('description_ar');
            $table->longText('description_en');
            $table->date('day_date')->nullable();
            $table->string('video_url')->nullable(); // Path to preview video

            $table->time('from')->nullable();
            $table->time('to')->nullable();
            $table->integer('duration_minutes')->nullable();

            $table->unsignedBigInteger('assign_to')->nullable();
            $table->foreign('assign_to')->references('id')->on('employees')->onUpdate('cascade')->onDelete('cascade');

             $table->string('zoom_meeting_id', 255)->nullable();
            $table->string('zoom_join_url', 500)->nullable(); // Increase length for URLs
            $table->string('zoom_start_url', 500)->nullable(); // Increase length for URLs            $table->string('preview_video')->nullable();

            $table->boolean('publish')->default(true);
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
        Schema::dropIfExists('lives');
    }
}

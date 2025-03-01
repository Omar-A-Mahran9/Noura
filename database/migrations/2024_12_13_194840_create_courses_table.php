<?php

use App\Enums\CoursesStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('name_ar');
            $table->string('name_en');
            $table->text('description_ar');
            $table->text('description_en');
            $table->string('preview_video_path')->nullable(); // Path to preview video
            $table->integer('discount_price')->nullable();
            $table->boolean('have_discount')->default(false);
            $table->double('price');
            $table->integer('discount_duration_days_counts');
            $table->longText('images');
            $table->string('status')->default(CoursesStatus::pending->value)->comment('App\Enums\CoursesStatus');
            $table->string('rejection_reason')->nullable();
            $table->date('from');
            $table->date('to');

            $table->boolean('open')->default(false);
            $table->unsignedBigInteger('created_by')->nullable();
            $table->foreign('created_by')->references('id')->on('employees')->onUpdate('cascade')->onDelete('cascade');

            $table->unsignedBigInteger('assign_to')->nullable();
            $table->foreign('assign_to')->references('id')->on('employees')->onUpdate('cascade')->onDelete('cascade');

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
        Schema::dropIfExists('courses');
    }
}

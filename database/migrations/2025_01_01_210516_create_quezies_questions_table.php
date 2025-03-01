<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQueziesQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quezies_questions', function (Blueprint $table) {
            $table->id();
            $table->longText('name_ar');
            $table->longText('name_en');
            $table->enum('type', ['text','single', 'multiple', 'true_false'])->default('single');
            $table->boolean('is_main')->default(0);

            $table->unsignedBigInteger('quiz_id')->nullable();
            $table->foreign('quiz_id')
                ->references('id')
                ->on('quizzes')->onDelete('cascade');


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
        Schema::dropIfExists('quezies_questions');
    }
}

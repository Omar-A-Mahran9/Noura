<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVendorAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vendor_answers', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('quiz_id')->nullable();
            $table->foreign('quiz_id')
                    ->references('id')
                    ->on('quizzes')->onDelete('cascade');


            $table->foreignId('vendor_id')->constrained('vendors')->onDelete('cascade');
            $table->foreignId('question_id')->constrained('quezies_questions')->onDelete('cascade');
            $table->foreignId('answer_id')->nullable()->constrained('quezies_answers')->onDelete('cascade');
            $table->text('text_answer')->nullable();


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
        Schema::dropIfExists('vendor_answers');
    }
}

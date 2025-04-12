<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('book_id')->nullable();
            $table->foreign('book_id')
                ->references('id')
                ->on('books')->onDelete('cascade');

                $table->unsignedBigInteger('live_id')->nullable();
                $table->foreign('live_id')
                    ->references('id')
                    ->on('lives')->onDelete('cascade');

            $table->unsignedBigInteger('course_id')->nullable();
            $table->foreign('course_id')
                ->references('id')
                ->on('courses')->onDelete('cascade');

            $table->unsignedBigInteger('consultaion_id')->nullable();
            $table->foreign('consultaion_id')
                ->references('id')
                ->on('consultaion')->onDelete('cascade');

                $table->unsignedBigInteger('consultaion_type_id')->nullable();
                $table->foreign('consultaion_type_id')
                    ->references('id')
                    ->on('consultaion_type')->onDelete('cascade');

                $table->unsignedBigInteger('consultaion_schedual_id')->nullable();
                $table->foreign('consultaion_schedual_id')
                    ->references('id')
                    ->on('consultaion_schedual')->onDelete('cascade');

                $table->unsignedBigInteger('quiz_id')->nullable();
                $table->foreign('quiz_id')
                        ->references('id')
                        ->on('quizzes')->onDelete('cascade');


                $table->boolean('is_paid')->default(false);

            $table->foreignId('vendor_id')->constrained('vendors')->onDelete('cascade');

            $table->enum('type', ['book', 'course', 'consultation','live'])->nullable(); // New column for type
            $table->enum('type_of_book', ['hard_copy', 'E-book'])->nullable(); // New column for type
            $table->integer('quantity')->nullable();
            $table->decimal('total_price', 10, 2);
            $table->enum('payment_status', ['pending', 'paid', 'failed'])->default('pending');
            $table->enum('payment_method', ['visa', 'mastercard', 'mada'])->nullable();

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
        Schema::dropIfExists('orders');
    }
}

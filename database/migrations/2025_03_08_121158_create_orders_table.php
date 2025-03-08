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

            $table->unsignedBigInteger('course_id')->nullable();
            $table->foreign('course_id')
                ->references('id')
                ->on('courses')->onDelete('cascade');

            $table->unsignedBigInteger('consultaion_id')->nullable();
            $table->foreign('consultaion_id')
                ->references('id')
                ->on('consultaion')->onDelete('cascade');

            $table->foreignId('vendor_id')->constrained('vendors')->onDelete('cascade');

            $table->enum('status', ['pending', 'paid', 'cancelled'])->default('pending');

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

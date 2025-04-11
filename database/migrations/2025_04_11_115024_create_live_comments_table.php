<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLiveCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('live_comments', function (Blueprint $table) {

                 $table->id();
                $table->unsignedBigInteger('live_id')->nullable();
                $table->foreign('live_id')
                    ->references('id')
                    ->on('lives')->onDelete('cascade');

                $table->unsignedBigInteger('vendor_id')->nullable();
                $table->foreign('vendor_id')->references('id')->on('vendors')->onDelete('cascade');;

                $table->text('description_ar');
                $table->text('description_en');
                $table->unsignedTinyInteger('rate')->nullable(); // 1 to 5 rating

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
        Schema::dropIfExists('live_comments');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddZoomDetailsToConsultaionSchedual extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('consultaion_schedual', function (Blueprint $table) {
            $table->string('zoom_meeting_id', 255)->nullable();
            $table->string('zoom_join_url', 500)->nullable(); // Increase length for URLs
            $table->string('zoom_start_url', 500)->nullable(); // Increase length for URLs

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('consultaion_schedual', function (Blueprint $table) {
            $table->dropColumn(['zoom_meeting_id', 'zoom_join_url', 'zoom_start_url']);
        });
    }
}

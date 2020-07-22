<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Overview extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('overview', function (Blueprint $table) {
            //
            $table->integer('classes_id');
            $table->timestamp();
            $table->char('form_id',4);


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('overview', function (Blueprint $table) {
            //
        });
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPromoteColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('student_b_t_s', function($table){
            $table->unsignedInteger('bt_id')->nullable();
            $table->foreign('bt_id')->references('id')->on('student_b_t_s');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('student_b_t_s', function($table){
            $table->dropColumn('bt_id');
        });
    }
}

<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSlideIdToChoices extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('choices', function (Blueprint $table) {
            $table->integer('slide_id')->unsigned()->after('id');
            $table->foreign('slide_id')->references('id')->on('slides')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('choices', function (Blueprint $table) {
            $table->dropForeign('choices_slide_id_foreign');
            $table->dropColumn('slide_id');
        });
    }
}

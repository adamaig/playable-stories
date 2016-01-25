<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGroupStoryPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('group_story', function (Blueprint $table) {
            $table->integer('group_id')->unsigned();
            $table->integer('story_id')->unsigned();
        });

        Schema::table('group_story', function (Blueprint $table) {
            $table->foreign('group_id')->references('id')->on('groups');
            $table->foreign('story_id')->references('id')->on('stories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('group_story', function (Blueprint $table) {
            $table->dropForeign('group_story_group_id_foreign');
            $table->dropForeign('group_story_story_id_foreign');
        });

        Schema::drop('group_story');
    }
}

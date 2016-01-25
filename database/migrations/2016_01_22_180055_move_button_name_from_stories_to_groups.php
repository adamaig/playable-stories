<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MoveButtonNameFromStoriesToGroups extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('stories', function (Blueprint $table) {
            $table->dropColumn('group_button_name');
        });

        Schema::table('group_story', function (Blueprint $table) {
            $table->string('button_name')->after('story_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('stories', function (Blueprint $table) {
            $table->string('group_button_name')->after('name');
        });

        Schema::table('group_story', function (Blueprint $table) {
            $table->string('button_name')->after('story_id');
        });
    }
}

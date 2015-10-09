<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveHeadingAndTextAlignmentFromIntroductions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('introductions', function (Blueprint $table) {
            $table->dropColumn('heading');
            $table->dropColumn('text_alignment');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('introductions', function (Blueprint $table) {
            $table->string('heading')->nullable()->after('story_id');
            $table->string('text_alignment')->default('center')->after('message');
        });
    }
}

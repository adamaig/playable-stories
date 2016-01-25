<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMoreFieldsToGroups extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('groups', function (Blueprint $table) {
            $table->text('message')->nullable()->after('name');
            $table->string('text_alignment')->default('center')->after('message');
            $table->string('background_color')->default('#FFFFFF')->after('text_alignment');
            $table->string('photo')->nullable()->after('background_color');
            $table->string('photo_type')->default('background')->after('photo');
            $table->string('background_placement')->default('center top')->after('photo_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('groups', function (Blueprint $table) {
            $table->dropColumn('message');
            $table->dropColumn('text_alignment');
            $table->dropColumn('background_color');
            $table->dropColumn('photo');
            $table->dropColumn('photo_type');
            $table->dropColumn('background_placement');
        });
    }
}

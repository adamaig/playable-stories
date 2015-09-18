<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddHeadersAndContentToMeters extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('meters', function (Blueprint $table) {
            $table->string('min_value_header')->after('max_value')->nullable();
            $table->text('min_value_text')->after('min_value_header')->nullable();
            $table->string('max_value_header')->after('min_value_text')->nullable();
            $table->text('max_value_text')->after('max_value_header')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('meters', function (Blueprint $table) {
            $table->dropColumn('min_value_header');
            $table->dropColumn('min_value_text');
            $table->dropColumn('max_value_header');
            $table->dropColumn('max_value_text');
        });
    }
}

<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddOutcomeIdToOutcomeResults extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('outcome_results', function (Blueprint $table) {
            $table->integer('outcome_id')->unsigned()->after('id');
            $table->foreign('outcome_id')->references('id')->on('outcomes')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('outcome_results', function (Blueprint $table) {
            $table->dropForeign('outcomes_outcome_id_foreign');
            $table->dropColumn('outcome_id');
        });
    }
}

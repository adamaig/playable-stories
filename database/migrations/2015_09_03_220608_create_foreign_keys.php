<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Eloquent\Model;

class CreateForeignKeys extends Migration {

	public function up()
	{
		Schema::table('slides', function(Blueprint $table) {
			$table->foreign('story_id')->references('id')->on('stories')
						->onDelete('cascade')
						->onUpdate('cascade');
		});
		Schema::table('introductions', function(Blueprint $table) {
			$table->foreign('story_id')->references('id')->on('stories')
						->onDelete('cascade')
						->onUpdate('cascade');
		});
		Schema::table('outcomes', function(Blueprint $table) {
			$table->foreign('choice_id')->references('id')->on('choices')
						->onDelete('cascade')
						->onUpdate('cascade');
		});
		Schema::table('outcome_results', function(Blueprint $table) {
			$table->foreign('meter_id')->references('id')->on('meters')
						->onDelete('cascade')
						->onUpdate('cascade');
		});
	}

	public function down()
	{
		Schema::table('slides', function(Blueprint $table) {
			$table->dropForeign('slides_story_id_foreign');
		});
		Schema::table('introductions', function(Blueprint $table) {
			$table->dropForeign('introductions_story_id_foreign');
		});
		Schema::table('outcomes', function(Blueprint $table) {
			$table->dropForeign('outcomes_choice_id_foreign');
		});
		Schema::table('outcome_results', function(Blueprint $table) {
			$table->dropForeign('outcome_results_meter_id_foreign');
		});
	}
}
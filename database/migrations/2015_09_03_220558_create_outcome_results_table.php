<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOutcomeResultsTable extends Migration {

	public function up()
	{
		Schema::create('outcome_results', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('meter_id')->unsigned();
			$table->bigInteger('change')->default('0');
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('outcome_results');
	}
}
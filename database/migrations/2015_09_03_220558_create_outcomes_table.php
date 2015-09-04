<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOutcomesTable extends Migration {

	public function up()
	{
		Schema::create('outcomes', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('choice_id')->unsigned();
			$table->integer('likelihood')->unsigned()->default('0');
			$table->text('vignette')->nullable();
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('outcomes');
	}
}
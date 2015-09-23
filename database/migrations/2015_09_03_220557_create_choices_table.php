<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateChoicesTable extends Migration {

	public function up()
	{
		Schema::create('choices', function(Blueprint $table) {
			$table->increments('id');
			$table->tinyInteger('order')->unsigned();
			$table->string('text')->default('This is where choice text goes.');
			$table->string('meter_effect')->default('chance');
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('choices');
	}
}
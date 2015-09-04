<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMetersTable extends Migration {

	public function up()
	{
		Schema::create('meters', function(Blueprint $table) {
			$table->increments('id');
			$table->tinyInteger('order')->unsigned();
			$table->string('name')->default('Meter Name');
			$table->string('type')->default('number');
			$table->bigInteger('start_value')->default('1000');
			$table->bigInteger('min_value')->nullable()->default('0');
			$table->bigInteger('max_value')->nullable();
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('meters');
	}
}
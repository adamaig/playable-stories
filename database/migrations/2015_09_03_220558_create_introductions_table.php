<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateIntroductionsTable extends Migration {

	public function up()
	{
		Schema::create('introductions', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('story_id')->unsigned();
			$table->string('heading')->nullable();
			$table->text('message')->nullable();
			$table->string('text_alignment')->default('center');
			$table->string('background_color')->default('#FFFFFF');
			$table->string('photo')->nullable();
			$table->string('photo_type')->default('background');
			$table->string('background_placement')->default('center top');
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('introductions');
	}
}
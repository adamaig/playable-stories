<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSlidesTable extends Migration {

	public function up()
	{
		Schema::create('slides', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('story_id')->unsigned();
			$table->smallInteger('order')->unsigned();
			$table->string('name')->default('Slide Name');
			$table->string('image')->nullable();
			$table->text('content')->nullable();
			$table->string('text_placement')->default('overlay');
			$table->string('text_alignment')->default('center');
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('slides');
	}
}
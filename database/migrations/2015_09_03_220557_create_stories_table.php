<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateStoriesTable extends Migration {

	public function up()
	{
		Schema::create('stories', function(Blueprint $table) {
			$table->increments('id');
			$table->string('name')->default('Story Name');
			$table->string('success_heading')->default('Your story has come to an end!');
			$table->text('success_content');
			$table->string('background_color')->default('#FFFFFF');
			$table->string('background_image')->nullable();
			$table->string('header_font')->default('Oswald');
			$table->tinyInteger('heading_font_size')->unsigned()->default('28');
			$table->string('heading_font_color')->default('#333333');
			$table->string('body_font')->default('Open Sans');
			$table->tinyInteger('body_font_size')->unsigned()->default('14');
			$table->string('body_font_color')->default('#999999');
			$table->string('link_color')->default('#6699dd');
			$table->string('button_background_color')->default('#6699dd');
			$table->string('button_text_color')->default('#6699dd');
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('stories');
	}
}
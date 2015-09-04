<?php

namespace PlayableStories;

use Illuminate\Database\Eloquent\Model;

class Slide extends Model {

	protected $table = 'slides';
	public $timestamps = true;

	public function story()
	{
		return $this->belongsTo('PlayableStories\Story');
	}

	public function choices()
	{
		return $this->hasMany('PlayableStories\Choice');
	}

}
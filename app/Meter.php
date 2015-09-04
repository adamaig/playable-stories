<?php

namespace PlayableStories;

use Illuminate\Database\Eloquent\Model;

class Meter extends Model {

	protected $table = 'meters';
	public $timestamps = true;

	public function story()
	{
		return $this->belongsTo('PlayableStories\Story');
	}

}
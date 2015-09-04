<?php

namespace PlayableStories;

use Illuminate\Database\Eloquent\Model;

class Outcome extends Model {

	protected $table = 'outcomes';
	public $timestamps = true;

	public function choice()
	{
		return $this->belongsTo('PlayableStories\Choice');
	}

	public function results()
	{
		return $this->hasMany('PlayableStories\OutcomeResults');
	}

}
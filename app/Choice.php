<?php

namespace PlayableStories;

use Illuminate\Database\Eloquent\Model;

class Choice extends Model {

	protected $table = 'choices';
	public $timestamps = true;

	public function slide()
	{
		return $this->belongsTo('PlayableStories\Slide');
	}

	public function outcomes()
	{
		return $this->hasMany('PlayableStories\Outcome');
	}

}
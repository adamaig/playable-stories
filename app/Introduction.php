<?php

namespace PlayableStories;

use Illuminate\Database\Eloquent\Model;

class Introduction extends Model {

	protected $table = 'introductions';
	public $timestamps = true;

	public function story()
	{
		return $this->belongsTo('PlayableStories\Story');
	}

}
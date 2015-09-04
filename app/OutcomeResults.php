<?php

namespace PlayableStories;

use Illuminate\Database\Eloquent\Model;

class OutcomeResults extends Model {

	protected $table = 'outcome_results';
	public $timestamps = true;

	public function outcome()
	{
		return $this->belongsTo('PlayableStories\Outcome');
	}

}
<?php

namespace PlayableStories;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $table = 'groups';
    public $timestamps = true;

    public function user()
    {
        return $this->belongsTo('PlayableStories\User');
    }

    public function stories()
    {
        return $this->hasMany('PlayableStories\Story');
    }
}

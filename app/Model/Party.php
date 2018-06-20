<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Party
 * @package App\Model
 */
class Party extends Model
{
    public $name;
    public $description;
    public $date;
    public $tags;
    public $capacity;
    public $length;
    public $image;
    public $user_id;

    /**
     *  Party - Song (many to many relationship)
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function songs()
    {
        return $this->belongsToMany('App\Model\Song', 'party_song', 'party_id', 'song_id')->withTimestamps();
    }

    /**
     * Party - User (many to many relationship)
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany('App\Model\User', 'party_user', 'party_id', 'user_id');
    }
}

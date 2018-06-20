<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Song
 * @package App
 */
class Song extends Model
{
    public $artist;
    public $track;
    public $link;
    public $length;

    /**
     * Song - Party (many to many relationship)
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function parties()
    {
        return $this->belongsToMany('App\Model\Party', 'party_song', 'song_id', 'party_id')->withTimestamps();
    }

    public function users()
    {
        return $this->belongsToMany('App\Model\User', 'song_user', 'song_id', 'user_id')->withTimestamps();
    }
}

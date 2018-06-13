<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Song
 * @package App
 */
class Song extends Model
{
    public $timestamps = [];

    public function parties(){
        return $this->belongsToMany('App\Model\Party', 'party_song', 'song_id', 'party_id');
    }
}

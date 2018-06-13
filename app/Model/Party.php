<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Party
 * @package App\Model
 */
class Party extends Model
{
    public function songs(){
        return $this->belongsToMany('App\Model\Song', 'party_song', 'party_id', 'song_id');
    }
}

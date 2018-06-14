<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Party
 * @package App\Model
 */
class Party extends Model
{
    /**
     *  Party - Song (many to many relationship)
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function songs(){
        return $this->belongsToMany('App\Model\Song', 'party_song', 'party_id', 'song_id');
    }
}

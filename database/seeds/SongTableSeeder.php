<?php

use Illuminate\Database\Seeder;
use App\Model\Song;

/**
 * Class SongTableSeeder
 */
class SongTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $song = new Song();
        $song->artist = 'Moby';
        $song->track = 'Natural Blues';
        $song->link = 'natural_blues';
        $song->length = 3.5;
        $song->save();

        $song = new Song();
        $song->artist = 'Lera Lynn';
        $song->track = 'Lately';
        $song->link = 'lately';
        $song->length = 4;
        $song->save();

        $song = new Song();
        $song->artist = 'Bon Jovi';
        $song->track = 'Runnaway';
        $song->link = 'runnaway';
        $song->length = 4.5;
        $song->save();
    }
}

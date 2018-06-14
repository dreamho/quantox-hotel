<?php

use Illuminate\Database\Seeder;

/**
 * Class PartyTableSeeder
 */
class PartyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $party = new \App\Model\Party();
        $party->name = 'Opening night';
        $party->description = 'You are welcome to participate to the opening of the Quantox Hotel';
        $party->date = '2018-6-16';
        $party->tags = 'party,hotel,fun';
        $party->capacity = 200;
        $party->length = 2.5;
        $party->image = '2.jpg';
        $party->user_id = 2;
        $party->save();
        $party->songs()->attach(1);
        $party->songs()->attach(2);
        $party->songs()->attach(3);
    }
}

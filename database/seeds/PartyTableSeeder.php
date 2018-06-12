<?php

use Illuminate\Database\Seeder;

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
        $party->tags = '#party, #hotel';
        $party->capacity = 200;
        $party->length = 2.5;
        $party->image = '1.jpg';
        $party->user_id = 2;
        $party->save();
    }
}

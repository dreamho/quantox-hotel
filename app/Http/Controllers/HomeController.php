<?php

namespace App\Http\Controllers;

use App\Model\Song;

/**
 * Class HomeController
 * @package App\Http\Controllers
 */
class HomeController extends Controller
{
    /**
     * Displaying Home Page
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(){
        return view('home.index');
    }

    /**
     * Displaying Form for saving a Party
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showPartyForm(){
        return view('party.index');
    }
    public function test(){

        $songs = Song::inRandomOrder()->get();

        $total = 1.5 * 60;
        $duration = 0;

        $array = [];
        foreach($songs as $song){

            if($duration <= $total){
                $duration += $song->length;
                if($duration > $total){
                    break;
                }
                $array[] = $song;
            }
        }
        if()



        return view('home.test', ['songs' => $array, 'duration' => $duration]);
    }
}

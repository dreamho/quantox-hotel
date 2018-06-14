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

        $total = 0.5 * 60;
        $duration = 0;

        $array = [];

        for($i = 0; $i < count($songs); $i++){
            if($duration <= $total){
                $duration += $songs[$i]->length;
                if($duration > $total){
                    break;
                }
                $array[] = $songs[$i];
            }
        }
//        foreach($songs as $song){
//
//            if($duration <= $total){
//                $duration += $song->length;
//                if($duration > $total){
//                    break;
//                }
//                $array[] = $song;
//            }
//        }




        return view('home.test', ['songs' => $array, 'duration' => $duration]);
    }
}

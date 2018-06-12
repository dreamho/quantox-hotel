<?php

namespace App\Http\Controllers;

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
}

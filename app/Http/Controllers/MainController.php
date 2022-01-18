<?php

namespace App\Http\Controllers;

use App\Models\MusicSheet;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public function index(Request $request)
    {

//        $mostpopular = MusicSheet::has('likes')->take(5)->get();
        $mostpopular = MusicSheet::has('likes')->withCount('likes')->take(5)->orderByDesc('likes_count')->get();
//        dd($mostpopular);

        return view('home.home', ['mostpopular' => $mostpopular]);
    }
}

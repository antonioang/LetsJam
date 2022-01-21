<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use App\Models\MusicSheet;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public function index(Request $request)
    {

//        $mostpopular = MusicSheet::has('likes')->take(5)->get();
        $mostpopular = MusicSheet::has('likes')->withCount('likes')->take(5)->orderByDesc('likes_count')->get();
        $genres = Genre::all();
        $sheetsForGenres = [];
        foreach ($genres as $genre) {
            $forGenres = MusicSheet::whereHas('genres',function($query) use($genre) {
                $query->where('id', $genre->id);
            })->withCount('likes')->take(5)->get();

            $sheetsForGenres[$genre->name] = $forGenres;

        }
//        dd($sheetsForGenres);

        return view('home.home', [
            'mostpopular' => $mostpopular,
            'sheetsForGenres' => $sheetsForGenres,
        ]);
    }
}

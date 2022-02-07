<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use App\Models\Instrument;
use App\Models\MusicSheet;
use App\Models\User;
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

        return view('home.home', [
            'mostpopular' => $mostpopular,
            'sheetsForGenres' => $sheetsForGenres,
        ]);
    }

    public function manageUsers() {
        $users = User::all();
        return view('admin.manageUsers', ['users' => $users]);
    }

    public function promoteUsers() {
        $users = User::all();
        return view('admin.manageUsers', ['users' => $users]);
    }

    public function deleteUsers() {
        $users = User::all();
        return view('admin.manageUsers', ['users' => $users]);
    }

    public function indexSheets() {
        return view('admin.adminVerifySheets', [
            'checkedGenres' => [],
            'checkedInstruments' => [],
            'genres' => Genre::all(),
            'instruments' => Instrument::all(),
            'sortDirection' => 'ASC',
            'sortOrderr' => '',
            'musicSheets' => MusicSheet::withCount('likes')->paginate(5)
        ]);
    }

    public function aboutUs() {
        return view('aboutus.aboutus');
    }
}

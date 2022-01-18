<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use App\Models\Instrument;
use App\Models\MusicSheet;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index(Request $request) {
        return view('profile.profile',[]);
    }

    public function Modify(Request $request) {
        return view('profile.modifyProfile',[
            'genres'=>Genre::all(),
            'instruments'=>Instrument::all(),
        ]);
    }

    public function ModifyProfile(Request $request) {
        dd($request->input('firstname'));
        return view('profile.modify',[]);
    }
}

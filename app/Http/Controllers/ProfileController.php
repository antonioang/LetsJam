<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use App\Models\Instrument;
use App\Models\MusicSheet;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Console\Input\Input;

class ProfileController extends Controller
{
    public function index(Request $request)
    {
        return view('profile.profile', ['sheets' => MusicSheet::where('user_id', Auth::user()->id)->withCount('likes')->get()]);
    }

    public function Modify(Request $request)
    {
        return view('profile.modifyProfile', [
            'genres' => Genre::all(),
            'instruments' => Instrument::all(),
        ]);
    }

    public function ModifyProfile(Request $request)
    {
        $instruments = Instrument::all();
        $genres = Genre::all();
        $user = Auth::user();
        $userId = $user->id;
        $loggedUser = User::find($userId);
        $inputs = $request->all();
        $ext = $request->file('imgInput')->getClientOriginalExtension();
        $file =  $request->file('imgInput');
        $userAvatarPath = "storage/uploads/".$userId.'.'.$ext;

//        dd($request->file('imgInput')->getClientOriginalExtension());
        if ($file) {
            if (Storage::exists($userAvatarPath)) {
                Storage::delete($userAvatarPath);
            }
            Storage::put('public/uploads/'.$userId.'.'.$ext, $file->getContent());
            $loggedUser->avatar = $userAvatarPath;
        }

        foreach ($instruments as $instrument) {
            if (array_key_exists('preferredInstruments',$inputs)) {
                if (!in_array($instrument->id, $inputs['preferredInstruments'])) {
                    $loggedUser->instruments()->detach($instrument->id);
                } else if (!$loggedUser->instruments->contains($instrument->id)) {
                    $loggedUser->instruments()->attach($instrument->id);
                }
            } else {
                $loggedUser->instruments()->detach($instrument->id);
            }
        }

        foreach ($genres as $genre) {
            if (array_key_exists('preferredGenres',$inputs)) {
                if (!in_array($genre->id, $inputs['preferredGenres'])) {
                    $loggedUser->genre()->detach($genre->id);
                } else if (!$loggedUser->genre->contains($genre->id)) {
                    $loggedUser->genre()->attach($genre->id);
                }
            } else {
                $loggedUser->genre()->detach($genre->id);
            }
        }



        $loggedUser->firstname = $inputs['firstname'];
        $loggedUser->lastname = $inputs['lastname'];
        $loggedUser->username = $inputs['username'];
        $loggedUser->email = $inputs['email'];

        $loggedUser->save();

        Auth::setUser($loggedUser->fresh());

        return view('profile.profile', ['sheets' => MusicSheet::where('user_id', Auth::user()->id)->withCount('likes')->get()]);
    }
}

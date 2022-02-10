<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use App\Models\Instrument;
use App\Models\MusicSheet;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public function index(Request $request)
    {
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
        $users = User::paginate(8);
        return view('admin.manageUsers', ['users' => $users]);
    }

    public function promoteUsers(Request $request) {
        $users = User::all();
        $ids = $request->input('userIds');

        foreach($ids as $id) {
            $user = User::find($id);
            $user->role = 'admin';
            $user->save();
        }
        return view('admin.manageUsers', ['users' => $users->fresh()]);
    }

    public function deleteUsers(Request $request) {
        $users = User::all();
        $ids = $request->input('userIds');

        foreach($ids as $id) {
            User::find($id)->delete();
        }
        return view('admin.manageUsers', ['users' => $users->fresh()]);
    }

    public function indexSheets(Request $request) {
        $checkedGenres = $request->input('genre') ? $request->input('genre') : [];
        $textSearch = $request->input('textSearch') ? $request->input('textSearch') : '';
        $rearranged = $request->input('rearranged') ? intval($request->input('rearranged')) : '0';
        $verified = $request->input('verified') ? intval($request->input('verified')) : '0';
        $checkedInstruments = $request->input('instrument') ? $request->input('instrument') : [];
        $sortOrder = $request->input('order') ? $request->input('order') : '';
        $sortDirection = $request->input('sortDirection') ? $request->input('sortDirection') : '';


        $musicsheets = MusicSheet::whereHas('genres', function (Builder $query) use ($checkedGenres) {
            $query->whereIn('id', $checkedGenres);
        })->orWhereHas('instruments', function (Builder $query) use ($checkedInstruments) {
            $query->whereIn('id', $checkedInstruments);
        })->orWhere('title','like', "%$textSearch%")
            ->when($sortOrder, function (Builder $query) use ($sortOrder, $sortDirection) {
                $query->orderBy($sortOrder, $sortDirection);
            })->when($verified, function (Builder $query) use ($verified) {
                $query->where('verified', $verified);
            })->when($rearranged, function (Builder $query) use ($rearranged) {
                $query->where('rearranged', $rearranged);
            })->withCount('likes')
            ->paginate(5);

        return view('admin.adminVerifySheets', [
            'checkedGenres' => [],
            'checkedInstruments' => [],
            'genres' => Genre::all(),
            'instruments' => Instrument::all(),
            'sortDirection' => 'ASC',
            'sortOrderr' => '',
            'musicSheets' => $musicsheets
        ]);
    }

    public function verifySheets(Request $request) {
        $id = $request->input('musicSheetId');
        $toManage = MusicSheet::find($id);
        $toManage->verified = 1;
        $toManage->save();
        return response('ok',200);
    }

    public function filterSheets() {
        return view('aboutus.aboutus');
    }

    public function aboutUs() {
        return view('aboutus.aboutus');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use App\Models\Instrument;
use App\Models\MusicSheet;
use App\Models\Song;
use Genius\Genius;
use Http\Message\Authentication\Bearer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use SpotifyWebAPI\Session;
use SpotifyWebAPI\SpotifyWebAPI;

class SongController extends Controller
{

    public function index()
    {
        return view('songs.all', [
            'checkedGenres' => [],
            'genres' => Genre::all(),
            'instruments' => Instrument::all(),
            'songs' => Song::paginate(5),
            'sortDirection' => 'ASC',
            'sortOrderr' => '',
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     */
    public function show(int $id)
    {
        $song = Song::find($id);
        $sheets = MusicSheet::where('song_id', $id)->withCount('likes')->get();

        return view('songs.song', [
            'song' => $song,
            'readable' => $song->lyrics,
            'musicsheets' => $sheets,
        ]);
    }

    public function filter(Request $request)
    {
        $checkedGenres = $request->input('genre') ? $request->input('genre') : [];
        $textSearch = $request->input('textSearch') ? $request->input('textSearch') : '';
        $sortOrder = $request->input('order') ? $request->input('order') : '';
        $sortDirection = $request->input('sortDirection') ? $request->input('sortDirection') : '';
        $filters = $request->input('filter') ? $request->input('filter') : '';
        $albumType = $request->input('album_type') ? $request->input('album_type') : '';

        $songs = Song::whereIn('genre_id', $checkedGenres)
            ->orWhere('title','like', "%$textSearch%")
            ->when($sortOrder, function ($query) use ($sortOrder, $sortDirection) {
                $query->orderBy($sortOrder, $sortDirection);
            })->when($filters, function ($query) use ($sortOrder, $sortDirection) {
                $query->whereIn('',);
            })->paginate(5);


        return view('songs.all', [
            'checkedGenres' => $checkedGenres,
            'genres' => Genre::all(),
            'sortDirection' => $sortDirection,
            'instruments' => Instrument::all(),
            'sortOrderr' => $sortOrder,
            'songs' => $songs,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

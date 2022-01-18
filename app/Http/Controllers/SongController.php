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
            'genres' => Genre::all(),
            'instruments' => Instrument::all(),
            'songs' => Song::paginate(5)
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

    private function getReadableLyrics(string $rawLyrics)
    {
//        $rawLyrics
        //Remove start
        $rawLyrics = preg_replace("#[\\S\\s]*<div class=\\\\\\\\\\\\\"rg_embed_body\\\\\\\\\\\\\">[ (\\\\n)]*#", "", $rawLyrics);
        //Remove end
        $rawLyrics = preg_replace("#[ (\\\\n)]*<\\\\/div>[\\S\\s]*#", "", $rawLyrics);
        //Remove tags between
        $rawLyrics = preg_replace("#<[^<>]*>#", "", $rawLyrics);
        //Unescape spaces
        $rawLyrics = preg_replace("#\\\\\\\\n#", "\n", $rawLyrics);
        //Unescape '
        $rawLyrics = preg_replace("#\\\\'#", "'", $rawLyrics);
        //Unescape "
        $rawLyrics = preg_replace("#\\\\\\\\\\\\\"#", "\"", $rawLyrics);;
        return $rawLyrics;
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     */
    public function show(int $id)
    {
        $GENIUS_EMBED_URL_HEAD = "https://genius.com/songs/";
        $GENIUS_EMBED_URL_TAIL = "/embed.js";

        $authentication = new Bearer('ElbFZLf0xUtpyJ0ZQG9mITS9QcCdH3XzXeVpu3i2BZSQsNep18zxK7HljhtDuS1E');
        $genius = new Genius($authentication);
        $result = $genius->getSearchResource()->get('albachiara');
//        $resultSong= $genius->getSongsResource()->get($result->hits[0]->result->id, 'html');
//        $embed = $resultSong->song->embed_content;

        $rawLyrics = Http::get($GENIUS_EMBED_URL_HEAD . $result->hits[0]->result->id . $GENIUS_EMBED_URL_TAIL);
        $radable = $this->getReadableLyrics($rawLyrics);
//        dd($resultSong);

//        $session = new Session(
//            '9f22edd2825c42cfb4cdf87dcc0022b0',
//            'cf2f60097c5d4072a3fca62d9c2991af',
//        );
//
//        $session->requestCredentialsToken();
//        $accessToken = $session->getAccessToken();
//
//        $api = new SpotifyWebAPI();
//        $api->setAccessToken($accessToken);
//        dd($api->getTrack('7EjyzZcbLxW7PaaLua9Ksb'));


        return view('songs.song', [
            'song' => Song::where('id', $id)->first(),
            'readable' => $radable,
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

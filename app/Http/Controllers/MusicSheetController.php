<?php

namespace App\Http\Controllers;

use App\Models\Instrument;
use App\Models\Song;
use Illuminate\Http\Request;
use App\Models\Genre;
use App\Models\MusicSheet;
use Illuminate\Support\Facades\Auth;
use mysql_xdevapi\Exception;
use PhpParser\Node\Expr\Cast\Object_;
use SpotifyWebAPI\Session;
use SpotifyWebAPI\SpotifyWebAPI;

class MusicSheetController extends Controller
{
    //get all
    public function index()
    {
        return view('musicsheets.all', [
            'checkedGenres' => [],
            'checkedInstruments' => [],
            'genres' => Genre::all(),
            'instruments' => Instrument::all(),
            'sortDirection' => 'ASC',
            'sortOrderr' => '',
            'musicSheets' => MusicSheet::withCount('likes')->paginate(5)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     */
    //createUpload
    public function create()
    {
        return view('musicsheets.createUpload', [
            'genre' => Genre::all(),
            'instruments' => Instrument::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $jsonBrano = $request->input('brano');
        $brano = json_decode($jsonBrano);
        $musicSheet = new MusicSheet;
        $musicSheet->title = 'Me';
        $musicSheet->author = 'me@yahoo.com';
        $musicSheet->verified = 1;
        $musicSheet->visibility = 1;
        $musicSheet->rearranged = 1;
        $musicSheet->music_sheet_data = $request->input('content');
        $musicSheet->song_id = 1;
        $musicSheet->has_tablature = 0;
        $musicSheet->user_id = auth()->user()->id;
        // add more fields (all fields that users table contains without id)
        $musicSheet->save();
        dd(
            $request->input('title'),
            $request->input('author'),
            $request->input('songType'),
            $request->input('songTitle'),
            $request->input('songAuthor'),
            $request->input('song'),
            $request->input('songGenre'),
            $request->input('brano'),
            $request->input('content'),
            $request->input('songType'),
            $request->input('visibility'),
            $request->input('musicSheetVisibility'),
        );
    }

    public function analyzeScore(Request $request)
    {
        $score = json_decode($request->input('score'), true);
        try {
            $title = $score['score-partwise']['work']['work-title'];
        } catch (\ErrorException $e) {
            $title = '';
        }
        try {
            $author = $score['score-partwise']['identification']['creator']['content'];
        } catch (\ErrorException $e) {
            $author = '';
        }

        return response()->json([
            'title' => $title,
            'author' => $author
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     */
    //show one musicsheet
    public function show(int $id)
    {
//        dd(MusicSheet::where('id', $id)->first());
        return view('musicsheets.musicSheet', [
            'musicSheet' => MusicSheet::where('id', $id)->first()
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

    public function filter(Request $request)
    {
        $checkedGenres = $request->input('genre') ? $request->input('genre') : [];
        $checkedInstruments = $request->input('instrument') ? $request->input('instrument') : [];
        $sortOrder = $request->input('order') ? $request->input('order') : '';
        $sortDirection = $request->input('sortDirection') ? $request->input('sortDirection') : '';

        $musicsheets = MusicSheet::whereHas('genres', function ($query) use ($checkedGenres) {
            $query->whereIn('id', $checkedGenres);
        })->orWhereHas('instruments', function ($query) use ($checkedInstruments) {
            $query->whereIn('id', $checkedInstruments);
        })->when($sortOrder, function ($query) use ($sortOrder, $sortDirection) {
            $query->orderBy($sortOrder, $sortDirection);
        })->withCount('likes')->paginate(5);


        return view('musicsheets.all', [
            'checkedGenres' => $checkedGenres,
            'genres' => Genre::all(),
            'sortDirection' => $sortDirection,
            'checkedInstruments' => $checkedInstruments,
            'instruments' => Instrument::all(),
            'sortOrderr' => $sortOrder,
            'musicSheets' => $musicsheets,
        ]);
    }

    public function searchSong(Request $request)
    {
        $songToSearch = $request->query()['songSearchString'];
        $toRemove = [];
        $result = [];

        $dbSongs = Song::where('title', 'LIKE', '%' . $songToSearch . '%')
            ->orWhere('author', 'LIKE', '%' . $songToSearch . '%')->get();
        $spotifySongs = $this->searchSpotifySongs($songToSearch);

        if (!$dbSongs->isEmpty()) {
            foreach ($dbSongs as $song) {
                foreach ($spotifySongs as $spotySong) {
//                    dd($spotySong);
                    if ($song->spotify_id == $spotySong->id) {
                        $toRemove[] = array_search($spotySong, $spotifySongs);
                    }
                }
            }
            foreach ($dbSongs as $song) {
                $result[] = [
                    'title' => $song->title,
                    'author' => $song->author,
                    'spotifyId' => $song->spotify_id,
                    'id' => $song->id,
                ];
            }
        }
        //prendi song to remove e rimuovi da spotisongs
        if (!empty($toRemove) && !empty($spotifySongs)) {
            foreach ($toRemove as $spoty) {
                unset($spotifySongs[$spoty]);
            }
        }
//
        if (!empty($spotifySongs)) {
            foreach ($spotifySongs as $spoty) {
                $autore = '';
                foreach ($spoty->artists as $author) {
                    $autore .= $author->name . ' ';
                }
                $branoSpoty = [
                    'title' => $spoty->name,
                    'author' => $autore,
                    'spotifyId' => $spoty->id,
                    'id' => null,
                ];
                $result[] = $branoSpoty;
            }
        }

        return response()->json($result);
    }

    private function searchSpotifySongs($param)
    {
        $session = new Session(
            env('SPOTY_CLIENT_ID'),
            env('SPOTY_CLIENT_SECRET'),
        );

        $session->requestCredentialsToken();
        $accessToken = $session->getAccessToken();

        $api = new SpotifyWebAPI();
        $api->setAccessToken($accessToken);
        $result = $api->search($param, 'track', ['limit' => 5]);
        if ($result) {
            return $result->tracks->items;
        } else {
            return null;
        }
    }

    public function getEmptyScore(Request $request)
    {
        $instruments = json_decode($request->input('instruments'));
//        $instruments = ['Trumpet'];
        if ($instruments !== null) {
            $result = [];
            $scoreParts = [];
            $parts = [];

            for ($i = 0; $i < count($instruments); $i++) {
                $scorePart = ["\$id" => "P" . ($i + 1),
                    "part-name" => $instruments[$i]];
                $scoreParts = [$scorePart];

                $key = ['fifths' => '0'];
                $attributes = ['divisions' => '1', 'key' => $key];

                $time = ['beats' => "4", 'beat-type' => "4"];

                $clef = ['sign' => "G", 'line' => "2"];

                $pitch = ['step' => "C", 'octave' => "4"];
                $note[] = [
                    'pitch' => $pitch,
                    'duration' => "4",
                    'type' => "whole"
                ];

                $measure[] = [
                    'number' => '1',
                    'attributes' => $attributes,
                    'time' => $time,
                    'clef' => $clef,
                    'note' => $note
                ];

                $part = [
                    "\$id" => "P" . ($i + 1),
                    'measure' => $measure
                ];

                $parts = [
//                ...$parts,
                    $part
                ];

//                $parts[] = $part;
            }
            $partList = ['score-part' => $scoreParts];
            $scorePartwise = [
                'part-list' => $partList,
                'part' => $parts,
                "version" => '4.0'
            ];
            $result[] = [
                'score-partwise' => $scorePartwise
            ];
        }

        return response()->json($result);
//        return json_encode($result);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Instrument;
use App\Models\Song;
use App\Services\Utility\Utils;
use Illuminate\Http\Request;
use App\Models\Genre;
use App\Models\MusicSheet;
use PhpParser\Node\Expr\Cast\Object_;

class MusicSheetController extends Controller
{
    public function __construct(Utils $utils)
    {
        $this->utils = $utils;
    }

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

    //createUpload
    public function create()
    {
        return view('musicsheets.createUpload', [
            'genre' => Genre::all(),
            'instruments' => Instrument::all(),
            'songType' => 0,
        ]);
    }

    public function store(Request $request)
    {

        $jsonBrano = $request->input('content');
        $brano = $request->input('brano');
        $SongType = $request->input('songType');
        $title = $request->input('title');
        $author = $request->input('author');
        $genre = $request->input('songGenre');

        $musicSheet = new MusicSheet;
        $musicSheet->title = $title;
        $musicSheet->author = $author;
        $musicSheet->verified = 1;
        $musicSheet->visibility = 1;
        $musicSheet->rearranged = 1;
        $musicSheet->music_sheet_data = $jsonBrano;
        $musicSheet->has_tablature = $this->hasTab($jsonBrano);
        $musicSheet->user_id = auth()->user()->id;
        // add more fields (all fields that users table contains without id)
        $temp = $this->extractInstruments($jsonBrano);
//        dd($temp[0]);
        $instruments = $temp[0];

        $song = new Song;
        if (!$SongType) {
            $brano = json_decode($brano, true);

            $songId = $brano['songId'];
            $spotyId = $brano['spotifyId'];

            if ($songId != 'null') {
                $song = Song::find($songId);
            } else {
                $song = $this->utils->searchSpotifySongsById($spotyId);
            }
        } else {
            $song->title = $title;
            $song->author = $author;
            $song->album_name = 'non definito';
            $song->album_type = 'non definito';
            $song->image_url = '';
            $song->is_explicit = 0;
            $song->duration = 0;
            $song->lyrics = 'non definita';
            $song->spotify_id = 0;
        }

        $song->genre_id = $genre;
        $song->save();

//        dd($song->fresh()->id);
        $musicSheet->song_id = $song->fresh()->id;

        $musicSheet->save();
        $musicSheet->instruments()->saveMany($instruments);

        $mapping = [];

        foreach ($instruments as $key => $ins) {
            $mapping[$ins->name] = $temp[1][$key];
        }

        $musicSheet = $musicSheet->fresh();

        $musicsheetdata = (object)[
            'id' => $musicSheet->id,
            'content' => $musicSheet->music_sheet_data,
            'instrumentMapping' => $mapping
        ];

        return view('musicsheets.musicSheet', [
            'musicSheet' => $musicSheet->fresh(),
            'musicsheetdata' => $musicsheetdata,
        ]);
    }

    //show one musicsheet
    public function show(int $id)
    {
        $available_instruments= ["Piano", "Organ", "Violin", "Cello", "Contrabass", "BassAcoustic", "BassElectric",
            "Guitar", "Banjo", "Sax", "Trumpet", "Horn", "Trombone", "Tuba", "Flute", "Oboe", "Clarinet", "Drum"];

        $sheet = MusicSheet::where('id', $id)->withCount('likes')->first();

        $instrumentMapping = $this->extractInstruments($sheet->music_sheet_data);
        $mapping = [];

        foreach ($instrumentMapping[0] as $key => $ins) {
            $mapping[$ins->name] = $instrumentMapping[1][$key];
        }

        $musicsheetdata = (object)[
            'id' => $sheet->id,
            'content' => $sheet->music_sheet_data,
            'instrumentMapping' => $mapping
        ];

        return view('musicsheets.musicSheet', [
            'musicSheet' => $sheet,
            'musicsheetdata' => $musicsheetdata,
        ]);
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }

    public function extractInstrumentPart(Request $request) {
        $msicSheetId = $request->input('musicSheetId');
        $json = MusicSheet::find($msicSheetId);
        $partListIdJson = $request->input('partList');
        $partListId = json_decode($partListIdJson);

        $score = json_decode($json->music_sheet_data, true);
        $parts = $score['score-partwise']['part'];
        $partToExtract = [];

        foreach ($parts as $part) {
            $currentId = $part["\$id"];
            if (in_array($currentId, $partListId)) {
                $partToExtract[] = $part;
            }
        }
        unset($score['score-partwise']['part']);
        $score['score-partwise']['part'] = $partToExtract;

        $partList = $score['score-partwise']['part-list']['score-part'];
        $scorePartToExtract = [];

        foreach($partList as $part) {
            $currentId = $part["\$id"];
            if (in_array($currentId, $partListId)) {
                $scorePartToExtract[] = $part;
            }
        }
        unset($score['score-partwise']['part-list']['score-part']);
        $score['score-partwise']['part-list']['score-part'] = $scorePartToExtract;

        return response()->json($score);
    }

    private function hasTab($score)
    {
        return strpos('fret', $score);
    }

    private function extractInstruments($score): array
    {
        $parts = json_decode($score, true);
        $parts = $parts['score-partwise']['part-list']['score-part'];
        $instruments = [];
        $partIds = [];

        foreach ($parts as $item) {
            $instruments[] = Instrument::where('name', $item['part-name'])->first();
            $fullId = $item["\$id"];
            $partIds[] =  $fullId;
        }

        return [$instruments,$partIds];
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
        $spotifySongs = $this->utils->searchSpotifySongs($songToSearch);

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

    public function getEmptyScore(Request $request)
    {
        $instruments = json_decode($request->input('instruments'));
        if ($instruments !== null) {
            $result = [];
            $scoreParts = [];
            $parts = [];

            for ($i = 0; $i < count($instruments); $i++) {
                $scorePart = ["\$id" => "P" . ($i + 1),
                    "part-name" => $instruments[$i]];
                $scoreParts[] = $scorePart;

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

                $parts[] = $part;
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
    }
}

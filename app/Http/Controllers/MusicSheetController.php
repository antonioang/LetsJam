<?php

namespace App\Http\Controllers;

use App\Models\Instrument;
use Illuminate\Http\Request;
use App\Models\Genre;
use App\Models\MusicSheet;

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
        //
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

    public function searchSong(Request $request) {
        echo $request;
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

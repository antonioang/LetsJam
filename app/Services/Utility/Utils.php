<?php

namespace App\Services\Utility;

use App\Models\Song;
use Genius\Genius;
use Http\Message\Authentication\Bearer;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use SpotifyWebAPI\Session;
use SpotifyWebAPI\SpotifyWebAPI;

class Utils
{
    public function __construct()
    {
        $this->session = new Session(
            env('SPOTY_CLIENT_ID'),
            env('SPOTY_CLIENT_SECRET'),
        );

        $this->session->requestCredentialsToken();
        $accessToken = $this->session->getAccessToken();

        $this->api = new SpotifyWebAPI();
        $this->api->setAccessToken($accessToken);

        $this->GENIUS_EMBED_URL_HEAD = "https://genius.com/songs/";
        $this->GENIUS_EMBED_URL_TAIL = "/embed.js";
        $GENIUS_ACCESS = env('GENIUS_ACCESS_TOKEN');

        $authentication = new Bearer($GENIUS_ACCESS);
        $this->genius = new Genius($authentication);

    }

    public function searchSpotifySongs($param)
    {

        $result = $this->api->search($param, 'track', ['limit' => 5]);
        if ($result) {
            return $result->tracks->items;
        } else {
            return null;
        }
    }

    public function searchSpotifySongsById($id)
    {
        $song = $this->api->getTrack($id);
        $result = $this->genius->getSearchResource()->get($song->name);


        $rawLyrics = Http::get($this->GENIUS_EMBED_URL_HEAD . $result->hits[0]->result->id . $this->GENIUS_EMBED_URL_TAIL);
        $radable = $this->getReadableLyrics($rawLyrics);

        $result = new Song;

        $result->author = $song->artists[0]->name;
        $result->title = $song->name;
        $result->album_name = $song->album->name;
        $result->album_type = $song->album->album_type;
        $result->image_url = $song->album->images[0]->url;
        $result->is_explicit = 1;
        $result->duration = $song->duration_ms;
        $result->spotify_id = $song->id;
        $result->lyrics = $radable;

        return $result;
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
}

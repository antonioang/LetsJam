<?php

namespace Database\Factories;

use Genius\Genius;
use Http\Message\Authentication\Bearer;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use SpotifyWebAPI\Session;
use SpotifyWebAPI\SpotifyWebAPI;

class SongFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $resultsSpoty = '';
        $param = ['albachiara', 'rewind', 'la prima volta', 'young folks', 'positive vibrations', 'buffalo soldier', 'lunedi', 'hellvisback'];
        $param = $this->faker->randomElement($param);
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
            $resultsSpoty = $result->tracks->items[0];
        } else {
            $resultsSpoty = '';
        }

        $GENIUS_EMBED_URL_HEAD = "https://genius.com/songs/";
        $GENIUS_EMBED_URL_TAIL = "/embed.js";
        $GENIUS_ACCESS = env('GENIUS_ACCESS_TOKEN');

        $authentication = new Bearer($GENIUS_ACCESS);
        $genius = new Genius($authentication);
        $result = $genius->getSearchResource()->get($param);
//        $resultSong= $genius->getSongsResource()->get($result->hits[0]->result->id, 'html');
//        $embed = $resultSong->song->embed_content;

        $rawLyrics = Http::get($GENIUS_EMBED_URL_HEAD . $result->hits[0]->result->id . $GENIUS_EMBED_URL_TAIL);
        $radable = $this->getReadableLyrics($rawLyrics);

        return [
            'author' => $resultsSpoty->artists[0]->name,
            'title' => $resultsSpoty->name,
            'album_name' => $resultsSpoty->album->name,
            'album_type' => $resultsSpoty->album->album_type,
            'image_url' => $resultsSpoty->album->images[0]->url,
            'is_explicit' => 1,
            'duration' => $resultsSpoty->duration_ms,
            'spotify_id' => $resultsSpoty->id,
            'genre_id' => rand(1, 7),
            'lyrics' => $radable,
        ];
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

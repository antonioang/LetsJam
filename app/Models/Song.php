<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Song extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'author',
        'title',
        'album_name',
        'album_type' ,
        'image_url',
        'is_explicit',
        'duration',
        'spotify_id',
        'genre_id',
        'lyrics',
    ];

    /**
     * Get the genre associated with the song.
     */
    public function genre()
    {
        return $this->belongsTo(Genre::class);
    }

    public function musicsheet()
    {
        return $this->hasMany(MusicSheet::class);
    }

}

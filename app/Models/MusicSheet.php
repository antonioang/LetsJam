<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


/**
 * @mixin Builder
 */
class MusicSheet extends Model
{
    use HasFactory;

    protected $fillable = [
        'author',
        'title',
        'verified',
        'visibility' ,
        'rearranged',
        'has_tablature',
        //relazioni
        'song_id',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function genres()
    {
        return $this->belongsToMany(Genre::class, 'musicsheets_genres');
    }

    public function instruments()
    {
        return $this->belongsToMany(Instrument::class, 'musicsheets_instruments');
    }

    public function likes()
    {
        return $this->belongsToMany(User::class, 'musicsheets_users');
    }

    public function song()
    {
        return $this->belongsTo(Song::class);
    }

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'instrument_key',
    ];

    /**
     * Get the songs for the blog post.
     */
    public function songs()
    {
        return $this->hasMany(Song::class, 'genre');
    }

    public function getCompleteDescriptionAttribute(){
        return $this->name.$this->description;
    }

    public function musicsheets()
    {
        return $this->belongsToMany(MusicSheet::class, 'musicsheets_genres');
    }

    public function user(){
        return $this->belongsToMany(User::class,'users_genres');
    }
}

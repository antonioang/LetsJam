<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Instrument extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'instrument_key',
    ];

    public function users(){
        return $this->belongsToMany(User::class,'users_instruments');
    }
    public function musicsheets()
    {
        return $this->belongsToMany(MusicSheet::class, 'musicsheets_instruments');
    }
}

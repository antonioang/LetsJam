<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'content',
        'music_sheet_id',
        'parent_id',
        'user',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function musicSheet()
    {
        return $this->belongsTo(MusicSheet::class);
    }
}

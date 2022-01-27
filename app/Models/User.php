<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

//inserire fillable e relazioni in tutti i modelli
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'firstname',
        'lastname',
        'role',
        'avatar',
        'remember_token',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The genre that belong to the user.
     */
    public function genre()
    {
        return $this->belongsToMany(Genre::class, 'users_genres');
    }

    public function instruments()
    {
        return $this->belongsToMany(Instrument::class, 'users_instruments');
    }

    public function likes()
    {
        return $this->belongsToMany(MusicSheet::class, 'musicsheets_users');
    }

    public function musicsheet()
    {
        return $this->hasMany(MusicSheet::class);
    }

    public function comment()
    {
        return $this->hasMany(Comment::class);
    }
}

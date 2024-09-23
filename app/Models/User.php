<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'authority'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    //relationship between User & Notes
    public function Notes(){
        return $this->hasMany(Notes::class)->orderBy('created_at', 'DESC');
    }

    //relationship between User & User_History
    public function User_History(){
        return $this->hasMany(User_History::class)->orderBy('created_at', 'DESC');
    }

    public function Notes_History(){
        return $this->hasMany(Notes_History::class)->orderBy('created_at', 'DESC');
    }

    //When creating a new user, the Profile model will be created simultaneously
    protected static function boot(){
        parent::boot();

        static::created(function (User $user){
            $user->Profile()->create([
                'Description' => 'Write sth you want to tell everyone',
                'Image' => 'default.png'
            ]); 
        });
    }

    public function Profile(){
        return $this->hasOne(Profile::class);
    }
}

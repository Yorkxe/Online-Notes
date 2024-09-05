<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notes extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'Subject',
        'Created_at',
        'Updated_at'
    ];

    public function User(){
        return $this->belongsTo(User::class);
    }

    public function Notes_History(){
        return $this->hasMany(Notes::class);
    }

}
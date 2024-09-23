<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'user_id',
        'Description',
        'Image',
        'Created_at',
        'Updated_at'
    ];

    public function User(){
        return $this->belongsTo(User::class);
    }
}

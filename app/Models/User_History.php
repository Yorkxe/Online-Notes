<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User_History extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'Notes_id',
        'Move',
        'Created_at',
        'Updated_at'
    ];

    public $table = 'User_History';

    public function User(){
        return $this->hasOne(User::class);
    }
}

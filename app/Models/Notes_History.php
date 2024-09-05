<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notes_History extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'Notes_id',
        'Move',
        'Created_at',
        'Updated_at'
    ];

    public $table = 'Notes_History';

    public function Notes(){
        return $this->hasOne(Notes::class);
    }

    public function User(){
        return $this->hasOne(User::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Npc extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'rank',
        'skillpoints',
        'health',
        'attack',
        'defense',
        'magic',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

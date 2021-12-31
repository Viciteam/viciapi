<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChallengeDetail extends Model
{
    use HasFactory;
    protected $fillable = [
        'challenge_id', 'field', 'data'
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChallengeComment extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id', 'challenge_id', 'comment_media','comment_message', 'likes', 'dislikes', 'islikeselected'
    ];
}

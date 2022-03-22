<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Newsfeed extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'time', 'post_media','post_message', 'likes', 'dislikes', 'islikeselected', 'isPrivate'
    ];

}

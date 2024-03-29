<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewsfeedComment extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id', 'post_id', 'comment_media','comment_message', 'likes', 'dislikes', 'islikeselected'
    ];
}

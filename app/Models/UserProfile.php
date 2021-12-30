<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'profpic_link',
        'bgcolor',
        'username',
        'txtcolor',
        'name',
        'pref_pronoun',
        'bday',
        'bio',
        'mission',
        'country',
    ];
}



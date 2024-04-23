<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SecretFriendGroup extends Model
{
    use HasFactory, SoftDeletes;

    public static $rules = [
        'name'        => 'required|string|max:120',
        'owner_id'    => 'integer|exists:users,id',
        'reveal_date' => 'required|date'
    ];

    protected $fillable = [
        'name',
        'owner_id',
        'reveal_date'
    ];
}

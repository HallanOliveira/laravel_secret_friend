<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Participant extends Model
{
    use HasFactory, SoftDeletes;

    public static $rules = [
        'name'                   => 'required|string|max:150',
        'owner_id'               => 'integer|exists:users,id',
        'phone'                  => 'nullable|string|max:14',
        'email'                  => 'nullable|email|max:150',
        'suggestion'             => 'nullable|string|max:250',
        'secret_friend_id'       => 'integer',
        'secret_friend_group_id' => 'string|max:14',
    ];

    protected $fillable = [
        'name',
        'owner_id',
        'phone',
        'email',
        'suggestion',
        'secret_friend_id',
        'secret_friend_group_id',
    ];

    protected $hidden = [
        'updated_at',
        'deleted_at'
    ];

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function secretFriendGroup()
    {
        return $this->belongsTo(SecretFriendGroup::class, 'secret_friend_group_id');
    }

    public function secretFriend()
    {
        return $this->belongsTo(self::class, 'secret_friend_id');
    }
}

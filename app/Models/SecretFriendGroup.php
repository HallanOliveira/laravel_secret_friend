<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Participant;

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

    protected $hidden = [
        'updated_at',
        'deleted_at'
    ];

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function participants()
    {
        return $this->hasMany(Participant::class, 'secret_friend_group_id');
    }
}

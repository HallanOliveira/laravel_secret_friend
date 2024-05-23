<?php

namespace App\Models;

use App\Models\Participant;
use App\Core\Enums\SecretFriendStatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Validation\Rule;

class SecretFriendGroup extends Model
{
    use HasFactory, SoftDeletes;

    public static function getRules(): array
    {
        return [
            'name'            => 'required|string|max:120',
            'owner_id'        => 'integer|exists:users,id',
            'status_id'       => ['integer', Rule::in(SecretFriendStatusEnum::values())],
            'reveal_date'     => 'required|date',
            'reveal_location' => 'required|string|max:120',
        ];
    }

    protected $fillable = [
        'name',
        'owner_id',
        'status_id',
        'reveal_date',
        'reveal_location'
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

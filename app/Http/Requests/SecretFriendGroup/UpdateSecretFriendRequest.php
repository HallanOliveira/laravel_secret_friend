<?php

namespace App\Http\Requests\SecretFriendGroup;

use App\Models\SecretFriendGroup;
use Illuminate\Foundation\Http\FormRequest;

class UpdateSecretFriendRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return SecretFriendGroup::$rules;
    }
}

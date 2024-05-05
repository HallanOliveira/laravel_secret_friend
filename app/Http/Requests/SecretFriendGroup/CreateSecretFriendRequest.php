<?php

namespace App\Http\Requests\SecretFriendGroup;

use App\Models\Participant;
use App\Models\SecretFriendGroup;
use Illuminate\Foundation\Http\FormRequest;

class CreateSecretFriendRequest extends FormRequest
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
        $dependenciesRules = [];
        foreach (Participant::getRules() as $key => $rule) {
            $dependenciesRules["participants.*.$key"] = 'sometimes|'.$rule;
        }
        return SecretFriendGroup::getRules() + $dependenciesRules;
    }

    protected function prepareForValidation()
    {
        if (! $this->has('participants')) {
            return;
        }

        $participants = $this->get('participants');

        foreach ($participants as &$participant) {
            $participant['phone'] = preg_replace('/[^0-9]/', '', $participant['phone']);
        }

        $this->merge(['participants' => $participants]);
    }
}

<?php

namespace App\Http\Requests;

use App\Rules\SkillAttach;
use App\Rules\SkillExists;
use App\Rules\UserSkillNotAttach;
use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => 'sometimes',
            'add_skills' => [
                'sometimes',
                'array',
                new SkillAttach($this->route('user')),
                new SkillExists($this->route('user')),
            ],
            'add_skills.*' => 'distinct',
            'remove_skills' => [
                'sometimes',
                'array',
                new UserSkillNotAttach($this->route('user')),
            ],
            'remove_skills.*' => 'distinct',
        ];
    }
}

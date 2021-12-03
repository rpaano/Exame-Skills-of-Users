<?php

namespace App\Rules;

use App\Models\Skill;
use App\Models\SkillUser;
use App\Models\User;
use Illuminate\Contracts\Validation\Rule;

class SkillExists implements Rule
{
    /**
     * @var User
     */
    protected $user;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value): bool
    {
        return Skill::query()->whereIn('id', $value)->count() == count($value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return __("Skill does not exists");
    }
}

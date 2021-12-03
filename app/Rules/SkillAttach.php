<?php

namespace App\Rules;

use App\Models\SkillUser;
use App\Models\User;
use Illuminate\Contracts\Validation\Rule;

class SkillAttach implements Rule
{
    /**
     * @var int
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
    public function passes($attribute, $value)
    {
        return !$this->user->skills()->wherePivotIn('skill_id', $value)->exists();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return __("Skill already attach to user");
    }
}

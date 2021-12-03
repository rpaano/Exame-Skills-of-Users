<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class SkillUser extends Pivot
{
    protected $table = "skill_user";
}

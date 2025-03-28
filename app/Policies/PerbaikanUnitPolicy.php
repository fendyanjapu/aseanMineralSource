<?php

namespace App\Policies;

use App\Models\PerbaikanUnit;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PerbaikanUnitPolicy
{
    public function update(User $user, PerbaikanUnit $perbaikanUnit): bool
    {
        return ($user->level_id < 3 || $perbaikanUnit->user_id === $user->id);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, PerbaikanUnit $perbaikanUnit): bool
    {
        return ($user->level_id < 3 || $perbaikanUnit->user_id === $user->id);
    }

}

<?php

namespace App\Policies;

use App\Models\RotasiUnit;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class RotasiUnitPolicy
{
    public function update(User $user, RotasiUnit $rotasiUnit): bool
    {
        return ($user->level_id < 2 || $rotasiUnit->user_id === $user->id);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, RotasiUnit $rotasiUnit): bool
    {
        return ($user->level_id < 2 || $rotasiUnit->user_id === $user->id);
    }
}

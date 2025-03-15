<?php

namespace App\Policies;

use App\Models\RotasiUnit;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class RotasiUnitPolicy
{
    public function create(User $user): bool
    {
        return ($user->level_id == 1 || $user->level_id == 4);
    }
    public function update(User $user, RotasiUnit $rotasiUnit): bool
    {
        return ($user->level_id == 1 || $user->level_id == 3 || $rotasiUnit->user_id === $user->id);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, RotasiUnit $rotasiUnit): bool
    {
        return ($user->level_id == 1 || $user->level_id == 3 || $rotasiUnit->user_id === $user->id);
    }
}

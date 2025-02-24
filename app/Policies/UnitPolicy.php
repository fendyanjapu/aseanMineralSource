<?php

namespace App\Policies;

use App\Models\Unit;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class UnitPolicy
{
    public function update(User $user, Unit $unit): bool
    {
        return ($user->level == 'Direksi' || $user->level == 'Admin');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Unit $unit): bool
    {
        return ($user->level == 'Direksi' || $user->level == 'Admin');
    }
}

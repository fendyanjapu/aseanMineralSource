<?php

namespace App\Policies;

use App\Models\PerbaikanUnit;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PerbaikanUnitPolicy
{
    
    public function update(User $user, PerbaikanUnit $perbaikanUnit): bool
    {
        return ($user->level == 'Direksi' || $user->level == 'Admin');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, PerbaikanUnit $perbaikanUnit): bool
    {
        return ($user->level == 'Direksi' || $user->level == 'Admin');
    }

}

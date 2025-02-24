<?php

namespace App\Policies;

use App\Models\Penggajihan;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PenggajihanPolicy
{
    
    public function update(User $user, Penggajihan $penggajihan): bool
    {
        return ($user->level == 'Direksi' || $user->level == 'Admin');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Penggajihan $penggajihan): bool
    {
        return ($user->level == 'Direksi' || $user->level == 'Admin');
    }

}

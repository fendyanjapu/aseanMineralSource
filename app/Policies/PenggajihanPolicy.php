<?php

namespace App\Policies;

use App\Models\Penggajihan;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PenggajihanPolicy
{
    
    public function update(User $user, Penggajihan $penggajihan): bool
    {
        return ($user->level_id < 3 || $penggajihan->user_id === $user->id);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Penggajihan $penggajihan): bool
    {
        return ($user->level_id < 3 || $penggajihan->user_id === $user->id);
    }

}

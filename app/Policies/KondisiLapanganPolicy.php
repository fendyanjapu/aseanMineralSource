<?php

namespace App\Policies;

use App\Models\KondisiLapangan;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class KondisiLapanganPolicy
{
    
    public function update(User $user, KondisiLapangan $kondisiLapangan): bool
    {
        return ($user->level_id < 3 || $kondisiLapangan->user_id === $user->id);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, KondisiLapangan $kondisiLapangan): bool
    {
        return ($user->level_id < 3 || $kondisiLapangan->user_id === $user->id);
    }

}

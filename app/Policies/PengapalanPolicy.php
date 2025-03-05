<?php

namespace App\Policies;

use App\Models\Pengapalan;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PengapalanPolicy
{
    public function update(User $user, Pengapalan $pengapalan): bool
    {
        return ($user->level_id < 2 || $pengapalan->user_id === $user->id);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Pengapalan $pengapalan): bool
    {
        return ($user->level_id < 2 || $pengapalan->user_id === $user->id);
    }
}

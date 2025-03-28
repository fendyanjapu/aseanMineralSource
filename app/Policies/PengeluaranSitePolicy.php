<?php

namespace App\Policies;

use App\Models\PengeluaranSite;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PengeluaranSitePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->level_id < 4;
    }

    public function create(User $user): bool
    {
        return $user->level_id < 4;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, PengeluaranSite $pengeluaranSite): bool
    {
        return ($user->level_id < 3 || $pengeluaranSite->user_id === $user->id);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, PengeluaranSite $pengeluaranSite): bool
    {
        return ($user->level_id < 3 || $pengeluaranSite->user_id === $user->id);
    }

}

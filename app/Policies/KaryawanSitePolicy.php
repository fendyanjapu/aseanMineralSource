<?php

namespace App\Policies;

use App\Models\KaryawanSite;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class KaryawanSitePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->level_id < 3;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->level_id < 3;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, KaryawanSite $karyawanSite): bool
    {
        return $user->level_id < 3;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, KaryawanSite $karyawanSite): bool
    {
        return $user->level_id < 3;
    }

}

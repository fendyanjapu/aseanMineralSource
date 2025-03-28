<?php

namespace App\Policies;

use App\Models\GajihKaryawanSite;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class GajihKaryawanSitePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->level_id < 3;
    }

    public function create(User $user): bool
    {
        return $user->level_id < 3;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, GajihKaryawanSite $gajihKaryawanSite): bool
    {
        return $user->level_id < 3;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, GajihKaryawanSite $gajihKaryawanSite): bool
    {
        return $user->level_id < 3;
    }

}

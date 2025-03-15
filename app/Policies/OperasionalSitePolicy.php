<?php

namespace App\Policies;

use App\Models\OperasionalSite;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class OperasionalSitePolicy
{
    public function create(User $user): bool
    {
        return ($user->level_id == 1 || $user->level_id == 4);
    }
    public function update(User $user, OperasionalSite $operasionalSite): bool
    {
        return ($user->level_id == 1 || $user->level_id == 3 || $operasionalSite->user_id === $user->id);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, OperasionalSite $operasionalSite): bool
    {
        return ($user->level_id == 1 || $user->level_id == 3 || $operasionalSite->user_id === $user->id);
    }
}

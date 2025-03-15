<?php

namespace App\Policies;

use App\Models\Site;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class SitePolicy
{
    public function viewAny(User $user): bool
    {
        return ($user->level_id < 3);
    }

    public function create(User $user): bool
    {
        return ($user->level_id < 3);
    }
    public function update(User $user, Site $site): bool
    {
        return ($user->level_id < 3);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Site $site): bool
    {
        return ($user->level_id < 3);
    }
}

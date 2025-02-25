<?php

namespace App\Policies;

use App\Models\Site;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class SitePolicy
{
    public function update(User $user, Site $site): bool
    {
        return ($user->level_id < 3 || $site->user_id === $user->id);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Site $site): bool
    {
        return ($user->level_id < 3 || $site->user_id === $user->id);
    }
}

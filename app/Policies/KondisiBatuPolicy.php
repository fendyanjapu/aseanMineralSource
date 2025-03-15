<?php

namespace App\Policies;

use App\Models\KondisiBatu;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class KondisiBatuPolicy
{
    public function create(User $user): bool
    {
        return ($user->level_id != 2 );
    }
    public function update(User $user, KondisiBatu $kondisiBatu): bool
    {
        return ($user->level_id == 1 || $kondisiBatu->user_id === $user->id);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, KondisiBatu $kondisiBatu): bool
    {
        return ($user->level_id == 1 || $kondisiBatu->user_id === $user->id);
    }
}

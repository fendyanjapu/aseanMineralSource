<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Operasional;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Session;

class OperasionalPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return Session::get('level') < 4;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return Session::get('level') < 4;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Operasional $operasional): bool
    {
        return ($user->level_id < 3 || $operasional->user_id === $user->id);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Operasional $operasional): bool
    {
        return ($user->level_id < 3 || $operasional->user_id === $user->id);
    }

}

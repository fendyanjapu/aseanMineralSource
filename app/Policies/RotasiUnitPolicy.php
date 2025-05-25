<?php

namespace App\Policies;

use App\Models\User;
use App\Models\RotasiUnit;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Session;

class RotasiUnitPolicy
{
    public function create(User $user): bool
    {
        return ($user->level_id == 1 || Session::get('level') == 4);
    }
    public function update(User $user, RotasiUnit $rotasiUnit): bool
    {
        return ($user->level_id == 1 || Session::get('level') == 3 || $rotasiUnit->user_id === $user->id);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, RotasiUnit $rotasiUnit): bool
    {
        return ($user->level_id == 1 || Session::get('level') == 3 || $rotasiUnit->user_id === $user->id);
    }
}

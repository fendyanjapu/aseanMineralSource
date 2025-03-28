<?php

namespace App\Policies;

use App\Models\Pemasukan;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PemasukanPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->level_id == 2;
    }

    public function create(User $user): bool
    {
        return $user->level_id == 2;
    }
    public function update(User $user, Pemasukan $pemasukan): bool
    {
        return $user->level_id == 2;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Pemasukan $pemasukan): bool
    {
        return $user->level_id == 2;
    }

}

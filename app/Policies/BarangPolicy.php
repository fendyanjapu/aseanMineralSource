<?php

namespace App\Policies;

use App\Models\Barang;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class BarangPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->level_id < 3;
    }

    public function create(User $user): bool
    {
        return $user->level_id < 3;
    }

    public function update(User $user, Barang $barang): bool
    {
        return $user->level_id < 3;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Barang $barang): bool
    {
        return $user->level_id < 3;
    }
}

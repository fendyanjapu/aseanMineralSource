<?php

namespace App\Policies;

use App\Models\PembelianBatu;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PembelianBatuPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->level_id < 3;
    }
    
    public function create(User $user): bool
    {
        return $user->level_id < 3;
    }
    public function update(User $user, PembelianBatu $pembelianBatu): bool
    {
        return $user->level_id < 3;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, PembelianBatu $pembelianBatu): bool
    {
        return $user->level_id < 3;
    }

}

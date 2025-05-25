<?php

namespace App\Policies;

use App\Models\User;
use App\Models\PembelianBarang;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Session;

class PembelianBarangPolicy
{
    public function viewAny(User $user): bool
    {
        return Session::get('level') < 4;
    }

    public function create(User $user): bool
    {
        return Session::get('level') < 4;
    }

    
    public function update(User $user, PembelianBarang $pembelianBarang): bool
    {
        return ($user->level_id < 3 || $pembelianBarang->user_id === $user->id);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, PembelianBarang $pembelianBarang): bool
    {
        return ($user->level_id < 3 || $pembelianBarang->user_id === $user->id);
    }

}

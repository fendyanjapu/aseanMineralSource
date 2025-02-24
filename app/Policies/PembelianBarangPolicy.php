<?php

namespace App\Policies;

use App\Models\PembelianBarang;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PembelianBarangPolicy
{
    
    public function update(User $user, PembelianBarang $pembelianBarang): bool
    {
        return ($user->level == 'Direksi' || $user->level == 'Admin');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, PembelianBarang $pembelianBarang): bool
    {
        return ($user->level == 'Direksi' || $user->level == 'Admin');
    }

}

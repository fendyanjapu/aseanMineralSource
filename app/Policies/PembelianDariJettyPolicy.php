<?php

namespace App\Policies;

use App\Models\PembelianDariJetty;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PembelianDariJettyPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->level_id < 3;
    }

    public function create(User $user): bool
    {
        return $user->level_id < 3;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, PembelianDariJetty $pembelianDariJetty): bool
    {
        return $user->level_id < 3;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, PembelianDariJetty $pembelianDariJetty): bool
    {
        return $user->level_id < 3;
    }

}

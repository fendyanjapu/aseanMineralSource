<?php

namespace App\Policies;

use App\Models\PembayaranPenjualan;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PembayaranPenjualanPolicy
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
    public function update(User $user, PembayaranPenjualan $pembayaranPenjualan): bool
    {
        return $user->level_id < 3;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, PembayaranPenjualan $pembayaranPenjualan): bool
    {
        return $user->level_id < 3;
    }

}

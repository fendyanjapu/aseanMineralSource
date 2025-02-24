<?php

namespace App\Policies;

use App\Models\Pemasukan;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PemasukanPolicy
{
    
    public function update(User $user, Pemasukan $pemasukan): bool
    {
        return ($user->level == 'Direksi' || $user->level == 'Admin');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Pemasukan $pemasukan): bool
    {
        return ($user->level == 'Direksi' || $user->level == 'Admin');
    }

}

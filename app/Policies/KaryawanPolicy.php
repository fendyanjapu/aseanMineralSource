<?php

namespace App\Policies;

use App\Models\Karyawan;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class KaryawanPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->level_id < 3;
    }
    
    public function create(User $user): bool
    {
        return $user->level_id < 3;
    }
    public function update(User $user, Karyawan $karyawan): bool
    {
        return $user->level_id < 3;
    }

    public function delete(User $user, Karyawan $karyawan): bool
    {
        return $user->level_id < 3;
    }

}

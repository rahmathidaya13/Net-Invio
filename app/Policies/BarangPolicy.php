<?php

namespace App\Policies;

use App\Models\Barang\BarangModel;
use App\Models\User;

class BarangPolicy
{

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user): bool
    {
        return $user->can_view;
    }

    /**
     * Determine whether the user can create models.
     */
    public function add(User $user): bool
    {
        return $user->can_add;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function edit(User $user): bool
    {
        return $user->can_edit;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user): bool
    {
        return $user->can_delete;
    }
}

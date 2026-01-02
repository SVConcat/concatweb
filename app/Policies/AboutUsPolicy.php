<?php

namespace App\Policies;

use App\Models\BoardMember;
use App\Models\PreviousBoard;
use App\Models\User;

class AboutUsPolicy
{
    /**
     * Determine whether the user can edit board members.
     */
    public function editBoardMember(User $user): bool
    {
        return $user->role === 'admin';
    }

    /**
     * Determine whether the user can update board members.
     */
    public function updateBoardMember(User $user): bool
    {
        return $user->role === 'admin';
    }

    /**
     * Determine whether the user can edit previous boards.
     */
    public function editPreviousBoard(User $user): bool
    {
        return $user->role === 'admin';
    }

    /**
     * Determine whether the user can update previous boards.
     */
    public function updatePreviousBoard(User $user): bool
    {
        return $user->role === 'admin';
    }
}

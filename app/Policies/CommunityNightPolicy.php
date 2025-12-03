<?php

namespace App\Policies;

use App\Models\CommunityNight;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CommunityNightPolicy
{

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
       return $user->role === 'admin';
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, CommunityNight $communityNight): bool
    {
        return $user->role === 'admin';
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function destroy(User $user, CommunityNight $communityNight): bool
    {
        return $user->role === 'admin';
    }


}

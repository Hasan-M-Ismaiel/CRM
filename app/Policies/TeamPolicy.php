<?php

namespace App\Policies;

use App\Models\Team;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class TeamPolicy
{
    // not needed because we only need to access to specific chat - showing all related chat is done in Team Controller [index method]
    /**
     * Determine whether the user can view any models.
     */
    // public function viewAny(User $user): bool
    // {
        // return $team->users->contains($user);
    // }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Team $team): bool
    {
        return $team->project->users->contains($user);
    }
}

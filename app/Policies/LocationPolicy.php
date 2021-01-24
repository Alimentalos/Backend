<?php

namespace App\Policies;

use App\Models\Location;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class LocationPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the location.
     *
     * @param User $user
     * @param Location $location
     * @return mixed
     */
    public function view(User $user, Location $location)
    {
        return $user->can('view', $location->trackable);
    }
}

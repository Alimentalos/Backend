<?php

namespace App\Repositories;

use App\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;

class UsersRepository
{
    /**
     * Get users.
     *
     * @return LengthAwarePaginator
     */
    public function getUsers()
    {
        return User::with('photo', 'user')
            ->latest()
            ->paginate(20);
    }

    /**
     * Get scoped users.
     *
     * @return LengthAwarePaginator
     */
    public function getScopedUsers()
    {
        $uuid = authenticated()->is_child ? authenticated()->uuid : authenticated()->user_uuid;
        return User::with('photo', 'user')
            ->latest()
            ->where('user_uuid', $uuid)
            ->orWhere('uuid', $uuid)
            ->orWhere('is_public', true)->paginate(20);
    }

    /**
     * Register user via request.
     *
     * @return mixed
     */
    public function registerViaRequest()
    {
        return User::create(array_merge([
            'password' => bcrypt(input('password')),
        ], only('email', 'name', 'is_public')));
    }

    /**
     * Update user via request.
     *
     * @param User $user
     * @return User
     */
    public function updateUserViaRequest(User $user)
    {
        upload()->check($user);
        $user->load('user', 'photo');
        $user->update(parameters()->fill(['email', 'name', 'is_public'], $user));
        return $user;
    }

    /**
     * Create user via request.
     *
     * @return User
     */
    public function createUserViaRequest()
    {
        $photo = photos()->createViaRequest();
        $user = User::create(array_merge([
            'user_uuid' => authenticated()->uuid,
            'photo_uuid' => $photo->uuid,
            'photo_url' => config('storage.path') . $photo->photo_url,
            'password' => bcrypt(input('password')),
            'location' => parser()->pointFromCoordinates(input('coordinates')),
        ], only('name', 'email', 'is_public')));
        $user->photos()->attach($photo->uuid);
        $user->load('photo', 'user');
        return $user;
    }
}

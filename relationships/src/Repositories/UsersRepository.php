<?php

namespace Demency\Relationships\Repositories;

use Demency\Relationships\Asserts\UserAssert;
use App\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class UsersRepository
{
    use UserAssert;

    /**
     * Get users.
     *
     * @return LengthAwarePaginator
     */
    public function all()
    {
        return User::latest()
            ->paginate(20);
    }

    /**
     * Get scoped users.
     *
     * @return LengthAwarePaginator
     */
    public function index()
    {
        $uuid = authenticated()->is_child ? authenticated()->uuid : authenticated()->user_uuid;
        return User::latest()
            ->where('user_uuid', $uuid)
            ->orWhere('uuid', $uuid)
            ->orWhere('is_public', true)->paginate(20);
    }

    /**
     * Register user.
     *
     * @return mixed
     */
    public function register()
    {
        return User::create(array_merge([
            'password' => bcrypt(input('password')),
        ], only('email', 'name', 'is_public', 'country', 'region', 'city', 'city_name', 'region_name', 'country_name')));
    }

    /**
     * Update user.
     *
     * @param User $user
     * @return User
     */
    public function update(User $user)
    {
        upload()->check($user);
        $user->update(parameters()->fill(['email', 'name', 'is_public', 'country', 'region', 'city', 'city_name', 'region_name', 'country_name'], $user));
        return $user;
    }

    /**
     * Create user.
     *
     * @return User
     */
    public function create()
    {
        $photo = photos()->create();
        $user = User::create(array_merge([
            'user_uuid' => authenticated()->uuid,
            'photo_uuid' => $photo->uuid,
            'photo_url' => config('storage.path') . $photo->photo_url,
            'password' => bcrypt(input('password')),
            'location' => parser()->pointFromCoordinates(input('coordinates')),
        ], only('name', 'email', 'is_public')));
        $user->photos()->attach($photo->uuid);
        return $user;
    }
}

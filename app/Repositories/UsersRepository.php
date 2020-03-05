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
        return User::with('photo', 'user')->latest()->paginate(20);
    }

    /**
     * Get child users.
     *
     * @return LengthAwarePaginator
     */
    public function getChildUsers()
    {
        return User::with('photo', 'user')->latest()->where([
            ['user_uuid', authenticated()->uuid]
        ])->orWhere([
            ['uuid', authenticated()->uuid]
        ])->orWhere([
            ['is_public', true]
        ])->paginate(20);
    }

    /**
     * Get owner users.
     *
     * @return LengthAwarePaginator
     */
    public function getOwnerUsers()
    {
        return User::with('photo', 'user')->latest()->where([
            ['user_uuid', authenticated()->user_uuid]
        ])->orWhere([
            ['uuid', authenticated()->user_uuid]
        ])->orWhere([
            ['is_public', true]
        ])->paginate(20);
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
        UploadRepository::check($user);
        $user->load('user', 'photo');
        $user->update(parameters()->fill(['email', 'name', 'is_public'], $user));
        return $user;
    }

    /**
     * Create user via request.
     *
     * @return mixed
     */
    public function createUserViaRequest()
    {
        $photo = photos()->createPhotoViaRequest();
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

    /**
     * Check if userA is same of userB
     *
     * @param object|User $userA
     * @param object|User $userB
     * @return bool
     */
    public function sameUser(User $userA, User $userB)
    {
        return $userA->uuid === $userB->uuid;
    }

    /**
     * Check if userA has same owner of userB
     *
     * @param object|User $userA
     * @param object|User $userB
     * @return bool
     */
    public function sameOwner(User $userA, User $userB)
    {
        return $userA->user_uuid === $userB->user_uuid;
    }

    /**
     * Check if userA is owner of userB
     *
     * @param object|User $userA
     * @param object|User $userB
     * @return bool
     */
    public function isOwner(User $userA, User $userB)
    {
        return $userA->uuid === $userB->user_uuid;
    }

    /**
     * Check if userA is worker of userB
     *
     * @param object|User $userA
     * @param object|User $userB
     * @return bool
     */
    public function isWorker(User $userA, User $userB)
    {
        return $userA->user_uuid === $userB->uuid;
    }

    /**
     * Check if device is property of user
     *
     * @param object|Model $model
     * @param object|User $user
     * @return bool
     */
    public function isProperty(Model $model, User $user)
    {
        return $model->user_uuid === $user->uuid;
    }
}

<?php

namespace App\Repositories;

use App\Photo;
use App\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

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
     * @param Request $request
     * @return mixed
     */
    public static function registerViaRequest(Request $request)
    {
        $user = User::create(array_merge([
            'password' => bcrypt($request->input('password')),
        ], $request->only('email', 'name', 'is_public')));
        event(new Registered($user));
        return $user;
    }

    /**
     * Update user via request.
     *
     * @param Request $request
     * @param User $user
     * @return User
     */
    public static function updateUserViaRequest(Request $request, User $user)
    {
        UploadRepository::checkPhotoForUpload($request, $user);
        $user->load('user', 'photo');
        $user->update(ParametersRepository::fillPropertiesWithRelated($request, ['email', 'name', 'is_public'], $user));
        return $user;
    }

    /**
     * Create user via request.
     *
     * @param Request $request
     * @param Photo $photo
     * @return mixed
     */
    public static function createUserViaRequest(Request $request)
    {
        $photo = PhotoRepository::createPhotoViaRequest($request);
        $user = User::create(array_merge([
            'user_uuid' => $request->user('api')->uuid,
            'photo_uuid' => $photo->uuid,
            'photo_url' => config('storage.path') . $photo->photo_url,
            'password' => bcrypt($request->input('password')),
            'location' => LocationsRepository::parsePointFromCoordinates($request->input('coordinates')),
        ], $request->only('name', 'email', 'is_public')));
        $user->photos()->attach($photo->uuid);
        event(new Registered($user));
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
    public static function sameUser(User $userA, User $userB)
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
    public static function sameOwner(User $userA, User $userB)
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
    public static function isOwner(User $userA, User $userB)
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
    public static function isWorker(User $userA, User $userB)
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
    public static function isProperty(Model $model, User $user)
    {
        return $model->user_uuid === $user->uuid;
    }
}

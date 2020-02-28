<?php

namespace App\Repositories;

use App\Photo;
use App\User;
use Grimzy\LaravelMysqlSpatial\Types\Point;
use Illuminate\Auth\Events\Registered;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class UsersRepository
{
    public static function createUserViaRequest(Request $request, Photo $photo)
    {
        $exploded = explode(',', $request->input('coordinates'));
        $user = User::create([
            'user_id' => $request->user('api')->id,
            'photo_id' => $photo->id,
            'photo_url' => 'https://storage.googleapis.com/photos.zendev.cl/photos/' . $photo->photo_url,
            'email' => $request->input('email'),
            'name' => $request->input('name'),
            'password' => bcrypt($request->input('password')),
            'is_public' => $request->input('is_public'),
            'location' => (new Point(
                floatval($exploded[0]),
                floatval($exploded[1])
            )),
        ]);
        $user->photos()->attach($photo->id);
        event(new Registered($user));
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
        return $userA->id === $userB->id;
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
        return $userA->user_id === $userB->user_id;
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
        return $userA->id === $userB->user_id;
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
        return $userA->user_id === $userB->id;
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
        return $model->user_id === $user->id;
    }
}

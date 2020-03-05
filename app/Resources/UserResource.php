<?php

namespace App\Resources;

use App\Repositories\AdminRepository;
use App\Repositories\UsersRepository;
use App\Rules\Coordinate;
use App\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

trait UserResource
{
    /**
     * Update user via request.
     *
     * @return User
     */
    public function updateViaRequest()
    {
        return users()->updateUserViaRequest($this);
    }

    /**
     * Create user via request.
     *
     * @return User
     */
    public function createViaRequest()
    {
        return users()->createUserViaRequest();
    }

    /**
     * Get available user reactions.
     *
     * @return string
     */
    public function getAvailableReactions()
    {
        return 'Follow';
    }

    /**
     * Update user validation rules.
     *
     * @param Request $request
     * @return array
     */
    public function updateRules(Request $request)
    {
        return [
            'coordinates' => [
                Rule::requiredIf(function () use ($request) {
                    return $request->has('photo');
                }), new Coordinate()
            ],
        ];
    }

    /**
     * Store user validation rules.
     *
     * @param Request $request
     * @return array
     */
    public function storeRules(Request $request)
    {
        return [
            'name' => 'required',
            'photo' => 'required',
            'email' => 'required|unique:users,email',
            'password' => 'required|confirmed|min:8',
            'is_public' => 'required|boolean',
            'coordinates' => ['required', new Coordinate()],
        ];
    }

    /**
     * Get user relationships using lazy loading.
     *
     * @return array
     */
    public function getLazyRelationshipsAttribute()
    {
        return ['photo', 'user'];
    }

    /**
     * Get user instances.
     *
     * @param Request $request
     * @return LengthAwarePaginator
     */
    public function getInstances(Request $request)
    {
        if (authenticated()->is_admin)
            return users()->getUsers();

        return authenticated()->is_child ? users()->getChildUsers() : users()->getOwnerUsers();
    }

    /**
     * Get is_admin custom attribute
     *
     * @return bool
     */
    public function getIsAdminAttribute()
    {
        return AdminRepository::isAdmin($this);
    }

    /**
     * Get is_child custom attribute.
     *
     * @return bool
     */
    public function getIsChildAttribute()
    {
        return !is_null($this->user_uuid);
    }
}

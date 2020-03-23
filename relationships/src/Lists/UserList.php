<?php


namespace Demency\Relationships\Lists;

use Demency\Relationships\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

trait UserList
{
    /**
     * Get users.
     *
     * @return LengthAwarePaginator
     */
    public function all()
    {
        return User::latest()
            ->where('name', 'like', "%" . input('q') . "%")
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
            ->orWhere('is_public', true)
            ->where('name', 'like', "%" . input('q') . "%")
            ->paginate(20);
    }

}

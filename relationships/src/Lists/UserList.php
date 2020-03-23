<?php


namespace Alimentalos\Relationships\Lists;

use Alimentalos\Relationships\Models\User;
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
            ->paginate(20);
    }

}

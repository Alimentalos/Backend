<?php


namespace App\Lists;


use App\Action;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

trait ActionList
{
    /**
     * Get owner actions.
     *
     * @return LengthAwarePaginator
     */
    public function getOwnerActions()
    {
        return Action::with('user')
            ->whereIn('user_uuid', authenticated()
                ->users
                ->pluck('uuid')
                ->push(authenticated()->uuid)
                ->toArray()
            )->paginate(25);
    }

    /**
     * Get child actions.
     *
     * @return LengthAwarePaginator
     */
    public function getChildActions()
    {
        return Action::with('user')
            ->where('user_uuid', authenticated()->uuid)
            ->paginate(25);
    }
}

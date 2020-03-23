<?php


namespace Alimentalos\Relationships\Lists;


use Alimentalos\Relationships\Models\Action;
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
        return Action::whereIn('user_uuid', authenticated()
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
        return Action::where('user_uuid', authenticated()->uuid)
            ->paginate(25);
    }
}

<?php


namespace App\Lists;


use App\Group;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

trait GroupList
{
    /**
     * Get scoped groups.
     *
     * @return LengthAwarePaginator
     */
    public function index()
    {
        return Group::with('user', 'photo')
            ->where('user_uuid', authenticated()->uuid)
            ->orWhere('is_public', true)
            ->orWhereIn('uuid', authenticated()->groups->pluck('uuid')->toArray())
            ->latest()
            ->paginate(25);
    }

    /**
     * Get all groups.
     *
     * @return LengthAwarePaginator
     */
    public function all()
    {
        return Group::with('user', 'photo')
            ->latest()
            ->paginate(25);
    }
}

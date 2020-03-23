<?php

namespace Demency\Relationships\Lists;

use Demency\Relationships\Models\Group;
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
        return Group::where('user_uuid', authenticated()->uuid)
            ->orWhere('is_public', true)
            ->orWhereIn('uuid', authenticated()->groups->pluck('uuid')->toArray())
            ->where('name', 'like', "%" . input('q') . "%")
            ->where('description', 'like', "%" . input('d') . "%")
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
        return Group::latest()
            ->where('name', 'like', "%" . input('q') . "%")
            ->where('description', 'like', "%" . input('d') . "%")
            ->paginate(25);
    }
}

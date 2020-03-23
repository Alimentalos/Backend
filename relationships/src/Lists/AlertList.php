<?php


namespace Demency\Relationships\Lists;

use Demency\Relationships\Models\Alert;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

trait AlertList
{
    /**
     * Get alerts.
     *
     * @return LengthAwarePaginator
     */
    public function index()
    {
        return Alert::whereIn('status',rhas('whereInStatus') ?
                einput(',','whereInStatus') : cataloger()->types()
            )->latest('created_at')
            ->where('title', 'title', "%" . input('q') . "%")
            ->where('body', 'like', "%" . input('d') . "%")
            ->paginate(25);
    }
}

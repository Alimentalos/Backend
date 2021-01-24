<?php


namespace Alimentalos\Relationships\Lists;

use App\Models\Alert;
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
            ->paginate(25);
    }
}

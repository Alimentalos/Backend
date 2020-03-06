<?php


namespace App\Lists;

use App\Alert;
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
        return Alert::with('user', 'photo', 'alert')
            ->whereIn('status',rhas('whereInStatus') ?
                einput(',','whereInStatus') : status()->values()
            )->latest('created_at')
            ->paginate(25);
    }
}

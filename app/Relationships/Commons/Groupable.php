<?php


namespace App\Relationships\Commons;

use Demency\Groupable\Models\Group;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

trait Groupable
{
    /**
     * The resource related groups.
     *
     * @return BelongsToMany
     */
    public function groups()
    {
        return $this->morphToMany(Group::class,'groupable','groupables','groupable_id','group_uuid','uuid','uuid')->withPivot(['is_admin','status','sender_uuid',])->withTimestamps();
    }
}

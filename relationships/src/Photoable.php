<?php

namespace Alimentalos\Relationships;

use Alimentalos\Relationships\Models\Photo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

trait Photoable
{
    /**
     * The resource related photos.
     *
     * @return BelongsToMany
     */
    public function photos()
    {
        return $this->morphToMany(Photo::class, 'photoable','photoables','photoable_id','photo_uuid','uuid','uuid');
    }
}

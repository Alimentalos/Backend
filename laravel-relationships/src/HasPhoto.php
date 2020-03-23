<?php

namespace Demency\Relationships;

use Demency\Relationships\Models\Photo;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait HasPhoto
{
    /**
     * The resource related photo.
     *
     * @return BelongsTo
     */
    public function photo()
    {
        return $this->belongsTo(Photo::class, 'photo_uuid', 'uuid');
    }
}

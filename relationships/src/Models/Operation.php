<?php

namespace Demency\Relationships\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Operation extends Model
{
    /**
     * In status
     *
     * @var int
     */
    public int $in_status = 1;

    /**
     * Out status
     *
     * @var int
     */
    public int $out_status = 0;

    /**
     * This model doesn't uses increments.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * The related receiver.
     *
     * @return BelongsTo
     */
    public function receiver()
    {
        return $this->morphTo('receiver','receiver_type','receiver_id','uuid');
    }

    /**
     * The related emitter.
     *
     * @return BelongsTo
     */
    public function emitter()
    {
        return $this->morphTo('emitter','emitter_type','emitter_id','uuid');
    }
}

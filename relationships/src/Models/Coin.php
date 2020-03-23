<?php

namespace Alimentalos\Relationships\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Coin extends Model
{
    /**
     * This model doesn't uses increments.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'used' => 'boolean'
    ];

    /**
     * The mass assignment fields of the comment
     *
     * @var array
     */
    protected $fillable = [
        'uuid',
        'amount',
        'used',
        'received_operation_uuid',
        'used_operation_uuid',
    ];

    /**
     * The related monetizer resource.
     */
    public function monetizer()
    {
        return $this->morphTo(
            'monetizer',
            'monetizer_type',
            'monetizer_id',
            'uuid'
        );
    }

    /**
     * Operation what money was received.
     *
     * @return BelongsTo
     */
    public function received_operation()
    {
        return $this->belongsTo(Operation::class, 'received_operation_uuid', 'uuid');
    }

    /**
     * Operation what money was used.
     *
     * @return BelongsTo
     */
    public function used_operation()
    {
        return $this->belongsTo(Operation::class, 'received_operation_uuid', 'uuid');
    }
}

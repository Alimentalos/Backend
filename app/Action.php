<?php

namespace App;

use App\Contracts\Resource;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Action extends Model implements Resource
{
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'parameters' => 'array'
    ];

    /**
     * The mass assignment fields of the action.
     *
     * @var array
     */
    protected $fillable = [
        'uuid',
        'user_id',
        'type',
        'resource',
        'parameters',
        'referenced_id'
    ];

    /**
     * Get the related user of action.
     *
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get lazy loaded relationships of Action.
     *
     * @return array
     */
    public function getLazyRelationshipsAttribute()
    {
        return ['user'];
    }
}

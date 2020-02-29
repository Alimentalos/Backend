<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Alert extends Model
{
    /**
     * The table name of alert.
     *
     * @var string
     */
    protected $table = 'alerts';

    /**
     * The mass assignment fields of alert.
     *
     * @var array
     */
    protected $fillable = [
        'uuid',
        'user_id',
        'alert_id',
        'alert_type',
        'type',
        'location',
        'title',
        'body',
        'status',
    ];

    /**
     * The hidden fields of alert.
     *
     * @var array
     */
    protected $hidden = [
        'id'
    ];

    /**
     * Get the route key for the alert.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'uuid';
    }

    /**
     * Get all of the owning alert models.
     */
    public function alert()
    {
        return $this->morphTo();
    }

    /**
     * The related User.
     *
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * The related Comments.
     *
     * @return MorphMany
     */
    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
        'title',
        'body',
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
}

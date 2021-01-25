<?php

namespace App\Models;

use App\Contracts\Resource;
use Alimentalos\Relationships\BelongsToUser;
use App\Resources\ActionResource;
use Database\Factories\ActionFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Action extends Model implements Resource
{
    use HasFactory, ActionResource, BelongsToUser;

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'parameters' => 'array',
    ];

    /**
     * The mass assignment fields of the action.
     *
     * @var array
     */
    protected $fillable = [
        'uuid',
        'user_uuid',
        'type',
        'resource',
        'parameters',
        'referenced_uuid'
    ];

    /**
     * The properties which are hidden.
     *
     * @var array
     */
    protected $hidden = ['id'];

    protected static function newFactory()
    {
        return ActionFactory::new();
    }
}

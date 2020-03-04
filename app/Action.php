<?php

namespace App;

use App\Contracts\Resource;
use App\Relationships\Commons\BelongsToUser;
use App\Resources\ActionResource;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Action extends Model implements Resource
{
    use ActionResource;
    use BelongsToUser;

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

    /**
     * Get lazy loaded relationships of Action.
     *
     * @return array
     */
    public function getLazyRelationshipsAttribute()
    {
        return ['user'];
    }

    /**
     * @param Request $request
     * @return LengthAwarePaginator
     */
    public static function resolveModels(Request $request)
    {
        if (!$request->user('api')->is_child) {
            return self::with('user')->whereIn('user_uuid', $request->user('api')
                ->users
                ->pluck('uuid')
                ->push(
                    $request->user('api')->uuid
                )->toArray())->paginate(25);
        } else {
            return self::with('user')->where('user_uuid', $request->user('api')->uuid)->paginate(25);
        }
    }
}

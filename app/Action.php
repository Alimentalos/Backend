<?php

namespace App;

use App\Contracts\Resource;
use App\Repositories\StatusRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Http\Request;

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

    /**
     * @param Request $request
     * @return LengthAwarePaginator
     */
    public static function resolveModels(Request $request)
    {
        if (!$request->user('api')->is_child) {
            return self::whereIn('user_id', $request->user('api')
                ->users
                ->pluck('id')
                ->push(
                    $request->user('api')->id
                )->toArray())->paginate(25);
        } else {
            return self::where('user_id', $request->user('api')->id)->paginate(25);
        }
    }
}

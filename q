[1mdiff --git a/app/Access.php b/app/Access.php[m
[1mindex 7f6336e..cd7a14c 100644[m
[1m--- a/app/Access.php[m
[1m+++ b/app/Access.php[m
[36m@@ -2,8 +2,10 @@[m
 [m
 namespace App;[m
 [m
[32m+[m[32muse Illuminate\Contracts\Pagination\LengthAwarePaginator;[m
 use Illuminate\Database\Eloquent\Model;[m
 use Illuminate\Database\Eloquent\Relations\BelongsTo;[m
[32m+[m[32muse Illuminate\Http\Request;[m
 [m
 class Access extends Model[m
 {[m
[36m@@ -80,4 +82,13 @@[m [mclass Access extends Model[m
     {[m
         return $this->belongsTo(Geofence::class);[m
     }[m
[32m+[m
[32m+[m[32m    /**[m
[32m+[m[32m     * @param Request $request[m
[32m+[m[32m     * @return LengthAwarePaginator[m
[32m+[m[32m     */[m
[32m+[m[32m    public static function resolveModels(Request $request)[m
[32m+[m[32m    {[m
[32m+[m[32m        return self::with('accessible')->latest()->paginate(20);[m
[32m+[m[32m    }[m
 }[m
[1mdiff --git a/app/Action.php b/app/Action.php[m
[1mindex 8983f2b..ff662ca 100644[m
[1m--- a/app/Action.php[m
[1m+++ b/app/Action.php[m
[36m@@ -3,8 +3,11 @@[m
 namespace App;[m
 [m
 use App\Contracts\Resource;[m
[32m+[m[32muse App\Repositories\StatusRepository;[m
[32m+[m[32muse Illuminate\Contracts\Pagination\LengthAwarePaginator;[m
 use Illuminate\Database\Eloquent\Model;[m
 use Illuminate\Database\Eloquent\Relations\BelongsTo;[m
[32m+[m[32muse Illuminate\Http\Request;[m
 [m
 class Action extends Model implements Resource[m
 {[m
[36m@@ -50,4 +53,22 @@[m [mclass Action extends Model implements Resource[m
     {[m
         return ['user'];[m
     }[m
[32m+[m
[32m+[m[32m    /**[m
[32m+[m[32m     * @param Request $request[m
[32m+[m[32m     * @return LengthAwarePaginator[m
[32m+[m[32m     */[m
[32m+[m[32m    public static function resolveModels(Request $request)[m
[32m+[m[32m    {[m
[32m+[m[32m        if (!$request->user('api')->is_child) {[m
[32m+[m[32m            return self::whereIn('user_id', $request->user('api')[m
[32m+[m[32m                ->users[m
[32m+[m[32m                ->pluck('id')[m
[32m+[m[32m                ->push([m
[32m+[m[32m                    $request->user('api')->id[m
[32m+[m[32m                )->toArray())->paginate(25);[m
[32m+[m[32m        } else {[m
[32m+[m[32m            return self::where('user_id', $request->user('api')->id)->paginate(25);[m
[32m+[m[32m        }[m
[32m+[m[32m    }[m
 }[m
[1mdiff --git a/app/Alert.php b/app/Alert.php[m
[1mindex 7ec617f..01384e2 100644[m
[1m--- a/app/Alert.php[m
[1m+++ b/app/Alert.php[m
[36m@@ -3,11 +3,14 @@[m
 namespace App;[m
 [m
 use App\Contracts\Resource;[m
[32m+[m[32muse App\Repositories\StatusRepository;[m
 use Grimzy\LaravelMysqlSpatial\Eloquent\SpatialTrait;[m
[32m+[m[32muse Illuminate\Contracts\Pagination\LengthAwarePaginator;[m
 use Illuminate\Database\Eloquent\Model;[m
 use Illuminate\Database\Eloquent\Relations\BelongsTo;[m
 use Illuminate\Database\Eloquent\Relations\BelongsToMany;[m
 use Illuminate\Database\Eloquent\Relations\MorphMany;[m
[32m+[m[32muse Illuminate\Http\Request;[m
 [m
 class Alert extends Model implements Resource[m
 {[m
[36m@@ -115,4 +118,19 @@[m [mclass Alert extends Model implements Resource[m
     {[m
         return ['user', 'photo', 'alert'];[m
     }[m
[32m+[m
[32m+[m[32m    /**[m
[32m+[m[32m     * @param Request $request[m
[32m+[m[32m     * @return LengthAwarePaginator[m
[32m+[m[32m     */[m
[32m+[m[32m    public static function resolveModels(Request $request)[m
[32m+[m[32m    {[m
[32m+[m[32m        return Alert::query()[m
[32m+[m[32m            ->with('user', 'photo', 'alert')[m
[32m+[m[32m            ->whereIn([m
[32m+[m[32m                'status',[m
[32m+[m[32m                $request->has('whereInStatus') ?[m
[32m+[m[32m                    explode(',', $request->input('whereInStatus')) : StatusRepository::availableAlertStatuses() // Filter by statuses[m
[32m+[m[32m            )->latest('created_at')->paginate(25); // Order by latest[m
[32m+[m[32m    }[m
 }[m
[1mdiff --git a/app/Comment.php b/app/Comment.php[m
[1mindex 6fef8ed..3628dcc 100644[m
[1m--- a/app/Comment.php[m
[1m+++ b/app/Comment.php[m
[36m@@ -3,11 +3,14 @@[m
 namespace App;[m
 [m
 use App\Contracts\Resource;[m
[32m+[m[32muse App\Repositories\DevicesRepository;[m
 use Cog\Contracts\Love\Reactable\Models\Reactable as ReactableContract;[m
 use Cog\Laravel\Love\Reactable\Models\Traits\Reactable;[m
[32m+[m[32muse Illuminate\Contracts\Pagination\LengthAwarePaginator;[m
 use Illuminate\Database\Eloquent\Model;[m
 use Illuminate\Database\Eloquent\Relations\BelongsTo;[m
 use Illuminate\Database\Eloquent\Relations\MorphMany;[m
[32m+[m[32muse Illuminate\Http\Request;[m
 [m
 class Comment extends Model implements ReactableContract, Resource[m
 {[m
[36m@@ -72,4 +75,13 @@[m [mclass Comment extends Model implements ReactableContract, Resource[m
     {[m
         return ['commentable'];[m
     }[m
[32m+[m
[32m+[m[32m    /**[m
[32m+[m[32m     * @param Request $request[m
[32m+[m[32m     * @return LengthAwarePaginator[m
[32m+[m[32m     */[m
[32m+[m[32m    public static function resolveModels(Request $request)[m
[32m+[m[32m    {[m
[32m+[m[32m        return self::with('user')->latest()->paginate(20);[m
[32m+[m[32m    }[m
 }[m
[1mdiff --git a/app/Contracts/Resource.php b/app/Contracts/Resource.php[m
[1mindex 7201778..18070b5 100644[m
[1m--- a/app/Contracts/Resource.php[m
[1m+++ b/app/Contracts/Resource.php[m
[36m@@ -4,7 +4,11 @@[m
 namespace App\Contracts;[m
 [m
 [m
[32m+[m[32muse Illuminate\Http\Request;[m
[32m+[m
 interface Resource[m
 {[m
     public function getLazyRelationshipsAttribute();[m
[32m+[m
[32m+[m[32m    public static function resolveModels(Request $request);[m
 }[m
[1mdiff --git a/app/Device.php b/app/Device.php[m
[1mindex 6bc4017..38bf328 100644[m
[1m--- a/app/Device.php[m
[1m+++ b/app/Device.php[m
[36m@@ -3,11 +3,15 @@[m
 namespace App;[m
 [m
 use App\Contracts\Resource;[m
[32m+[m[32muse App\Http\Resources\DeviceCollection;[m
[32m+[m[32muse App\Repositories\DevicesRepository;[m
 use Grimzy\LaravelMysqlSpatial\Eloquent\SpatialTrait;[m
[32m+[m[32muse Illuminate\Contracts\Pagination\LengthAwarePaginator;[m
 use Illuminate\Database\Eloquent\Relations\BelongsTo;[m
 use Illuminate\Database\Eloquent\Relations\BelongsToMany;[m
 use Illuminate\Database\Eloquent\Relations\MorphMany;[m
 use Illuminate\Foundation\Auth\User as Authenticatable;[m
[32m+[m[32muse Illuminate\Http\Request;[m
 [m
 /**[m
  * Class Device[m
[36m@@ -145,4 +149,15 @@[m [mclass Device extends Authenticatable implements Resource[m
     {[m
         return ['user'];[m
     }[m
[32m+[m
[32m+[m[32m    /**[m
[32m+[m[32m     * @param Request $request[m
[32m+[m[32m     * @return LengthAwarePaginator[m
[32m+[m[32m     */[m
[32m+[m[32m    public static function resolveModels(Request $request)[m
[32m+[m[32m    {[m
[32m+[m[32m        $devices = DevicesRepository::fetchInDatabaseDevicesQuery();[m
[32m+[m
[32m+[m[32m        return $devices->latest()->paginate(10);[m
[32m+[m[32m    }[m
 }[m
[1mdiff --git a/app/Geofence.php b/app/Geofence.php[m
[1mindex b45d1b5..7a349f8 100644[m
[1m--- a/app/Geofence.php[m
[1m+++ b/app/Geofence.php[m
[36m@@ -6,10 +6,12 @@[m [muse App\Contracts\Resource;[m
 use Cog\Contracts\Love\Reactable\Models\Reactable as ReactableContract;[m
 use Cog\Laravel\Love\Reactable\Models\Traits\Reactable;[m
 use Grimzy\LaravelMysqlSpatial\Eloquent\SpatialTrait;[m
[32m+[m[32muse Illuminate\Contracts\Pagination\LengthAwarePaginator;[m
 use Illuminate\Database\Eloquent\Model;[m
 use Illuminate\Database\Eloquent\Relations\BelongsTo;[m
 use Illuminate\Database\Eloquent\Relations\BelongsToMany;[m
 use Illuminate\Database\Eloquent\Relations\HasMany;[m
[32m+[m[32muse Illuminate\Http\Request;[m
 [m
 class Geofence extends Model implements ReactableContract, Resource[m
 {[m
[36m@@ -164,4 +166,19 @@[m [mclass Geofence extends Model implements ReactableContract, Resource[m
     {[m
         return ['user', 'photo'];[m
     }[m
[32m+[m
[32m+[m[32m    /**[m
[32m+[m[32m     * @param Request $request[m
[32m+[m[32m     * @return LengthAwarePaginator[m
[32m+[m[32m     */[m
[32m+[m[32m    public static function resolveModels(Request $request)[m
[32m+[m[32m    {[m
[32m+[m[32m        return $request->user('api')->is_child ? Geofence::with('user', 'photo')->where([m
[32m+[m[32m            'user_id',[m
[32m+[m[32m            $request->user('api')->user_id[m
[32m+[m[32m        )->orWhere('is_public', true)->latest()->paginate(20) : Geofence::with('user', 'photo')->where([m
[32m+[m[32m            'user_id',[m
[32m+[m[32m            $request->user('api')->id[m
[32m+[m[32m        )->orWhere('is_public', true)->latest()->paginate(20);[m
[32m+[m[32m    }[m
 }[m
[1mdiff --git a/app/Group.php b/app/Group.php[m
[1mindex 6684c35..5d4e208 100644[m
[1m--- a/app/Group.php[m
[1m+++ b/app/Group.php[m
[36m@@ -3,10 +3,12 @@[m
 namespace App;[m
 [m
 use App\Contracts\Resource;[m
[32m+[m[32muse Illuminate\Contracts\Pagination\LengthAwarePaginator;[m
 use Illuminate\Database\Eloquent\Model;[m
 use Illuminate\Database\Eloquent\Relations\BelongsTo;[m
 use Illuminate\Database\Eloquent\Relations\MorphMany;[m
 use Illuminate\Database\Eloquent\Relations\MorphToMany;[m
[32m+[m[32muse Illuminate\Http\Request;[m
 [m
 class Group extends Model implements Resource[m
 {[m
[36m@@ -192,4 +194,17 @@[m [mclass Group extends Model implements Resource[m
     {[m
         return ['photo', 'user'];[m
     }[m
[32m+[m
[32m+[m[32m    /**[m
[32m+[m[32m     * @param Request $request[m
[32m+[m[32m     * @return LengthAwarePaginator[m
[32m+[m[32m     */[m
[32m+[m[32m    public static function resolveModels(Request $request)[m
[32m+[m[32m    {[m
[32m+[m[32m        return ([m
[32m+[m[32m        $request->user('api')->is_admin ?[m
[32m+[m[32m            self::with('user', 'photo') :[m
[32m+[m[32m            self::with('user', 'photo')->where('user_id', $request->user('api')->id)[m
[32m+[m[32m        )->latest()->paginate(25);[m
[32m+[m[32m    }[m
 }[m
[1mdiff --git a/app/Location.php b/app/Location.php[m
[1mindex 99ad921..58596f3 100644[m
[1m--- a/app/Location.php[m
[1m+++ b/app/Location.php[m
[36m@@ -3,9 +3,14 @@[m
 namespace App;[m
 [m
 use App\Contracts\Resource;[m
[32m+[m[32muse App\Repositories\HandleBindingRepository;[m
[32m+[m[32muse App\Repositories\LocationRepository;[m
 use Grimzy\LaravelMysqlSpatial\Eloquent\SpatialTrait;[m
[32m+[m[32muse Illuminate\Contracts\Pagination\LengthAwarePaginator;[m
 use Illuminate\Database\Eloquent\Model;[m
 use Illuminate\Database\Eloquent\Relations\BelongsTo;[m
[32m+[m[32muse Illuminate\Http\Request;[m
[32m+[m[32muse Illuminate\Support\Collection;[m
 [m
 class Location extends Model implements Resource[m
 {[m
[36m@@ -90,4 +95,21 @@[m [mclass Location extends Model implements Resource[m
     {[m
         return ['trackable'];[m
     }[m
[32m+[m
[32m+[m[32m    /**[m
[32m+[m[32m     * @param Request $request[m
[32m+[m[32m     * @return Collection[m
[32m+[m[32m     */[m
[32m+[m[32m    public static function resolveModels(Request $request)[m
[32m+[m[32m    {[m
[32m+[m[32m        $models = HandleBindingRepository::bindResourceModelClass($request->input('type'))::whereIn([m
[32m+[m[32m            'uuid',[m
[32m+[m[32m            explode(',', $request->input('identifiers'))[m
[32m+[m[32m        )->get();[m
[32m+[m
[32m+[m[32m        return LocationRepository::searchLocations( // Search locations[m
[32m+[m[32m            $models, // of those devices[m
[32m+[m[32m            $request->only('type', 'start_date', 'end_date', 'accuracy')[m
[32m+[m[32m        );[m
[32m+[m[32m    }[m
 }[m
[1mdiff --git a/app/Pet.php b/app/Pet.php[m
[1mindex 979fe10..e785f1f 100644[m
[1m--- a/app/Pet.php[m
[1m+++ b/app/Pet.php[m
[36m@@ -6,10 +6,12 @@[m [muse App\Contracts\Resource;[m
 use Cog\Contracts\Love\Reactable\Models\Reactable as ReactableContract;[m
 use Cog\Laravel\Love\Reactable\Models\Traits\Reactable;[m
 use Grimzy\LaravelMysqlSpatial\Eloquent\SpatialTrait;[m
[32m+[m[32muse Illuminate\Contracts\Pagination\LengthAwarePaginator;[m
 use Illuminate\Database\Eloquent\Relations\BelongsTo;[m
 use Illuminate\Database\Eloquent\Relations\BelongsToMany;[m
 use Illuminate\Database\Eloquent\Relations\MorphMany;[m
 use Illuminate\Foundation\Auth\User as Authenticatable;[m
[32m+[m[32muse Illuminate\Http\Request;[m
 [m
 class Pet extends Authenticatable implements ReactableContract, Resource[m
 {[m
[36m@@ -178,4 +180,13 @@[m [mclass Pet extends Authenticatable implements ReactableContract, Resource[m
     {[m
         return ['photo', 'user'];[m
     }[m
[32m+[m
[32m+[m[32m    /**[m
[32m+[m[32m     * @param Request $request[m
[32m+[m[32m     * @return LengthAwarePaginator[m
[32m+[m[32m     */[m
[32m+[m[32m    public static function resolveModels(Request $request)[m
[32m+[m[32m    {[m
[32m+[m[32m        return self::with('user', 'photo')->latest()->paginate(20);[m
[32m+[m[32m    }[m
 }[m
[1mdiff --git a/app/Photo.php b/app/Photo.php[m
[1mindex 925138a..c513c9e 100644[m
[1m--- a/app/Photo.php[m
[1m+++ b/app/Photo.php[m
[36m@@ -6,10 +6,12 @@[m [muse App\Contracts\Resource;[m
 use Cog\Contracts\Love\Reactable\Models\Reactable as ReactableContract;[m
 use Cog\Laravel\Love\Reactable\Models\Traits\Reactable;[m
 use Grimzy\LaravelMysqlSpatial\Eloquent\SpatialTrait;[m
[32m+[m[32muse Illuminate\Contracts\Pagination\LengthAwarePaginator;[m
 use Illuminate\Database\Eloquent\Model;[m
 use Illuminate\Database\Eloquent\Relations\BelongsTo;[m
 use Illuminate\Database\Eloquent\Relations\BelongsToMany;[m
 use Illuminate\Database\Eloquent\Relations\MorphMany;[m
[32m+[m[32muse Illuminate\Http\Request;[m
 [m
 class Photo extends Model implements ReactableContract, Resource[m
 {[m
[36m@@ -156,4 +158,13 @@[m [mclass Photo extends Model implements ReactableContract, Resource[m
     {[m
         return ['user'];[m
     }[m
[32m+[m
[32m+[m[32m    /**[m
[32m+[m[32m     * @param Request $request[m
[32m+[m[32m     * @return LengthAwarePaginator[m
[32m+[m[32m     */[m
[32m+[m[32m    public static function resolveModels(Request $request)[m
[32m+[m[32m    {[m
[32m+[m[32m        return self::with('user', 'photoable')->latest()->paginate(20);[m
[32m+[m[32m    }[m
 }[m
[1mdiff --git a/app/User.php b/app/User.php[m
[1mindex ccc82fc..3c34e76 100644[m
[1m--- a/app/User.php[m
[1m+++ b/app/User.php[m
[36m@@ -10,11 +10,13 @@[m [muse Cog\Laravel\Love\Reactable\Models\Traits\Reactable;[m
 use Cog\Laravel\Love\Reacterable\Models\Traits\Reacterable;[m
 use Grimzy\LaravelMysqlSpatial\Eloquent\SpatialTrait;[m
 use Illuminate\Contracts\Auth\MustVerifyEmail;[m
[32m+[m[32muse Illuminate\Contracts\Pagination\LengthAwarePaginator;[m
 use Illuminate\Database\Eloquent\Relations\BelongsTo;[m
 use Illuminate\Database\Eloquent\Relations\BelongsToMany;[m
 use Illuminate\Database\Eloquent\Relations\HasMany;[m
 use Illuminate\Database\Eloquent\Relations\MorphMany;[m
 use Illuminate\Foundation\Auth\User as Authenticatable;[m
[32m+[m[32muse Illuminate\Http\Request;[m
 use Illuminate\Notifications\Notifiable;[m
 [m
 class User extends Authenticatable implements MustVerifyEmail, ReacterableContract, ReactableContract, Resource[m
[36m@@ -256,4 +258,27 @@[m [mclass User extends Authenticatable implements MustVerifyEmail, ReacterableContra[m
     {[m
         return ['photo', 'user'];[m
     }[m
[32m+[m
[32m+[m[32m    /**[m
[32m+[m[32m     * @param Request $request[m
[32m+[m[32m     * @return LengthAwarePaginator[m
[32m+[m[32m     */[m
[32m+[m[32m    public static function resolveModels(Request $request)[m
[32m+[m[32m    {[m
[32m+[m[32m        if (!is_null($request->user('api')->user_id)) {[m
[32m+[m[32m            return self::with('photo', 'user')->latest()->where([[m
[32m+[m[32m                ['user_id', $request->user('api')->user_id][m
[32m+[m[32m            ])->orWhere([[m
[32m+[m[32m                ['id', $request->user('api')->user_id][m
[32m+[m[32m            ])->paginate(20);[m
[32m+[m[32m        } elseif ($request->user('api')->is_admin) {[m
[32m+[m[32m            return self::with('photo', 'user')->latest()->paginate(20);[m
[32m+[m[32m        } else {[m
[32m+[m[32m            return self::with('photo', 'user')->latest()->where([[m
[32m+[m[32m                ['user_id', $request->user()->id][m
[32m+[m[32m            ])->orWhere([[m
[32m+[m[32m                ['id', $request->user('api')->id][m
[32m+[m[32m            ])->paginate(20);[m
[32m+[m[32m        }[m
[32m+[m[32m    }[m
 }[m

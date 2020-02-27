<?php

namespace App\Http\Controllers\Api\Geofences;

use App\Geofence;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Geofences\StoreRequest;
use App\Repositories\PhotoRepository;
use App\Repositories\UniqueNameRepository;
use Grimzy\LaravelMysqlSpatial\Types\LineString;
use Grimzy\LaravelMysqlSpatial\Types\Point;
use Grimzy\LaravelMysqlSpatial\Types\Polygon;
use Illuminate\Http\JsonResponse;

class StoreController extends Controller
{
    /**
     * @param StoreRequest $request
     * @return JsonResponse
     */
    public function __invoke(StoreRequest $request)
    {
        // TODO - Remove unnecessary complexity
        $photo = PhotoRepository::createPhoto(
            $request->user('api'),
            $request->file('photo'),
            null,
            null,
            $request->input('is_public'),
            $request->input('coordinates')
        );

        // TODO - Remove unnecessary complexity
        $geofence = new Geofence();
        $geofence->uuid = UniqueNameRepository::createIdentifier();
        $geofence->photo_id = $photo->id;
        $geofence->name = $request->input('name');
        $geofence->user_id = $request->user('api')->id;
        $geofence->photo_url = 'https://storage.googleapis.com/photos.zendev.cl/photos/' . $photo->photo_url;

        $shape = array_map(function ($element) {
            return new Point($element['latitude'], $element['longitude']);
        }, $request->input('shape'));
        $geofence->shape = new Polygon([new LineString($shape)]);
        $geofence->is_public = $request->input('is_public');
        $geofence->save();
        $geofence->load('photo', 'user');


        $photo->geofences()->attach($geofence->id);

        return response()->json(
            $geofence,
            200
        );
    }
}

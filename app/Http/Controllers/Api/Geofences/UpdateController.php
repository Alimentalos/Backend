<?php

namespace App\Http\Controllers\Api\Geofences;

use App\Geofence;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Geofences\UpdateRequest;
use App\Repositories\FillRepository;
use App\Repositories\PhotoRepository;
use Grimzy\LaravelMysqlSpatial\Types\LineString;
use Grimzy\LaravelMysqlSpatial\Types\Point;
use Grimzy\LaravelMysqlSpatial\Types\Polygon;
use Illuminate\Http\JsonResponse;

class UpdateController extends Controller
{
    /**
     * @param UpdateRequest $request
     * @param Geofence $geofence
     * @return JsonResponse
     */
    public function __invoke(UpdateRequest $request, Geofence $geofence)
    {
        // TODO - Remove unnecessary complexity
        if ($request->has('photo')) {
            $photo = PhotoRepository::createPhoto(
                $request->user('api'),
                $request->file('photo'),
                null,
                null,
                FillRepository::fillMethod($request, 'is_public', $geofence->is_public),
                $request->input('coordinates')
            );

            $geofence->update([
                'photo_url' => 'https://storage.googleapis.com/photos.zendev.cl/photos/' . $photo->photo_url,
                'photo_id' => $photo->id
            ]);

            $geofence->photos()->attach($photo->id);
        }

        $geofence->load('photo', 'user');

        $geofence->name = FillRepository::fillMethod($request, 'name', $geofence->name);
        $shape = array_map(function ($element) {
            return new Point($element['latitude'], $element['longitude']);
        }, $request->input('shape'));
        $geofence->shape = new Polygon([new LineString($shape)]);
        $geofence->is_public = FillRepository::fillMethod($request, 'is_public', $geofence->is_public);
        $geofence->save();
        return response()->json(
            $geofence,
            200
        );
    }
}

<?php

namespace App\Repositories;

use App\Photo;
use App\User;
use Exception;
use Grimzy\LaravelMysqlSpatial\Types\Point;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PhotoRepository
{
    /**
     * Default photo disk path.
     */
    public const DEFAULT_PHOTOS_DISK_PATH = 'photos/';

    /**
     * Default disk.
     */
    public const DEFAULT_DISK = 'gcs';

    /**
     * Create photo via request.
     *
     * @param $request
     * @return Photo
     * @throws Exception
     */
    public static function createPhotoViaRequest(Request $request)
    {
        $photo = static::createPhotoUsingRequest($request);
        static::createDefaultPhotoCommentUsingRequest($photo, $request);
        static::storePhoto($photo->uuid, $request->file('photo'));
        return $photo;
    }

    /**
     * Create photo instance using request.
     *
     * @param $request
     * @return mixed
     * @throws Exception
     */
    public static function createPhotoUsingRequest($request)
    {
        $photoUniqueName = UniqueNameRepository::createIdentifier();
        return Photo::create([
            'user_id' => $request->user('api')->id,
            'uuid' => $photoUniqueName,
            'photo_url' => $photoUniqueName . $request->file('photo')->extension(),
            'ext' => $request->file('photo')->extension(),
            'is_public' => $request->has('is_public'),
            'location' => LocationRepository::parsePointFromCoordinates($request->input('coordinates'))
        ]);
    }

    /**
     * Create default photo comment using request.
     *
     * @param Photo $photo
     * @param Request $request
     * @throws Exception
     */
    public static function createDefaultPhotoCommentUsingRequest(Photo $photo, Request $request)
    {
        $comment = $photo->comments()->create([
            'uuid' => UniqueNameRepository::createIdentifier(),
            'user_id' => $request->user('api')->id,
            'title' => $request->input('title'),
            'body' => $request->input('body'),
            'is_public' => $request->has('is_public'),
        ]);
        $photo->comment()->associate($comment);
    }


    /**
     * Store photo.
     *
     * @param $uniqueName
     * @param $fileContent
     */
    public static function storePhoto($uniqueName, $fileContent)
    {
        Storage::disk(static::DEFAULT_DISK)
            ->putFileAs(
                static::DEFAULT_PHOTOS_DISK_PATH,
                $fileContent,
                ($uniqueName . $fileContent->extension())
            );
    }
}

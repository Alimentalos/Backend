<?php

namespace App\Repositories;

use App\Photo;
use Exception;
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
     * Update photo via request.
     *
     * @param Request $request
     * @param Photo $photo
     * @return Photo
     */
    public static function updatePhotoViaRequest(Request $request, Photo $photo)
    {
        $photo->update([
            'title' => FillRepository::fillMethod($request, 'title', $photo->title),
            'description' => FillRepository::fillMethod($request, 'description', $photo->description),
            'is_public' => FillRepository::fillMethod($request, 'is_public', $photo->is_public),
        ]);

        $photo->load('user');
        return $photo;
    }

    /**
     * Create photo via request.
     *
     * @param $request
     * @return Photo
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
     */
    public static function createPhotoUsingRequest(Request $request)
    {
        $photoUniqueName = UniqueNameRepository::createIdentifier();
        $photo = Photo::create([
            'user_uuid' => $request->user('api')->uuid,
            'uuid' => $photoUniqueName,
            'photo_url' => $photoUniqueName . $request->file('photo')->extension(),
            'ext' => $request->file('photo')->extension(),
            'is_public' => $request->has('is_public'),
            'location' => LocationRepository::parsePointFromCoordinates($request->input('coordinates'))
        ]);
        $photo->load('user');
        return $photo;
    }

    /**
     * Create default photo comment using request.
     *
     * @param Photo $photo
     * @param Request $request
     */
    public static function createDefaultPhotoCommentUsingRequest(Photo $photo, Request $request)
    {
        $comment = $photo->comments()->create([
            'uuid' => UniqueNameRepository::createIdentifier(),
            'user_uuid' => $request->user('api')->uuid,
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

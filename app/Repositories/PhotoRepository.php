<?php

namespace App\Repositories;

use App\Photo;
use App\User;
use Grimzy\LaravelMysqlSpatial\Types\Point;
use Illuminate\Support\Facades\Storage;

class PhotoRepository
{
    public const DEFAULT_PHOTOS_DISK_PATH = 'photos/';
    public const DEFAULT_DISK = 'gcs';

    /**
     * @param User $user
     * @param $fileContent
     * @param $title
     * @param null $body
     * @param bool $is_public
     * @return Photo
     */
    public static function createPhoto(User $user, $fileContent, $title = null, $body = null, $is_public = false, $coordinates)
    {
        $photoUniqueName = UniqueNameRepository::createIdentifier();
        $commentUniqueName = UniqueNameRepository::createIdentifier();
        $exploded = explode(',', $coordinates);
        $photo = Photo::create([
            'user_id' => $user->id,
            'uuid' => $photoUniqueName,
            'photo_url' => $photoUniqueName . $fileContent->extension(),
            'ext' => $fileContent->extension(),
            'is_public' => $is_public,
            'location' => (new Point(
                floatval($exploded[0]),
                floatval($exploded[1])
            ))
        ]);
        $comment = $photo->comments()->create([
            'uuid' => $commentUniqueName,
            'user_id' => $user->id,
            'title' => $title,
            'body' => $body,
            'is_public' => $is_public,
        ]);
        $photo->comment()->associate($comment);
        static::storePhoto($photoUniqueName, $fileContent);
        return $photo;
    }

    /**
     * @param $request
     * @return Photo
     */
    public static function createPhotoViaRequest($request)
    {
        $photoUniqueName = UniqueNameRepository::createIdentifier();
        $commentUniqueName = UniqueNameRepository::createIdentifier();
        $exploded = explode(',', $request->input('coordinates'));
        $photo = Photo::create([
            'user_id' => $request->user('api')->id,
            'uuid' => $photoUniqueName,
            'photo_url' => $photoUniqueName . $request->file('photo')->extension(),
            'ext' => $request->file('photo')->extension(),
            'is_public' => $request->has('is_public'),
            'location' => (new Point(
                floatval($exploded[0]),
                floatval($exploded[1])
            ))
        ]);
        $comment = $photo->comments()->create([
            'uuid' => $commentUniqueName,
            'user_id' => $request->user('api')->id,
            'title' => $request->input('title'),
            'body' => $request->input('body'),
            'is_public' => $request->has('is_public'),
        ]);
        $photo->comment()->associate($comment);
        static::storePhoto($photoUniqueName, $request->file('photo'));
        return $photo;
    }


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

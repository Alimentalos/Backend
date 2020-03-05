<?php

namespace App\Repositories;

use App\Photo;
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
     * @param Photo $photo
     * @return Photo
     */
    public function updatePhotoViaRequest(Photo $photo)
    {
        $photo->update(parameters()->fillPropertiesUsingResource(['title', 'description', 'is_public'], $photo));
        $photo->load('user');
        return $photo;
    }

    /**
     * Create photo via request.
     *
     * @return Photo
     */
    public function createPhotoViaRequest()
    {
        $photo = $this->createPhotoUsingRequest();
        $this->createDefaultPhotoCommentUsingRequest($photo);
        $this->storePhoto($photo->uuid, request()->file('photo'));
        return $photo;
    }

    /**
     * Create photo instance using request.
     *
     * @return mixed
     */
    public function createPhotoUsingRequest()
    {
        $photoUniqueName = UniqueNameRepository::createIdentifier();
        $photo = Photo::create([
            'user_uuid' => authenticated()->uuid,
            'uuid' => $photoUniqueName,
            'photo_url' => $photoUniqueName . request()->file('photo')->extension(),
            'ext' => request()->file('photo')->extension(),
            'is_public' => FillRepository::fillAttribute('is_public', true),
            'location' => parser()->pointFromCoordinates(input('coordinates'))
        ]);
        $photo->load('user');
        return $photo;
    }

    /**
     * Create default photo comment using request.
     *
     * @param Photo $photo
     */
    public function createDefaultPhotoCommentUsingRequest(Photo $photo)
    {
        $comment = $photo->comments()->create(array_merge([
            'uuid' => UniqueNameRepository::createIdentifier(),
            'user_uuid' => authenticated()->uuid,
        ], only('title', 'body', 'is_public')));
        $photo->comment()->associate($comment);
    }


    /**
     * Store photo.
     *
     * @param $uniqueName
     * @param $fileContent
     */
    public function storePhoto($uniqueName, $fileContent)
    {
        Storage::disk(static::DEFAULT_DISK)
            ->putFileAs(
                static::DEFAULT_PHOTOS_DISK_PATH,
                $fileContent,
                ($uniqueName . $fileContent->extension())
            );
    }
}

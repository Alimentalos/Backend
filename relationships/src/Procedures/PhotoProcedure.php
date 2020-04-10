<?php

namespace Alimentalos\Relationships\Procedures;

use Alimentalos\Relationships\Models\Photo;
use Illuminate\Support\Facades\Storage;

trait PhotoProcedure
{
    /**
     * Create photo.
     *
     * @return Photo
     */
    public function createInstance()
    {
        $photo_uuid = uuid();
        $photo = Photo::create([
            'user_uuid' => authenticated()->uuid,
            'uuid' => $photo_uuid,
            'photo_url' => 'photos/' . $photo_uuid . '.' . uploaded('photo')->extension(),
            'ext' => uploaded('photo')->extension(),
            'is_public' => fill('is_public', true),
            'title' => fill('title', null),
            'body' => fill('body', null),
            'location' => parser()->pointFromCoordinates(input('coordinates'))
        ]);
        return $photo;
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
                ($uniqueName . '.' . $fileContent->extension())
            );
    }
}

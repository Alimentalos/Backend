<?php


namespace App\Procedures;


use App\Photo;
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
            'photo_url' => $photo_uuid . uploaded('photo')->extension(),
            'ext' => uploaded('photo')->extension(),
            'is_public' => fill('is_public', true),
            'location' => parser()->pointFromCoordinates(input('coordinates'))
        ]);
        $photo->load('user');
        return $photo;
    }

    /**
     * Create default comment of photo.
     *
     * @param Photo $photo
     */
    public function createComment(Photo $photo)
    {
        $comment = $photo->comments()->create(array_merge([
            'uuid' => uuid(),
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

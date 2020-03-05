<?php

namespace App\Resources;

use App\Photo;
use App\Repositories\PhotoRepository;
use App\Rules\Coordinate;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;

trait PhotoResource
{
    /**
     * Update photo via request.
     *
     * @return Photo
     */
    public function updateViaRequest()
    {
        return photos()->updatePhotoViaRequest($this);
    }

    /**
     * Get available photo reactions.
     *
     * @return string
     */
    public function getAvailableReactions()
    {
        return 'Love,Pray,Like,Dislike,Sad,Hate';
    }

    /**
     * Update photo validation rules.
     *
     * @return array
     */
    public function updateRules()
    {
        return [];
    }

    /**
     * Store photo validation rules.
     *
     * @return array
     */
    public function storeRules()
    {
        return [
            'photo' => 'required',
            'is_public' => 'required|boolean',
            'coordinates' => ['required', new Coordinate()],
        ];
    }

    /**
     * Get photo relationships using lazy loading.
     *
     * @return array
     */
    public function getLazyRelationshipsAttribute()
    {
        return ['user'];
    }

    /**
     * Get photo instances.
     *
     * @return LengthAwarePaginator
     */
    public function getInstances()
    {
        return Photo::with('user', 'photoable')->latest()->paginate(20);
    }
}

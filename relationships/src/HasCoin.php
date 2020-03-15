<?php


namespace Demency\Relationships;

use App\Coin;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait HasCoin
{
    /**
     * Get group coins.
     *
     * @return MorphMany
     */
    public function coins()
    {
        return $this->morphMany(Coin::class,'monetizer','monetizer_type','monetizer_id','uuid');
    }
}

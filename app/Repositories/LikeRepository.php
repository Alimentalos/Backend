<?php

namespace App\Repositories;

use Cog\Laravel\Love\ReactionType\Models\ReactionType;

class LikeRepository
{
    public static function generateStats($reactant, $reacterable)
    {
        return [
            'reactable' => [
                'like' => static::reacted($reacterable, $reactant, 'Like'),
                'pray' => static::reacted($reacterable, $reactant, 'Pray'),
                'love' => static::reacted($reacterable, $reactant, 'Love'),
                'hate' => static::reacted($reacterable, $reactant, 'Hate'),
                'dislike' => static::reacted($reacterable, $reactant, 'Dislike'),
                'sad' => static::reacted($reacterable, $reactant, 'Sad'),
            ],
            'reactant' => $reactant->getReactionCounters()
        ];
    }

    public static function generateFollowStats($reactant, $reacterable)
    {
        return [
            'reactable' => [
                'follow' => static::reacted($reacterable, $reactant, 'Follow'),
            ],
            'reactant' => $reactant->getReactionCounters()
        ];
    }

    public static function updateLike($reactant, $reacterable, $type)
    {
        if (
            $reacterable->hasReactedTo(
                $reactant,
                ReactionType::fromName(
                    $type
                )
            )
        ) {
            $reacterable->unreactTo($reactant, ReactionType::fromName($type));
        } else {
            $reacterable->reactTo($reactant, ReactionType::fromName($type));
        }
    }

    /**
     * Check if reactant was reacted by reacterable (comment liked by user)
     * @param $reacterable
     * @param $reactant
     * @param $name
     * @return boolean
     */
    public static function reacted($reacterable, $reactant, $name)
    {
        return $reacterable->hasReactedTo($reactant, ReactionType::fromName($name));
    }
}

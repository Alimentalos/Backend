<?php


namespace App\Tools;

use Cog\Contracts\Love\Reacterable\Models\Reacterable;
use Cog\Laravel\Love\Reactant\Models\Reactant;
use Cog\Laravel\Love\ReactionType\Models\ReactionType;

class Liker
{
    /**
     * Generate stats.
     *
     * @param $reactant
     * @param $reacterable
     * @return array
     */
    public function stats($reactant, $reacterable)
    {
        return [
            'reactable' => [
                'like' => $this->reacted($reacterable, $reactant, 'Like'),
                'pray' => $this->reacted($reacterable, $reactant, 'Pray'),
                'love' => $this->reacted($reacterable, $reactant, 'Love'),
                'hate' => $this->reacted($reacterable, $reactant, 'Hate'),
                'dislike' => $this->reacted($reacterable, $reactant, 'Dislike'),
                'sad' => $this->reacted($reacterable, $reactant, 'Sad'),
            ],
            'reactant' => $reactant->getReactionCounters()
        ];
    }

    /**
     * Generate follow stats.
     *
     * @param $reactant
     * @param $reacterable
     * @return array
     */
    public function followStats($reactant, $reacterable)
    {
        return [
            'reactable' => [
                'follow' => $this->reacted($reacterable, $reactant, 'Follow'),
            ],
            'reactant' => $reactant->getReactionCounters()
        ];
    }

    /**
     * Update likes stat.
     *
     * @param $reactant
     * @param $reacterable
     * @param string $type
     */
    public function update($reactant, $reacterable, string $type)
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
     *
     * @param Reacterable $reacterable
     * @param Reactant $reactant
     * @param $name
     * @return boolean
     */
    public function reacted($reacterable, $reactant, string $name)
    {
        return $reacterable->hasReactedTo($reactant, ReactionType::fromName($name));
    }
}

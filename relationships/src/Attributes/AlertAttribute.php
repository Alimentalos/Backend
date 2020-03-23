<?php


namespace Alimentalos\Relationships\Attributes;


trait AlertAttribute
{
    /**
     * Lost type.
     */
    public $lost = 0;

    /**
     * Dead type.
     */
    public $dead = -1;

    /**
     * Found type.
     */
    public $found = 1;

    /**
     * Available alert types.
     *
     * @return array
     */
    public function types()
    {
        return [
            $this->lost,
            $this->dead,
            $this->found,
        ];
    }
}

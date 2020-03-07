<?php


namespace App\Attributes;


trait AlertAttribute
{
    /**
     * Lost type.
     */
    public int $lost = 0;

    /**
     * Dead type.
     */
    public int $dead = -1;

    /**
     * Found type.
     */
    public int $found = 1;

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

    /**
     * Get available alert types.
     *
     * @return array
     */
    public function alertTypes()
    {
        return [
            'App\\User',
            'App\\Device',
            'App\\Pet',
        ];
    }
}

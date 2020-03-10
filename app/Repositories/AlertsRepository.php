<?php


namespace App\Repositories;

use App\Alert;
use App\Attributes\AlertAttribute;
use App\Lists\AlertList;
use App\Procedures\AlertProcedure;

class AlertsRepository
{
    use AlertList;
    use AlertProcedure;
    use AlertAttribute;

    /**
     * Create alert.
     *
     * @return Alert
     */
    public function create()
    {
        return $this->createInstance();
    }

    /**
     * Update alert.
     *
     * @param Alert $alert
     * @return Alert
     */
    public function update(Alert $alert)
    {
        upload()->check($alert);
        $alert->update(parameters()->fill(['type', 'status', 'title', 'body'], $alert));
        return $alert;
    }
}

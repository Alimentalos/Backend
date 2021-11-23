<?php


namespace App\Repositories;

use Alimentalos\Relationships\Attributes\AlertAttribute;
use Alimentalos\Relationships\Lists\AlertList;
use App\Models\Alert;
use Alimentalos\Relationships\Procedures\AlertProcedure;

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
        upload()->checkPhoto($alert);
        $alert->update(parameters()->fill(['type', 'status', 'title', 'body'], $alert));
        return $alert;
    }
}

<?php


namespace Alimentalos\Relationships\Repositories;

use Alimentalos\Relationships\Models\Alert;
use Alimentalos\Relationships\Attributes\AlertAttribute;
use Alimentalos\Relationships\Lists\AlertList;
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
        upload()->check($alert);
        $alert->update(parameters()->fill(['type', 'status', 'title', 'body'], $alert));
        return $alert;
    }
}

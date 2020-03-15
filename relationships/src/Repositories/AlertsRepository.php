<?php


namespace Demency\Relationships\Repositories;

use App\Alert;
use Demency\Relationships\Attributes\AlertAttribute;
use Demency\Relationships\Lists\AlertList;
use Demency\Relationships\Procedures\AlertProcedure;

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

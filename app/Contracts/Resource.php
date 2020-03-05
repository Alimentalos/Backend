<?php

namespace App\Contracts;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

interface Resource
{
    public function getLazyRelationshipsAttribute();

    /**
     * @param Request $request
     * @return array|LengthAwarePaginator
     */
    public function getInstances(Request $request);

    /**
     * Get available reactions.
     *
     * @return array
     */
    public function getAvailableReactions();

    /**
     * Get store validation rules.
     *
     * @param Request $request
     * @return array
     */
    public function storeRules(Request $request);

    /**
     * Get update validation rules.
     *
     * @param Request $request
     * @return array
     */
    public function updateRules(Request $request);
}

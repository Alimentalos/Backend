<?php


namespace App\Contracts;


use Illuminate\Http\Request;

interface Resource
{
    public function getLazyRelationshipsAttribute();

    public static function resolveModels(Request $request);

    public function getAvailableReactions();

    /**
     * @param Request $request
     * @return array
     */
    public function storeRules(Request $request);

    /**
     * @param Request $request
     * @return array
     */
    public function updateRules(Request $request);
}

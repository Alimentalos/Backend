<?php


namespace App\Contracts;


use Illuminate\Http\Request;

interface Resource
{
    public function getLazyRelationshipsAttribute();

    public static function resolveModels(Request $request);
}

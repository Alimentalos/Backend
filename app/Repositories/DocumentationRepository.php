<?php


namespace App\Repositories;


class DocumentationRepository
{
    /**
     * @param $name
     * @param $page
     * @return mixed|string
     * @codeCoverageIgnore
     */
    public static function next($name, $page)
    {
        $arrayed = array_values(config('documentation')[$name]);
        $currentPos = array_keys(array_filter($arrayed, function($element) use ($name, $page) {
            return $element === config('documentation')[$name][$page];
        }))[0];

        if (array_key_exists(($currentPos + 1), $arrayed)) {
            return array_keys(config('documentation')[$name])[($currentPos + 1)];
        }
        return 'Nothing';
    }

    /**
     * @param $name
     * @param $page
     * @return mixed|string
     * @codeCoverageIgnore
     */
    public static function recommend($name, $page)
    {
        $arrayed = array_values(config('documentation'));
        $currentPos = array_keys(array_filter($arrayed, function($element) use ($name) {
            return $element === config('documentation')[$name];
        }))[0];

        if (array_key_exists(($currentPos + 1), $arrayed)) {
            return array_keys(config('documentation'))[($currentPos + 1)];
        }
        return 'Nothing';
    }

    /**
     * @param $name
     * @param $page
     * @return mixed|string
     * @codeCoverageIgnore
     */
    public static function before($name, $page)
    {
        $arrayed = array_values(config('documentation')[$name]);
        $currentPos = array_keys(array_filter($arrayed, function($element) use ($name, $page) {
            return $element === config('documentation')[$name][$page];
        }))[0];

        if (array_key_exists(($currentPos - 1), $arrayed)) {
            return array_keys(config('documentation')[$name])[($currentPos - 1)];
        }
        return 'Nothing';
    }
}

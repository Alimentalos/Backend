<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\Factory;
use Illuminate\View\View;

class AboutController extends Controller
{
    /**
     * Get about page.
     *
     * @return Factory|View
     */
    public function index()
    {
        return view('about.index');
    }

    /**
     * Get specific about child page.
     *
     * @param $name
     * @return Factory|View
     */
    public function show($name)
    {
        $name = str_replace('-', ' ', ucfirst($name));
        if (!array_key_exists($name, config('documentation'))) {
            abort(404);
        }
        return view('about.show')->with('name', $name);
    }
}

<?php

namespace App\Http\Controllers;

class AboutController extends Controller
{
    public function index()
    {
        return view('about.index');
    }

    public function show($name)
    {
        $name = str_replace('-', ' ', ucfirst($name));
        if (!array_key_exists($name, config('documentation'))) {
            abort(404);
        }
        return view('about.show')->with('name', $name);
    }
}

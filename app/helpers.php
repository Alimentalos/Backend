<?php

if (! function_exists('binder')) {
    function binder() {
        return resolve(\App\Repositories\HandleBindingRepository::class);
    }
}

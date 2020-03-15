@extends('layouts.app')

@section('content')
    <div class="container">

        <a href="/about">{{ __('About') }}</a> &mdash; <a href="/about/{{ $base }}">{{ __($name) }}</a> &mdash; {{ __($page) }}

        @component('components.doc', ['data' => config('documentation')[$name][$page]])
        @endcomponent
    </div>
@endsection

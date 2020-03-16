@extends('layouts.app')

@section('content')
    <div class="container">

        <div class="row justify-content-center mb-4">
            <div class="col-md-8 col-sm-12 mt-4">
                <h2 class="text-left mt-4"><i class="fal fa-scroll mr-3"></i> {{ __($page) }}</h2>
            </div>
        </div>
        <div class="row justify-content-center mb-4">
            <div class="col-md-8 col-sm-12 mt-4 h6">
                <a href="/about">{{ __('About') }}</a> &mdash;
                <a href="/about/{{ $base }}">{{ __($name) }}</a>
            </div>
        </div>
        @component('components.doc', ['data' => config('documentation')[$name][$page]])
        @endcomponent

        <div class="row justify-content-center mb-4">
            <div class="col-md-4 col-sm-6 mt-4">
                <small>{{ __('Before page') }}</small>
                <br>
                @if(\App\Repositories\DocumentationRepository::before($name, $page) !== 'Nothing')
                <a href="/about/{{ $base }}/{{ strtolower(str_replace(' ', '-', \App\Repositories\DocumentationRepository::before($name, $page))) }}">{{ __(\App\Repositories\DocumentationRepository::before($name, $page)) }}</a>
                @else
                    {{ __('Nothing') }}
                @endif
            </div>
            <div class="col-md-4 col-sm-6 mt-4 text-right">
                @if(\App\Repositories\DocumentationRepository::next($name, $page) !== 'Nothing')
                    <small>{{ __('Next page') }}</small>
                    <br>
                    <a href="/about/{{ $base }}/{{ strtolower(str_replace(' ', '-', \App\Repositories\DocumentationRepository::next($name, $page))) }}">{{ __(\App\Repositories\DocumentationRepository::next($name, $page)) }}</a>
                @else
                    @if(\App\Repositories\DocumentationRepository::recommend($name, $page) !== 'Nothing')
                        <small>{{ __('Recommended') }}</small>
                        <br>
                        <a href="/about/{{ strtolower(str_replace(' ', '-', \App\Repositories\DocumentationRepository::recommend($name, $page))) }}">{{ __(\App\Repositories\DocumentationRepository::recommend($name, $page)) }}</a>
                    @endif
                @endif
            </div>
        </div>
    </div>
@endsection

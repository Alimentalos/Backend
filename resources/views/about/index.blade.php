@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 mt-4">
                <h2><i class="fal fa-book-alt mr-3"></i> {{__('About')}}</h2>
                <p class="mt-4">{{ __('Explore the knowledge center of Alimentalos') }}.</p>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="h5 mb-5 mt-4">{{ __('Project documentation') }}</div>
                <div class="card">
                    <div class="card-body p-4">
                        @component('components.image', ['src' => '/svg/docs/johnny_automatic_two_mushrooms.svg'])
                        @endcomponent
                        <p>{{ __('Get information about the problem, its actors and the terminology.') }}</p>
                        <a href="/about/project" class="btn btn-md btn-primary" role="button" aria-pressed="true">{{ __('Table of contents') }}</a>
                        <hr>
                        <a href="/about/project/introduction" class="btn btn-md btn-secondary" role="button" aria-pressed="true">{{ __('Introduction') }}</a>
                        <a href="/about/project/problem-and-solution" class="btn btn-md btn-light" role="button" aria-pressed="true">{{ __('Problem and solution') }}</a>
                        <a href="/about/project/actors-and-resources" class="btn btn-md btn-light" role="button" aria-pressed="true">{{ __('Actors and resources') }}</a>
                        <a href="/about/project/terms" class="btn btn-md btn-light" role="button" aria-pressed="true">{{__('Terms')}}</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-8 mt-4">
                <div class="h5 mb-5 mt-4">{{ __('Developer handbook') }}</div>
                <div class="card">
                    <div class="card-body p-4">
                        @component('components.image', ['src' => '/svg/docs/etabli.svg'])
                        @endcomponent
                        <p>{{__('Obtain information related to the design of the solution, its components and patterns. If you are a developer this section can be quite useful.')}}</p>
                        <a href="/about/developer-handbook" class="btn btn-md btn-primary" role="button" aria-pressed="true">{{__('Table of contents') }}</a>
                        <a href="/api/documentation" class="btn btn-md btn-light" role="button" aria-pressed="true">OpenApi</a>
                        <hr>
                        <a href="/about/developer-handbook/introduction" class="btn btn-md btn-secondary" role="button" aria-pressed="true">{{__('Introduction') }}</a>
                        <a href="/about/developer-handbook/conventions" class="btn btn-md btn-light mb-1" role="button" aria-pressed="true">{{__('Conventions')}}</a>
                        <a href="/about/developer-handbook/language-and-tools" class="btn btn-md btn-light mb-1" role="button" aria-pressed="true">{{__('Language and tools')}}</a>
                        <a href="/about/developer-handbook/installation" class="btn btn-md btn-light mb-1" role="button" aria-pressed="true">{{__('Installation')}}</a>
                        <a href="/about/developer-handbook/project-structure" class="btn btn-md btn-light mb-1" role="button" aria-pressed="true">{{__('Project structure')}}</a>
                        <a href="/about/developer-handbook/collaboration" class="btn btn-md btn-light mb-1" role="button" aria-pressed="true">{{__('Collaboration')}}</a>
                        <a href="/about/developer-handbook/criteria-of-acceptance" class="btn btn-md btn-light mb-1" role="button" aria-pressed="true">{{__('Criteria of acceptance')}}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

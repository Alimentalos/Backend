@extends('layouts.app')

@section('content')
    <div class="container">

        <div class="row justify-content-center mb-4">
            <div class="col-md-8 col-sm-12 mt-4">
                <h2 class="text-left mt-4"><i class="fal fa-scroll mr-3"></i> {{ __($page) }}</h2>
            </div>
        </div>
        <div class="row justify-content-center mb-4">
            <div class="col-md-8 col-sm-12 mt-4 h5">
                <a href="/about">{{ __('About') }}</a> &mdash; <a href="/about/{{ $base }}">{{ __($name) }}</a>
            </div>
        </div>

        <div class="row justify-content-center mb-4">
            <div class="col-md-8 col-sm-12 mt-4">
                <div class="card">
                    <div class="card-body p-5">
                        @component('components.doc', ['data' => config('documentation')[$name][$page]])
                        @endcomponent
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

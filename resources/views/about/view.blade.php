@extends('layouts.app')

@section('content')
    <div class="container">

        <div class="row justify-content-center mb-4">
            <div class="col-md-8 col-sm-12 mt-4 h5">
                <a href="/about">{{ __('About') }}</a> &mdash; <a href="/about/{{ $base }}">{{ __($name) }}</a> &mdash; {{ __($page) }}
            </div>
        </div>

        <div class="row justify-content-center mb-4">
            <div class="col-md-8 col-sm-12 mt-4">
                <div class="card">
                    <div class="card-body">
                        @component('components.doc', ['data' => config('documentation')[$name][$page]])
                        @endcomponent
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

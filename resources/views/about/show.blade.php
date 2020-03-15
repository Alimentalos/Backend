@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center mb-4">
            <div class="col-md-8 col-sm-12 mt-4">
                <h2 class="text-left mt-4"><i class="fal fa-bookmark mr-3"></i> {{ __('Table of contents') }}</h2>
                <h1 class="text-left mt-4">"{{ __($name) }}"</h1>
            </div>
        </div>
        <div class="row justify-content-center mb-4">
            <div class="col-md-8 col-sm-12 mt-4">
                <div class="card">
                    <div class="card-body">
                        @component('components.toc', ['data' => config('documentation')[$name], 'base' => $base])
                        @endcomponent
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

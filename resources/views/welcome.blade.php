@extends('layouts.app')

@section('content')
    @include('components.header')

    @include('components.latest_pets')

    @include('partials.testimonials')

    @include('partials.footer')
@endsection

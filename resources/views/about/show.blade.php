@extends('layouts.app')

@section('content')
    <div class="container">
        @component('components.doc', ['data' => config('documentation')[$name]])
        @endcomponent
    </div>
@endsection

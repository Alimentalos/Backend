@extends('layouts.app')

@section('content')
    <div class="bg-wall">
        @include('components.navbar')
        @include('components.start')
    </div>
    <section>
        @include('components.form_search_pet')
        @include('components.list_pets')
    </section>
    <section>
        @include('components.pets_adopted')
    </section>
    <section>
        @include('components.form_contact')
    </section>
    <footer>
        @include('components.footer')
    </footer>
@endsection

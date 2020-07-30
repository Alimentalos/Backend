@extends('layouts.app')

@section('content')
    <div class="">
        <div class="flex-col justify-center">
            <div class="px-4">
                <div class="px-4 py-8 text-center">
                    <h1 class="text-gray-500 text-4xl">Device 1</h1>
                    <p class="text-gray-600 ">Lorem ipsum dolor sit amet, consectetur adipisicing elit</p>
                </div>
            </div>
        </div>
    </div>
    <div class="md:flex justify-center">
        <div class="bg-gray-200 p-4 shadow-lg rounded-lg mb-4">
            <div class="h-32 w-32 rounded-full mx-auto bg-gray-500"></div>
            <div class="p-6 text-center">
                <h2 class="text-teal-900 font-bold text-4xl">Name device</h2>
                <p class="text-gray-700">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Adipisci dolore esse explicabo hic, inventore iure libero maiores nulla quas quibusdam.</p>
            </div>
        </div>
    </div>
@endsection
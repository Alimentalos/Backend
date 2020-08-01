@extends('layouts.app')

@section('content')
    <div class="">
        <div class="flex-col justify-center">
            <div class="px-4">
                <div class="px-4 py-8 text-center">
                    <h1 class="text-gray-500 text-4xl">Geofence</h1>
                    <p class="text-gray-600 ">Lorem ipsum dolor sit amet, consectetur adipisicing elit</p>
                </div>
            </div>
        </div>
    </div>
    <div class="md:flex justify-center">
        <div class="bg-gray-200 p-4 shadow-lg rounded-lg mb-4">
            <div class="h-32 w-32 rounded-full mx-auto bg-gray-500"></div>
            <div class="p-6 text-center">
                <h2 class="text-teal-900 font-bold text-4xl">Name geofence</h2>
                <p class="text-teal-400 font-bold mb-2">2 Hours</p>
                <p class="text-gray-700">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Adipisci dolore esse explicabo hic, inventore iure libero maiores nulla quas quibusdam.</p>
            </div>
            <div class="flex justify-center">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d831.643768226423!2d-70.77938457074424!3d-33.51242848062962!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x9662dd3255fe225b%3A0xb588faf9190167dc!2sMaip%C3%BA%2C%20Regi%C3%B3n%20Metropolitana!5e0!3m2!1ses!2scl!4v1596143004515!5m2!1ses!2scl" width="600" height="450" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe></p>
            </div>
            <div class="flex justify-center py-10 space-x-4">
                <div class="">
                    <button class="bg-blue-500 hover:bg-blue-700 text-white font-light py-2 px-4 rounded-full">
                        Edit geofence
                    </button>
                </div>
                <div class="">
                    <button class="bg-blue-500 hover:bg-blue-700 text-white font-light py-2 px-4 rounded-full">
                        Share geofence
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection
@extends('layouts.app')

@section('content')
    <div class="">
        <div class="flex-col justify-center">
            <div class="px-4">
                <div class="px-4 py-8 text-center">
                    <h1 class="text-gray-500 text-4xl">Place 1</h1>
                    <p class="text-gray-600 ">Lorem ipsum dolor sit amet, consectetur adipisicing elit</p>
                </div>
            </div>
        </div>
    </div>
    <div class="mb-5">
        <div class="bg-gray-200 w-full rounded-lg overflow-hidden container ml-auto mr-auto py-10 px-20">
            <div class="">
                <div class="md:flex justify-center">
                    <div class="px-6 mb-5">
                        <article>
                            <div class="text-left sm:text-left xl:text-left">
                                <p class="text-sm text-gray-600 flex items-center">
                                    Dog
                                </p>
                                <h2 class="text-teal-900 font-bold text-4xl">Name place</h2>
                                <p class="text-teal-400 font-bold mb-2">State</p>
                                <p class="text-teal-400 font-bold mb-2">City, <span>Street #33</span></p>
                                <p class="text-gray-700">
                                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. <br>Amet at atque blanditiis consectetur corporis.
                                </p>
                                <div class="flex items-center mt-3">
                                    <img class="w-16 h-16 rounded-full mr-4" src="../img/human.jpg" alt="Avatar of Jonathan Reinink">
                                    <div class="text-sm">
                                        <p class="text-gray-900 leading-none">Jonathan Reinink</p>
                                        <p class="text-gray-600">Aug 18</p>
                                    </div>
                                </div>
                            </div>
                        </article>
                    </div>
                    <div class="text-center px-6 mb-3">
                        <img class="w-64 rounded-lg" src="../img/background.jpg" alt="">
                    </div>
                </div>
            </div>
            <div class="">
                <div class="bg-white rounded-lg w-4/5">
                    <div class="p-6">
                        <div class="md:flex-col justify-center ">
                            <div class="text-center mb-5">
                                <i class="fas fa-paw" style="font-size: 4.3em; color:#27496D;"></i>
                            </div>
                            <div class="text-center px-8">
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ab adipisci amet eligendi ex fugiat, iste omnis pariatur possimus velit voluptatibus.</p>
                            </div>
                        </div>
                    </div>
                    <div class="flex justify-center py-10 space-x-4">
                        <div class="">
                            <button class="bg-blue-500 hover:bg-blue-700 text-white font-light py-2 px-4 rounded-full">
                                Go to location
                            </button>
                        </div>
                        <div class="">
                            <button class="bg-blue-500 hover:bg-blue-700 text-white font-light py-2 px-4 rounded-full">
                                Share location
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

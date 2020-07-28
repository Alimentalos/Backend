@extends('layouts.app')

@section('content')
    <div class="">
        <div class="flex-col justify-center">
            <div class="px-4">
                <div class="px-4 py-8 text-center">
                    <h1 class="text-gray-500 text-4xl">Profile group</h1>
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
                                <h2 class="text-teal-900 font-bold text-4xl">Name group</h2>
                                <p class="text-teal-400 font-bold mb-2">Create 3 days ago</p>
                                <p class="font-gray text-1xl font-bold">200 Views</p>
                                <p class="text-gray-700">
                                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. <br>Amet at atque blanditiis consectetur corporis.
                                </p>
                            </div>
                        </article>
                    </div>
                    <div class="text-center px-6 mb-3">
                        <img class="w-64 rounded-lg" src="../img/background.jpg" alt="">
                    </div>
                </div>
            </div>
            <div class="">
                <div class="bg-white rounded-lg">
                    <div class="container ml-auto mr-auto">
                        <div class="md:flex-col justify-center py-6 px-20">
                            <div class="text-center mb-5">
                                <i class="fas fa-paw" style="font-size: 4.3em; color:#27496D;"></i>
                            </div>
                            <div class="text-center px-20">
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ab adipisci amet eligendi ex fugiat, iste omnis pariatur possimus velit voluptatibus.</p>
                            </div>
                        </div>
                    </div>
                    <div class="flex justify-center py-10 space-x-4">
                        <div class="">
                            <button class="bg-blue-500 hover:bg-blue-700 text-white font-light py-2 px-4 rounded-full">
                                Add friends
                            </button>
                        </div>
                        <div class="">
                            <button class="bg-blue-500 hover:bg-blue-700 text-white font-light py-2 px-4 rounded-full">
                                Leave group
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

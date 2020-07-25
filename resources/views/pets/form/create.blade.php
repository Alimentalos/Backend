@extends('layouts.app')

@section('content')
    <style>
        .bg-wall{
            width: 100%;
            height: 300px;
            background: #43C6AC;  /* fallback for old browsers */
            background: -webkitlinear-gradient(to right, rgba(25, 22, 84, 0.61), rgba(67, 198, 172, 0.6)), url(img/background.jpg) no-repeat center center fixed;
            background: linear-gradient(to right, rgba(25, 22, 84, 0.61), rgba(67, 198, 172, 0.6)), url(img/background.jpg) no-repeat center center fixed;
            -webkit-background-size: cover;
            -moz-background-size: cover;
            -o-background-size: cover;
            background-size: cover;
        }
    </style>
    <div class="bg-wall">
        @include('components.navbar')
        <div class="flex flex-col justify-center py-8">
            <div class="text-center mt-5 pt-5">
                <h1 class="text-white font-normal text-4xl">Create Pets</h1>
                <p class="text-white font-light px-8">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquid assumenda harum ipsum laudantium minima.</p>
            </div>
        </div>
    </div>
    <section>
        <div class="flex flex-wrap justify-center py-8 px-4">
            <div class="px-4">
                <div class="px-4 py-8 text-center">
                    <h1 class="text-gray-500 text-4xl">Register the dog</h1>
                    <p class="text-gray-600 ">Lorem ipsum dolor sit amet, consectetur adipisicing elit</p>
                </div>
                <form action="">
                    <div class="md:flex justify-center">
                        <div class="text-center px-2 mb-3">
                            <input class="bg-white focus:outline-none focus:shadow-outline border border-gray-300 rounded-lg py-2 px-4 block w-full appearance-none leading-normal" type="email" placeholder="Name">
                        </div>
                        <div class="text-center px-2 mb-3">
                            <input class="bg-white focus:outline-none focus:shadow-outline border border-gray-300 rounded-lg py-2 px-4 block w-full appearance-none leading-normal" type="email" placeholder="Hair color">
                        </div>
                    </div>
                    <div class="md:flex justify-center">
                        <div class="text-center px-2 mb-3">
                            <input class="bg-white focus:outline-none focus:shadow-outline border border-gray-300 rounded-lg py-2 px-4 block w-full appearance-none leading-normal" type="email" placeholder="Color eye left">
                        </div>
                        <div class="text-center px-2 mb-3">
                            <input class="bg-white focus:outline-none focus:shadow-outline border border-gray-300 rounded-lg py-2 px-4 block w-full appearance-none leading-normal" type="email" placeholder="Color eye right">
                        </div>
                    </div>
                    <div class="md:flex justify-center">
                        <div class="text-center px-2 mb-3">
                            <input class="bg-white focus:outline-none focus:shadow-outline border border-gray-300 rounded-lg py-2 px-4 block w-full appearance-none leading-normal" type="email" placeholder="Size">
                        </div>
                        <div class="text-center px-2 mb-3">
                            <input class="bg-white focus:outline-none focus:shadow-outline border border-gray-300 rounded-lg py-2 px-4 block w-full appearance-none leading-normal" type="email" placeholder="Location">
                        </div>
                    </div>
                    <div class="flex w-full px-2 mb-3">
                        <textarea class="resize border w-full rounded focus:outline-none focus:shadow-outline border border-gray-300 py-2 px-4" placeholder="Description..." rows="4"></textarea>
                    </div>
                    <div class="text-center mb-3 pt-4">
                        <button class="bg-blue-500 hover:bg-blue-700 text-white font-light py-2 px-4 rounded-full">
                            Save dog
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>
    <footer>
        @include('components.footer')
    </footer>
@endsection

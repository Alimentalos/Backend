@extends('layouts.app')

@section('content')
    <style>
        .bg-wall{
            width: 100%;
            height: 700px;
            background: #43C6AC;  /* fallback for old browsers */
            background: -webkitlinear-gradient(to right, rgba(25, 22, 84, 0.61), rgba(67, 198, 172, 0.6)), url("img/background.jpg"); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
            background: linear-gradient(to right, rgba(25, 22, 84, 0.61), rgba(67, 198, 172, 0.6)), url("img/background.jpg"); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
            background-size: cover;
        }
    </style>
    <div class="bg-wall">
        <header class="">
            <nav class="flex items-center bg-gray-800 justify-between flex-wrap p-6">
                <div class="flex items-center flex-shrink-0 text-white mr-6">
                    <svg class="fill-current h-8 w-8 mr-2" width="54" height="54" viewBox="0 0 54 54" xmlns="http://www.w3.org/2000/svg"><path d="M13.5 22.1c1.8-7.2 6.3-10.8 13.5-10.8 10.8 0 12.15 8.1 17.55 9.45 3.6.9 6.75-.45 9.45-4.05-1.8 7.2-6.3 10.8-13.5 10.8-10.8 0-12.15-8.1-17.55-9.45-3.6-.9-6.75.45-9.45 4.05zM0 38.3c1.8-7.2 6.3-10.8 13.5-10.8 10.8 0 12.15 8.1 17.55 9.45 3.6.9 6.75-.45 9.45-4.05-1.8 7.2-6.3 10.8-13.5 10.8-10.8 0-12.15-8.1-17.55-9.45-3.6-.9-6.75.45-9.45 4.05z"/></svg>
                    <span class="font-semibold text-xl tracking-tight">Alimentalos</span>
                </div>
                <div class="block lg:hidden">
                    <button class="flex items-center px-3 py-2 border rounded text-teal-200 border-teal-400 hover:text-white hover:border-white">
                        <svg class="fill-current h-3 w-3" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><title>Menu</title><path d="M0 3h20v2H0V3zm0 6h20v2H0V9zm0 6h20v2H0v-2z"/></svg>
                    </button>
                </div>
                <div class="w-full lg:flex lg:w-auto lg:ml-auto">
                    <div class="text-md lg:flex-grow">
                        <a href="#responsive-header" class="block mt-4 lg:inline-block lg:mt-0 text-teal-200 hover:text-white mr-4">
                            Home
                        </a>
                        <a href="#responsive-header" class="block mt-4 lg:inline-block lg:mt-0 text-teal-200 hover:text-white mr-4">
                            Pets
                        </a>
                        <a href="#responsive-header" class="block mt-4 lg:inline-block lg:mt-0 text-teal-200 hover:text-white mr-4">
                            Adopted
                        </a>
                        <a href="#responsive-header" class="block mt-4 lg:inline-block lg:mt-0 text-teal-200 hover:text-white mr-5">
                            Contact us
                        </a>
                    </div>
                </div>
                <div>
                    @if (Route::has('login'))
                        <div class="space-x-4">
                            @auth
                                <a
                                        href="{{ route('logout') }}"
                                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                        class="font-medium text-indigo-600 hover:text-indigo-500 focus:outline-none focus:underline transition ease-in-out duration-150"
                                >
                                    Log out
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            @else
                                <a href="{{ route('login') }}" class="font-medium inline-block text-sm px-4 py-2 leading-none border rounded text-white border-white hover:border-transparent hover:text-teal-500 hover:bg-white mt-4 lg:mt-0">Log in</a>

                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="font-medium inline-block text-sm px-4 py-2 leading-none border rounded text-white border-white hover:border-transparent hover:text-teal-500 hover:bg-white mt-4 lg:mt-0">Register</a>
                                @endif
                            @endauth
                        </div>
                    @endif
                    {{-- <a href="#" class="inline-block text-sm px-4 py-2 leading-none border rounded text-white border-white hover:border-transparent hover:text-teal-500 hover:bg-white mt-4 lg:mt-0">Login</a> --}}
                </div>
            </nav>
        </header>
        <div class="text-center py-40">
            <h1 class="text-white font-bold uppercase text-4xl">Lorem ipsum dolor sit amet</h1>
            <p class="text-white text-light">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad adipisci amet consequatur cum.</p>
            <div class="flex justify-center py-10 space-x-4">
                <div class="">
                    <button class="bg-blue-500 hover:bg-blue-700 text-white font-light py-2 px-4 rounded-full">
                        Register pet
                    </button>
                </div>
                <div class="">
                    <button class="bg-blue-500 hover:bg-blue-700 text-white font-light py-2 px-4 rounded-full">
                        Pet to adopt
                    </button>
                </div>
            </div>
        </div>
    </div>
    <section>
        <div class="container mx-auto ml-auto mr-auto">
            <div class="text-center py-10">
                <h1 class="text-4xl">Pets to adopt</h1>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad adipisci amet consequatur cum.</p>
            </div>
            <div class="ml-4">
                <div class="md:flex justify-center">
                    <div class="text-center px-4 mb-3">
                        <input class="bg-white focus:outline-none focus:shadow-outline border border-gray-300 rounded-lg py-2 px-4 block w-full appearance-none leading-normal" type="text" placeholder="City">
                    </div>
                    <div class="text-center px-4 mb-3">
                        <input class="bg-white focus:outline-none focus:shadow-outline border border-gray-300 rounded-lg py-2 px-4 block w-full appearance-none leading-normal" type="text" placeholder="State">
                    </div>
                    <div class="text-center px-4 mb-3">
                        <input class="bg-white focus:outline-none focus:shadow-outline border border-gray-300 rounded-lg py-2 px-4 block w-full appearance-none leading-normal" type="text" placeholder="Street">
                    </div>
                </div>
                <div class="text-center mb-3 text-center pt-4">
                    <button class="bg-blue-500 hover:bg-blue-700 text-white font-light py-2 px-4 rounded-full">
                        Search
                    </button>
                </div>
            </div>
        </div>
        <div class="mt-5 ml-4 py-10">
            <div class="">
                <div class="md:flex justify-center">
                    <div class="px-6 sm:px-20 mb-3 pt-3">
                        <img class="w-70 h-40 rounded-lg" src="img/background.jpg" alt="">
                    </div>
                    <div class="px-6 mb-5">
                        <article>
                            <div class="text-left sm:text-left xl:text-left">
                                <h2 class="text-teal-900 font-bold text-4xl">Firulais</h2>
                                <p class="text-teal-400 font-bold mb-2">2 years 3 mounths</p>
                                <p class="text-gray-700">
                                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. <br>Amet at atque blanditiis consectetur corporis.
                                </p>
                                <div class="flex mt-3 block md:hidden xl:hidden">
                                    <span class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2">#doglovers</span>
                                    <span class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2">#adopt</span>
                                    <span class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700">#happy</span>
                                </div>
                            </div>
                        </article>
                    </div>
                    <div class="text-left px-6 mb-3 mt-5 pt-5">
                        <button class="bg-blue-500 hover:bg-blue-700 text-white font-light py-2 px-4 rounded-full">
                            Go to adopt
                        </button>
                    </div>
                </div>
            </div>
            <div class="">
                <div class="md:flex justify-center">
                    <div class="px-6 sm:px-20 mb-3 pt-3">
                        <img class="w-70 h-40 rounded-lg" src="img/background.jpg" alt="">
                    </div>
                    <div class="px-6 mb-5">
                        <article>
                            <div class="text-left sm:text-left xl:text-left">
                                <h2 class="text-teal-900 font-bold text-4xl">Firulais</h2>
                                <p class="text-teal-400 font-bold mb-2">2 years 3 mounths</p>
                                <p class="text-gray-700">
                                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. <br>Amet at atque blanditiis consectetur corporis.
                                </p>
                                <div class="flex mt-3 block md:hidden xl:hidden">
                                    <span class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2">#doglovers</span>
                                    <span class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2">#adopt</span>
                                    <span class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700">#happy</span>
                                </div>
                            </div>
                        </article>
                    </div>
                    <div class="text-left px-6 mb-3 mt-5 pt-5">
                        <button class="bg-blue-500 hover:bg-blue-700 text-white font-light py-2 px-4 rounded-full">
                            Go to adopt
                        </button>
                    </div>
                </div>
            </div>
            <div class="">
                <div class="md:flex justify-center">
                    <div class="px-6 sm:px-20 mb-3 pt-3">
                        <img class="w-70 h-40 rounded-lg" src="img/background.jpg" alt="">
                    </div>
                    <div class="px-6 mb-5">
                        <article>
                            <div class="text-left sm:text-left xl:text-left">
                                <h2 class="text-teal-900 font-bold text-4xl">Firulais</h2>
                                <p class="text-teal-400 font-bold mb-2">2 years 3 mounths</p>
                                <p class="text-gray-700">
                                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. <br>Amet at atque blanditiis consectetur corporis.
                                </p>
                                <div class="flex mt-3 block md:hidden xl:hidden">
                                    <span class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2">#doglovers</span>
                                    <span class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2">#adopt</span>
                                    <span class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700">#happy</span>
                                </div>
                            </div>
                        </article>
                    </div>
                    <div class="text-left px-6 mb-3 mt-5 pt-5">
                        <button class="bg-blue-500 hover:bg-blue-700 text-white font-light py-2 px-4 rounded-full">
                            Go to adopt
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section>
        <div class="bg-gray-400 text-center py-10 px-10">
            <div class="container mx-auto ml-auto mr-auto">
                <div class="text-center py-10">
                    <h1 class="text-white text-4xl">Pets adopted with us</h1>
                    <p class="text-white text-light">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad adipisci amet consequatur cum.</p>
                </div>
                <div class="">
                    <div class="md:flex md:justify-between">
                        <div class="mx-3 mb-2 py-5">
                            <img src="img/background.jpg" class="mx-auto" alt="">
                            <article>
                                <div class="bg-white py-5 text-left px-6">
                                    <h2 class="text-teal-900 font-bold text-4xl">Firulais</h2>
                                    <p class="text-teal-400 font-bold mb-2">2 years 3 mounths</p>
                                    <p class="text-gray-700 mb-5">
                                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Voluptatibus quia, nulla! Maiores et perferendis eaque, exercitationem praesentium nihil.
                                    </p>
                                    <div class="py-4">
                                        <span class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2">#doglovers</span>
                                        <span class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2">#adopt</span>
                                        <span class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700">#happy</span>
                                    </div>
                                </div>
                            </article>
                        </div>
                        <div class="mx-3 mb-2 py-5">
                            <img src="img/background.jpg" class="mx-auto" alt="">
                            <article>
                                <div class="bg-white py-5 text-left px-6">
                                    <h2 class="text-teal-900 font-bold text-4xl">Firulais</h2>
                                    <p class="text-teal-400 font-bold mb-2">2 years 3 mounths</p>
                                    <p class="text-gray-700 mb-5">
                                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Voluptatibus quia, nulla! Maiores et perferendis eaque, exercitationem praesentium nihil.
                                    </p>
                                    <div class="py-4">
                                        <span class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2">#doglovers</span>
                                        <span class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2">#adopt</span>
                                        <span class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700">#happy</span>
                                    </div>
                                </div>
                            </article>
                        </div>
                        <div class="mx-3 mb-2 py-5">
                            <img src="img/background.jpg" class="mx-auto" alt="">
                            <article>
                                <div class="bg-white py-5 text-left px-6">
                                    <h2 class="text-teal-900 font-bold text-4xl">Firulais</h2>
                                    <p class="text-teal-400 font-bold mb-2">2 years 3 mounths</p>
                                    <p class="text-gray-700 mb-5">
                                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Voluptatibus quia, nulla! Maiores et perferendis eaque, exercitationem praesentium nihil.
                                    </p>
                                    <div class="py-4">
                                        <span class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2">#doglovers</span>
                                        <span class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2">#adopt</span>
                                        <span class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700">#happy</span>
                                    </div>
                                </div>
                            </article>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section>
        <div class="">
            <div class="block md:flex justify-center py-10">
                <div class="mx-3 pt-5 mt-5">
                    <img class="text-center mx-auto" src="img/contact_form.svg" alt="" width="400">
                </div>
                <div class="ml-4">
                    <div class="px-4 py-8 text-center">
                        <h1 class="text-gray-500 text-4xl">Contact us</h1>
                        <p class="text-gray-600 ">Lorem ipsum dolor sit amet, consectetur adipisicing elit</p>
                    </div>
                    <div class="md:flex justify-center">
                        <div class="text-center px-4 mb-3">
                            <input class="bg-white focus:outline-none focus:shadow-outline border border-gray-300 rounded-lg py-2 px-4 block w-full appearance-none leading-normal" type="email" placeholder="Name">
                        </div>
                        <div class="text-center px-4 mb-3">
                            <input class="bg-white focus:outline-none focus:shadow-outline border border-gray-300 rounded-lg py-2 px-4 block w-full appearance-none leading-normal" type="email" placeholder="Email">
                        </div>
                    </div>
                    <div class="flex w-full px-4 mb-3">
                        <textarea class="resize border w-full rounded focus:outline-none focus:shadow-outline border border-gray-300 py-2 px-4" placeholder="Message..." rows="4"></textarea>
                    </div>
                    <div class="text-center mb-3 pt-4">
                        <button class="bg-blue-500 hover:bg-blue-700 text-white font-light py-2 px-4 rounded-full">
                            Submit
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <footer class="">
        <div class="text-center py-10 px-10">
            <div class="block md:flex justify-between">
                <div class="text-gray-600 text-light text-2xl pt-5 ml-4 xl:order-first">
                    Alimentalos © 2020
                </div>
                <div class="text-center order-first sm:order-last md:order-none lg:order-first xl:order-last">
                    <i class="fas fa-paw" style="font-size: 4.3em; color:#27496D;"></i>
                </div>
                <div class="pt-5">
                    <ul class="flex justify-center">
                        <li class="mr-6">
                            <a class="text-blue-500 hover:text-blue-800" href="">Privacy</a>
                        </li>
                        <li class="mr-6">
                            <a class="text-blue-500 hover:text-blue-800" href="">Terms</a>
                        </li>
                        <li class="mr-6">
                            <a class="text-blue-500 hover:text-blue-800" href="">About</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>
@endsection

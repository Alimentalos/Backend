@extends('layouts.app')

@section('content')
    <header>
        <nav class="flex items-center justify-between flex-wrap bg-teal-500 p-6">
            <div class="flex items-center flex-shrink-0 text-white mr-6">
                <svg class="fill-current h-8 w-8 mr-2" width="54" height="54" viewBox="0 0 54 54" xmlns="http://www.w3.org/2000/svg"><path d="M13.5 22.1c1.8-7.2 6.3-10.8 13.5-10.8 10.8 0 12.15 8.1 17.55 9.45 3.6.9 6.75-.45 9.45-4.05-1.8 7.2-6.3 10.8-13.5 10.8-10.8 0-12.15-8.1-17.55-9.45-3.6-.9-6.75.45-9.45 4.05zM0 38.3c1.8-7.2 6.3-10.8 13.5-10.8 10.8 0 12.15 8.1 17.55 9.45 3.6.9 6.75-.45 9.45-4.05-1.8 7.2-6.3 10.8-13.5 10.8-10.8 0-12.15-8.1-17.55-9.45-3.6-.9-6.75.45-9.45 4.05z"/></svg>
                <span class="font-semibold text-xl tracking-tight">Tailwind CSS</span>
            </div>
            <div class="block lg:hidden">
                <button class="flex items-center px-3 py-2 border rounded text-teal-200 border-teal-400 hover:text-white hover:border-white">
                    <svg class="fill-current h-3 w-3" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><title>Menu</title><path d="M0 3h20v2H0V3zm0 6h20v2H0V9zm0 6h20v2H0v-2z"/></svg>
                </button>
            </div>
            <div class="w-full block flex-grow lg:flex lg:items-center lg:w-auto">
                <div class="text-sm lg:flex-grow">
                    <a href="#responsive-header" class="block mt-4 lg:inline-block lg:mt-0 text-teal-200 hover:text-white mr-4">
                        Docs
                    </a>
                    <a href="#responsive-header" class="block mt-4 lg:inline-block lg:mt-0 text-teal-200 hover:text-white mr-4">
                        Examples
                    </a>
                    <a href="#responsive-header" class="block mt-4 lg:inline-block lg:mt-0 text-teal-200 hover:text-white">
                        Blog
                    </a>
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
                                <a href="{{ route('login') }}" class="font-medium text-indigo-600 hover:text-indigo-500 focus:outline-none focus:underline transition ease-in-out duration-150">Log in</a>
    
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="font-medium text-indigo-600 hover:text-indigo-500 focus:outline-none focus:underline transition ease-in-out duration-150">Register</a>
                                @endif
                            @endauth
                        </div>
                    @endif
                    {{-- <a href="#" class="inline-block text-sm px-4 py-2 leading-none border rounded text-white border-white hover:border-transparent hover:text-teal-500 hover:bg-white mt-4 lg:mt-0">Login</a> --}}
                </div>
            </div>
        </nav>
    </header>
    <div class="bg-gray-800 text-center py-24 px-10">
        <h1 class="text-white font-bold uppercase text3xl">Lorem ipsum dolor sit amet, consectetur adipisicing elit</h1>
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad adipisci amet consequatur cum.</p>
    </div>
    <section>
        <div class="container mx-auto ml-auto mr-auto py-10 px-40">
            <div class="text-center py-10">
                <h1 class="text-4xl">Pets to adopt</h1>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad adipisci amet consequatur cum.</p>
            </div>
            <form class="">
                <div class="flex flex-wrap -mx-3 mb-2">
                    <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-city">
                            City
                        </label>
                        <input class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="grid-city" type="text" placeholder="City">
                    </div>
                    <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-state">
                            State
                        </label>
                        <div class="relative">
                            <select class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="State">
                                <option>New Mexico</option>
                                <option>Missouri</option>
                                <option>Texas</option>
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                            </div>
                        </div>
                    </div>
                    <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-zip">
                            Zip
                        </label>
                        <input class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="grid-zip" type="text" placeholder="Street">
                    </div>
                    <div class="container text-center pt-5">
                        <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-full">
                            Search
                        </button>
                    </div>
                </div>
            </form>
        </div>
        <div class="container mx-auto text-center mt-5 py-24 px-40">
            <div class="flex justify-between">
                <div class="flex">
                    <div class="text-right mx-2">
                        <img class="w-70 h-40 rounded-lg" src="img/background.jpg" alt="">
                    </div>
                    <article>
                        <div class="text-left mt-4 mx-2 mr-6">
                            <h1 class="text-teal-900 font-bold uppercase text3xl">Lorem ipsum dolor sit amet</h1>
                            <p class="mb-3">Lorem ipsum dolor sit amet, consectetur adipisicing elit. <br>Ad adipisci amet consequatur cum.</p>
                            <p class="text-teal-400 font-bold">2 years 3 mounths</p>
                        </div>
                    </article>
                    <div class="pt-5">
                        <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-full mt-4">
                            Go to adopt
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section>
        <div class="bg-gray-400 text-center py-10 px-10">
            <div class="container text-center mb-5 py-5">
                <h1 class="text-white text-4xl">Pets adopted with us</h1>
                <p class="text-white">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad adipisci amet consequatur cum.</p>
                <div class="md:flex flex justify-between py-10 px-40">
                    <div class="mx-3">
                        <img src="img/background.jpg" class="mx-auto" alt="">
                        <article>
                            <div class="bg-white py-5">
                                <h2 class="text-teal-900 font-bold text3xl">Firulais</h2>
                                <p class="text-teal-400 font-bold">2 years 3 mounths</p>
                                <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-full mt-4">
                                    See history
                                </button>
                            </div>
                        </article>
                    </div>
                    <div class="mx-3">
                        <img src="img/background.jpg" class="mx-auto" alt="">
                        <article>
                            <div class="bg-white py-5">
                                <h2 class="text-teal-900 font-bold text3xl">Firulais</h2>
                                <p class="text-teal-400 font-bold">2 years 3 mounths</p>
                                <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-full mt-4">
                                    See history
                                </button>
                            </div>
                        </article>
                    </div>
                    <div class="mx-3">
                        <img src="img/background.jpg" class="mx-auto" alt="">
                        <article>
                            <div class="bg-white py-5">
                                <h2 class="text-teal-900 font-bold text3xl">Firulais</h2>
                                <p class="text-teal-400 font-bold">2 years 3 mounths</p>
                                <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-full mt-4">
                                    See history
                                </button>
                            </div>
                        </article>
                    </div>                                        
                </div>
            </div>
        </div>
    </section>
    <section>
        <div class="container text-center mb-5 py-10">
            <h1 class="text-4xl">Contact us</h1>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad adipisci amet consequatur cum.</p>
        </div>
        <div class="container">
            <div class="flex justify-between py-10 px-40 ">
                <div class="mx-3">
                    <img class="w-64" src="img/contact_form.svg" alt="">
                </div>
                <div class="">
                    <form class="w-full max-w-lg">
                        <div class="flex flex-wrap -mx-3 mb-6">
                            <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-first-name">
                                    First Name
                                </label>
                                <input class="appearance-none block w-full bg-gray-200 text-gray-700 border border-red-500 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white" id="grid-first-name" type="text" placeholder="Jane">
                            </div>
                            <div class="w-full md:w-1/2 px-3">
                                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-last-name">
                                    Last Name
                                </label>
                                <input class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="grid-last-name" type="text" placeholder="Doe">
                            </div>
                        </div>
                        <div class="flex flex-wrap -mx-3 mb-2">
                            <div class="w-full  px-3 mb-6 md:mb-0">
                                <label class="block">
                                    <span class="text-gray-700">Textarea</span>
                                    <textarea class="form-textarea mt-1 block w-full" rows="3" placeholder="Enter some long form content."></textarea>
                                </label>
                            </div>
                        </div>
                        <div class="flex flex-wrap -mx-3 mb-2">
                            <div class="w-full text-right  px-3 mb-6 md:mb-0">
                                <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-full mt-4">
                                    Submit message
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <footer>
        <div class="container">
            <div class="flex justify-between py-10 px-40">
                <div class="pt-5">
                    © 2020 Alimentalos
                </div>
                <div class="">
                    <i class="fas fa-paw" style="font-size: 3.3em; color:#27496D;"></i>
                </div>
                <div class="pt-5">
                    <ul class="flex">
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

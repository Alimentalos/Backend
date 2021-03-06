@extends('layouts.app')

@section('content')
    <div class="">
        <div class="flex justify-center">
            <div class="px-4">
                <div class="px-4 py-8 text-center">
                    <h1 class="text-gray-500 text-4xl">Edit the group</h1>
                    <p class="text-gray-600 ">Lorem ipsum dolor sit amet, consectetur adipisicing elit</p>
                </div>
                <form action="">
                    <div class="flex w-full px-2 mb-3">
                        <input class="bg-white focus:outline-none focus:shadow-outline border border-gray-300 rounded-lg py-2 px-4 block w-full appearance-none leading-normal" type="email" placeholder="Name">
                    </div>
                    <div class="flex w-full px-2 mb-3">
                        <input class="bg-white focus:outline-none focus:shadow-outline border border-gray-300 rounded-lg py-2 px-4 block w-full appearance-none leading-normal" type="email" placeholder="Photo">
                    </div>
                    <div class="flex w-full px-2 mb-3">
                        <textarea class="resize border w-full rounded focus:outline-none focus:shadow-outline border border-gray-300 py-2 px-4" placeholder="Description..." rows="4"></textarea>
                    </div>
                    <div class="text-center mb-3 pt-4">
                        <button class="bg-blue-500 hover:bg-blue-700 text-white font-light py-2 px-4 rounded-full">
                            Save group
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

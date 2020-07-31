<template>
    <nav class="relative flex flex-wrap items-center justify-between px-2 py-3 navbar-expand-lg bg-teal-900 mb-3">
        <div class="container px-4 mx-auto flex flex-wrap items-center justify-between">
            <div class="w-full relative flex justify-between lg:w-auto  px-4 lg:static lg:block lg:justify-start">
                <a class="text-sm font-light leading-relaxed inline-block mr-4 py-2 whitespace-no-wrap uppercase text-white" href="#pablo">
                    pink Color
                </a>
                <button class="text-white cursor-pointer text-xl leading-none px-3 py-1 border border-solid border-transparent rounded bg-transparent block lg:hidden outline-none focus:outline-none" type="button" v-on:click="toggleNavbar()">
                    <i class="fas fa-bars"></i>
                </button>
            </div>
            <div v-bind:class="{'hidden': !showMenu, 'flex': showMenu}" class="lg:flex lg:flex-grow items-center">
                <ul class="flex flex-col lg:flex-row list-none ml-auto">
                    <li class="nav-item">
                        <a class="px-3 py-2 flex items-center text-xs uppercase font-bold leading-snug text-white hover:opacity-75" href="#">
                            <i class="fas fa-paw text-lg leading-lg text-white opacity-75" /><span class="ml-2 font-light ">Home</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="px-3 py-2 flex items-center text-xs uppercase font-bold leading-snug text-white hover:opacity-75" href="#">
                            <i class="fas fa-paw text-lg leading-lg text-white opacity-75" /><span class="ml-2 font-light ">Pets</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="px-3 py-2 flex items-center text-xs uppercase font-bold leading-snug text-white hover:opacity-75" href="#">
                            <i class="fas fa-paw text-lg leading-lg text-white opacity-75" /><span class="ml-2 font-light ">Adopted</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="px-3 py-2 flex items-center text-xs uppercase font-bold leading-snug text-white hover:opacity-75" href="#">
                            <i class="fas fa-paw text-lg leading-lg text-white opacity-75" /><span class="ml-2 font-light ">Contact us</span>
                        </a>
                    </li>
                    <li class="ml-5">
                        <a href="#" class="inline-block text-sm px-4 py-2 leading-none border rounded text-white border-white hover:border-transparent hover:text-teal-500 hover:bg-white mt-4 lg:mt-0">Register</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</template>

<script>
    export default {
        name: "navbar",
        data() {
            return {
                showMenu: false
            }
        },
        methods: {
            toggleNavbar: function(){
                this.showMenu = !this.showMenu;
            }
        }
    }
</script>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @vite('resources/css/app.css')
    <title>List Ruang Kuliah</title>
</head>

<body class="bg-gradient-to-r from-fuchsia-800 from-1% to bg-pink-500 ">
    <nav class="bg-black" x-data="{ isOpen: false }">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex h-16 items-center justify-between">
                <div class="flex items-center">
                    <div class="flex">
                        <a href="{{ route('kaprodi.dashboard') }}" class="flex items-center">
                            <img class="h-9 w-8" src="{{ asset('undipLogo.png') }}" alt="Your Company">
                            <h3 class="ml-2 text-white">SiAKAM Undip</h3>
                        </a>
                    </div>
                </div>
                <div class="hidden md:block">
                    <div class="ml-4 flex items-center md:ml-6">
                        <button type="button"
                            class="relative rounded-full bg-gray-800 p-1 text-gray-400 hover:text-white focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800">
                            <span class="absolute -inset-1.5"></span>
                            <span class="sr-only">View notifications</span>
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
                            </svg>
                        </button>

                        <div>
                            <h3 class="ml-3 text-white">{{ Auth::user()->name }}</h3>
                        </div>

                        <!-- Profile dropdown -->
                        <div class="relative ml-3">
                            <div>
                                <button type="button" @click="isOpen = !isOpen"
                                    class="relative flex max-w-xs items-center rounded-full bg-gray-800 text-sm focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800"
                                    id="user-menu-button" aria-expanded="false" aria-haspopup="true">
                                    <span class="absolute -inset-1.5"></span>
                                    <span class="sr-only">Open user menu</span>
                                    <img class="h-8 w-8 rounded-full" src="{{ asset('profilPembimbing.png') }}"
                                        alt="">
                                </button>
                            </div>

                            <div x-show="isOpen" x-transition:enter="transition ease-out duration-100 transform"
                                x-transition:enter-start="opacity-0 scale-95"
                                x-transition:enter-end="opacity-100 scale-100"
                                x-transition:leave="transition ease-in duration-75 transform"
                                x-transition:leave-start="opacity-100 scale-100"
                                x-transition:leave-end="opacity-0 scale-95"
                                class="absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-md bg-white py-1 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
                                role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button"
                                tabindex="-1">
                                <!-- Active: "bg-gray-100", Not Active: "" -->
                                <a href="{{ route('logout') }}"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                    class="block px-4 py-2 text-sm text-gray-700" role="menuitem" tabindex="-1"
                                    id="user-menu-item-2">Logout</a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                    style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <section class="relative top-20">
        <div class="w-2/3 mx-auto flex justify-between text-white" id="container-navigation">
            <p class="font-bold">Ruang Kuliah</p>
            <a href="{{ route('akademik.dashboard') }}">
                <div class="flex">
                    <img src="{{ asset('home-outline.svg') }}" alt="">
                    <p class="ml-2">Dasbor / Ruang Kuliah</p>
                </div>
            </a>
        </div>
    </section>


    <section class="w-11/12 mx-auto relative top-36 bg-white rounded-lg pt-5 pb-6" id="body">
        <div class="container-table ">
            <div id="table-list">

                <h2 class="text-2xl text-center mx-auto max-w-64 mt-5">LIST RUANG KULIAH</h2>

                <div class="flex justify mt-5 mb-3 ml-20">
                    <button class="h-8 w-48 flex bg-[#002687] text-white rounded-lg pt-1 pl-2 mb-4 ">Atur Ruang<img class="w-5 h-5 mx-auto pt-1 ml-2 " src="{{asset('plus.svg')}}" alt=""></button>
                </div>

                <div class="flex flex-col">
        <div class=" overflow-x-auto pb-4">
            <div class="min-w-full inline-block align-middle">
                <div class="overflow-hidden  border rounded-lg border-gray-300 w-11/12 mx-auto">
                    <table class="table-auto min-w-full rounded-xl">
                        <thead>
                            <tr class="bg-gray-50">
                                <th scope="col" class="p-5 text-center whitespace-nowrap text-sm leading-6 font-semibold text-gray-900 capitalize"> NO </th>
                                <th scope="col" class="p-5 text-left whitespace-nowrap text-sm leading-6 font-semibold text-gray-900 capitalize"> PROGRAM STUDI </th>
                                <th scope="col" class="p-5 text-left whitespace-nowrap text-sm leading-6 font-semibold text-gray-900 capitalize"> KAPASITAS </th>
                                <th scope="col" class="p-5 text-left whitespace-nowrap text-sm leading-6 font-semibold text-gray-900 capitalize"> RUANGAN </th>
                                <th scope="col" class="p-5 text-left whitespace-nowrap text-sm leading-6 font-semibold text-gray-900 capitalize"> AKSI </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-300 ">
                            <tr class="bg-white transition-all duration-500 hover:bg-gray-50">
                                <td class="p-5 whitespace-nowrap text-sm leading-6 font-medium text-gray-900 text-center"> 1 </td>
                                <td class="p-5 whitespace-nowrap text-sm leading-6 font-medium text-gray-900"> S1-INFORMATIKA </td>
                                <td class="p-5 whitespace-nowrap text-sm leading-6 font-medium text-gray-900"> 50 </td>
                                <td class="p-5 whitespace-nowrap text-sm leading-6 font-medium text-gray-900"> E101, E102, E103, A303</td>
                                <td>
                                    <a href="{{ route('akademik.inputRuangKuliah') }}"class="btn-detail">Edit</a>
                                </td>
                            </tr>
                            <tr class="bg-white transition-all duration-500 hover:bg-gray-50">
                                <td class="p-5 whitespace-nowrap text-sm leading-6 font-medium text-gray-900 text-center "> 2 </td>
                                <td class="p-5 whitespace-nowrap text-sm leading-6 font-medium text-gray-900"> S1-MATEMATIKA </td>
                                <td class="p-5 whitespace-nowrap text-sm leading-6 font-medium text-gray-900"> 50 </td>
                                <td class="p-5 whitespace-nowrap text-sm leading-6 font-medium text-gray-900"> K101, K102, K103</td>
                                <td>
                                    <a href="{{ route('akademik.inputRuangKuliah') }}"class="btn-detail">Edit</a>
                                </td>
                            </tr>
                            <tr class="bg-white transition-all duration-500 hover:bg-gray-50">
                                <td class="p-5 whitespace-nowrap text-sm leading-6 font-medium text-gray-900 text-center "> 3 </td>
                                <td class="p-5 whitespace-nowrap text-sm leading-6 font-medium text-gray-900"> S1-BIOLOGI </td>
                                <td class="p-5 whitespace-nowrap text-sm leading-6 font-medium text-gray-900"> 50 </td>
                                <td class="p-5 whitespace-nowrap text-sm leading-6 font-medium text-gray-900"> K102</td>
                                <td>
                                    <a href="{{ route('akademik.inputRuangKuliah') }}"class="btn-detail">Edit</a>
                                </td>
                            </tr>
                            <tr class="bg-white transition-all duration-500 hover:bg-gray-50">
                                <td class="p-5 whitespace-nowrap text-sm leading-6 font-medium text-gray-900 text-center "> 4 </td>
                                <td class="p-5 whitespace-nowrap text-sm leading-6 font-medium text-gray-900"> S1-STATISTIKA </td>
                                <td class="p-5 whitespace-nowrap text-sm leading-6 font-medium text-gray-900"> 50 </td>
                                <td class="p-5 whitespace-nowrap text-sm leading-6 font-medium text-gray-900"> K202</td>
                                <td>
                                    <button class="btn-detail">Edit</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        </div>
            </div>
        </div>
    </section>

    <section class="relative top-32">
        <footer class="bg-[#D9D9D9] bg-opacity-30 mt-20">
            <div class="flex w-2/3 h-9 mx-auto justify-between items-center text-white ">
                <p>TIM SiAKAM <span class="font-semibold"> Universitas Diponegoro</span></p>
                <p>Dibangun dengan penuh kekhawatiran 🔥🔥</p>
            </div>
        </footer>
    </section>
</body>

</html>

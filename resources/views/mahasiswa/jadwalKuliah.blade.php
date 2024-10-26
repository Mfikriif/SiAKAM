<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @vite('resources/css/app.css')
    <title>Jadwal Kuliah</title>
</head>

<body class="bg-gradient-to-r from-fuchsia-800 from-1% to bg-pink-500 ">
    <nav class="bg-black" x-data="{ isOpen: false }">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex h-16 items-center justify-between">
                <div class="flex items-center">
                    <div class="flex">
                        <a href="{{ route('mahasiswa.dashboard') }}" class="flex items-center">
                            <img class="h-9 w-8" src="{{ asset('undipLogo.png') }}" alt="Your Company">
                            <h3 class="mt-1.5 ml-5 text-white">SiAKAM Undip</h3>
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
                                    <img class="h-8 w-8 rounded-full" src="{{ asset('profileMhs.png') }}"
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
            <p class="font-bold">JADWAL KULIAH</p>
            <a href="{{ route('mahasiswa.dashboard') }}">
                <div class="flex">
                    <img src="{{ asset('home-outline.svg') }}" alt="">
                    <p class="ml-2">Dasbor / Jadwal Kuliah</p>
                </div>
            </a>
        </div>
    </section>

    <section class="w-11/12 mx-auto relative top-36 bg-white rounded-lg pt-5 pb-6" id="body">
        <div class="container-table ">
            <div id="table-list">

                <h2 class="text-2xl text-center font-light mx-auto max-w-64 mt-5">JADWAL KULIAH</h2>
                <div class="flex flex-col items-center mt-5 mb-5 mr-20 ml-20">
                    <p class="ml-auto mb-2 font-light">SKS YANG DIAMBIL</p>
                    <div class="h-8 w-1/12 flex bg-[#002687] text-white font-bold rounded-lg pt-1 pl-5 mr-5 ml-auto">18 SKS</div>
                </div>

            <div class="flex flex-col">
        <div class=" overflow-x-auto pb-4">
            <div class="min-w-full inline-block align-middle">
                <div class="overflow-hidden  border rounded-lg border-gray-300 w-11/12 mx-auto">
                    <table class="table-auto min-w-full rounded-xl">
                        <thead>
                            <tr class="bg-gray-50">
                                <th scope="col" class="p-5 text-center whitespace-nowrap text-sm leading-6 font-semibold text-gray-900 capitalize"> HARI </th>
                                <th scope="col" class="p-5 text-left whitespace-nowrap text-sm leading-6 font-semibold text-gray-900 capitalize"> MATA KULIAH </th>
                                <th scope="col" class="p-5 text-left whitespace-nowrap text-sm leading-6 font-semibold text-gray-900 capitalize min-w-[150px]"> RUANGAN </th>
                                <th scope="col" class="p-5 text-left whitespace-nowrap text-sm leading-6 font-semibold text-gray-900 capitalize"> WAKTU </th>
                                <th scope="col" class="p-5 text-left whitespace-nowrap text-sm leading-6 font-semibold text-gray-900 capitalize"> SKS </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-300 ">
                            <tr class="bg-white transition-all duration-500 hover:bg-gray-50">
                                <td class="p-5 whitespace-nowrap text-sm leading-6 font-medium text-gray-900 text-center"> SENIN </td>
                                <td class="p-5 whitespace-nowrap text-sm leading-6 font-medium text-gray-900"> REKAYASA PERANGKAT LUNAK </td>
                                <td class=" px-5 py-3">
                                    <div class="w-48 flex items-center gap-3">
                                        <div class="data">
                                            <p class="font-normal text-sm text-gray-900">E101</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="p-5 whitespace-nowrap text-sm leading-6 font-medium text-gray-900">15.40-18.10 WIB</td>
                                <td class="p-5 whitespace-nowrap text-sm leading-6 font-medium text-gray-900">3</td>
                            </tr>
                            <tr class="bg-white transition-all duration-500 hover:bg-gray-50">
                                <td class="p-5 whitespace-nowrap text-sm leading-6 font-medium text-gray-900 text-center "> SELASA </td>
                                <td class="p-5 whitespace-nowrap text-sm leading-6 font-medium text-gray-900"> MANAJEMEN BASIS DATA </td>
                                <td class=" px-5 py-3">
                                    <div class="w-48 flex items-center gap-3">
                                        <div class="data">
                                            <p class="font-normal text-sm text-gray-900">E101</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="p-5 whitespace-nowrap text-sm leading-6 font-medium text-gray-900">07.00-09.30 WIB</td>
                                <td class="p-5 whitespace-nowrap text-sm leading-6 font-medium text-gray-900">3</td>
                            </tr>
                            <tr class="bg-white transition-all duration-500 hover:bg-gray-50">
                                <td class="p-5 whitespace-nowrap text-sm leading-6 font-medium text-gray-900 text-center"> SELASA </td>
                                <td class="p-5 whitespace-nowrap text-sm leading-6 font-medium text-gray-900"> GRAFIKA DAN KOMPUTASI VISUAL </td>
                                <td class=" px-5 py-3">
                                    <div class="w-48 flex items-center gap-3">
                                        <div class="data">
                                            <p class="font-normal text-sm text-gray-900">E103</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="p-5 whitespace-nowrap text-sm leading-6 font-medium text-gray-900">13:00:00 s/d 15:30:00</td>
                                <td class="p-5 whitespace-nowrap text-sm leading-6 font-medium text-gray-900">3</td>
                            </tr>
                            <tr class="bg-white transition-all duration-500 hover:bg-gray-50">
                                <td class="p-5 whitespace-nowrap text-sm leading-6 font-medium text-gray-900 text-center"> RABU </td>
                                <td class="p-5 whitespace-nowrap text-sm leading-6 font-medium text-gray-900"> PEMROGRAMAN BERORIENTASI OBJEK </td>
                                <td class=" px-5 py-3">
                                    <div class="w-48 flex items-center gap-3">
                                        <div class="data">
                                            <p class="font-normal text-sm text-gray-900">E101</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="p-5 whitespace-nowrap text-sm leading-6 font-medium text-gray-900">15:40:00 s/d 18:10:00</td>
                                <td class="p-5 whitespace-nowrap text-sm leading-6 font-medium text-gray-900"> 4</td>
                            </tr>
                            <tr class="bg-white transition-all duration-500 hover:bg-gray-50">
                                <td class="p-5 whitespace-nowrap text-sm leading-6 font-medium text-gray-900 text-center"> KAMIS </td>
                                <td class="p-5 whitespace-nowrap text-sm leading-6 font-medium text-gray-900"> SISTEM CERDAS </td>
                                <td class=" px-5 py-3">
                                    <div class="w-48 flex items-center gap-3">
                                        <div class="data">
                                            <p class="font-normal text-sm text-gray-900">E101</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="p-5 whitespace-nowrap text-sm leading-6 font-medium text-gray-900">07:00:00 s/d 09:30:00</td>
                                <td class="p-5 whitespace-nowrap text-sm leading-6 font-medium text-gray-900">3</td>
                            </tr>
                            <tr class="bg-white transition-all duration-500 hover:bg-gray-50">
                                <td class="p-5 whitespace-nowrap text-sm leading-6 font-medium text-gray-900 text-center"> JUMAT </td>
                                <td class="p-5 whitespace-nowrap text-sm leading-6 font-medium text-gray-900"> ANALISIS DAN STRATEGI ALGORITMA </td>
                                <td class=" px-5 py-3">
                                    <div class="w-48 flex items-center gap-3">
                                        <div class="data">
                                            <p class="font-normal text-sm text-gray-900">E101</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="p-5 whitespace-nowrap text-sm leading-6 font-medium text-gray-900">07:00:00 s/d 09:30:00</td>
                                <td class="p-5 whitespace-nowrap text-sm leading-6 font-medium text-gray-900">3</td>
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

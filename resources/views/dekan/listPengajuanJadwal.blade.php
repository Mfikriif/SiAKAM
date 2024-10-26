<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @vite('resources/css/app.css')
    <title>List Pengajuan Jadwal Kuliah</title>
</head>

<body class="bg-gradient-to-r from-fuchsia-800 from-1% to bg-pink-500 ">
    <nav class="bg-black" x-data="{ isOpen: false }">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex h-16 items-center justify-between">
                <div class="flex items-center">
                    <a href="{{ route('dekan.dashboard') }}">
                        <div class="flex">
                            <img class="h-9 w-8" src="{{ asset('undipLogo.png') }}" alt="Your Company">
                            <h3 class="mt-1.5 ml-5 text-white">SiAKAM Undip</h3>
                        </div>
                    </a>
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
                                    <img class="h-8 w-8 rounded-full" src="{{ asset('firmanUtina.png') }}"
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
            <p class="font-bold">PENGAJUAN JADWAL</p>
            <a href="{{ route('dekan.dashboard') }}">
                <div class="flex">
                    <img src="{{ asset('home-outline.svg') }}" alt="">
                    <p class="ml-2">Dasbor / Pengajuan Jadwal</p>
                </div>
            </a>
        </div>
    </section>


    <section class="w-2/3 mx-auto relative top-36 bg-white rounded-lg pt-5 " id="body">
        <div class="container-table ">
            <div id="table-list">

                <h2 class="text-2xl text-center mx-auto max-w-64 ">LIST PENGAJUAN JADWAL </h2>

                <div class=" flex justify-end mt-5 mr-16">
                    <div id="input-text">
                        <input class="bg-[#002687] rounded-l-xl h-8 mr-1 text-white" placeholder="Search"
                            type="text">
                    </div>
                    <div id="button-search">
                        <button class="bg-[#002687] h-8 w-8 rounded-r-xl pl-2 "><img src="{{ asset('searchLogo.svg') }}"
                                alt=""></button>
                    </div>
                </div>

                <table class="w-11/12 mx-auto text-center mt-10 border-separate border-spacing-y-3 pb-8">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>PROGRAM STUDI</th>
                            <th>TAHUN AKADEMIK</th>
                            <th>AKSI</th>
                        </tr>

                    </thead>
                    <tbody>
                        <tr>
                            <td>1. </td>
                            <td>S1-TEKNIK INFORMATIKA</td>
                            <td>2024/2025</td>
                            <td>
                                <button class="btn-detail">Detail</button>
                            </td>
                        </tr>
                        <tr>
                            <td>2.</td>
                            <td>S1-BIOLOGI</td>
                            <td>2024/2025</td>
                            <td>
                                <button class="btn-detail">Detail</button>
                            </td>
                        </tr>
                        <tr>
                            <td>3.</td>
                            <td>S1-BIOTEKNOLOGI</td>
                            <td>2024/2025</td>
                            <td>
                                <button class="btn-detail">Detail</button>
                            </td>
                        </tr>
                        <tr>
                            <td>4.</td>
                            <td>S1-FISIKA</td>
                            <td>2024/2025</td>
                            <td>
                                <button class="btn-detail">Detail</button>
                            </td>
                        </tr>
                        <tr>
                            <td>5.</td>
                            <td>S1-MATEMATIKA</td>
                            <td>2024/2025</td>
                            <td>
                                <button class="btn-detail">Detail</button>
                            </td>
                        </tr>
                        <tr>
                            <td>6.</td>
                            <td>S1-STATISTIKA</td>
                            <td>2024/2025</td>
                            <td>
                                <button class="btn-detail">Detail</button>
                            </td>
                        </tr>
                        <tr>
                            <td>7.</td>
                            <td>S1-KIMIA</td>
                            <td>2024/2025</td>
                            <td>
                                <button class="btn-detail">Detail</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
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

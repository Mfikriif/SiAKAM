<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://rsms.me/inter/inter.css">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @vite('resources/css/app.css')
    <title>dashboard Kaprodi</title>

</head>

<body class="bg-gradient-to-r from-fuchsia-800 from-1% to bg-pink-500 ">
    <nav class="bg-black" x-data="{ isOpen: false }">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex h-16 items-center justify-between">
                <div class="flex">
                    <a href="{{ route('kaprodi.dashboard') }}" class="flex items-center">
                        <img class="h-9 w-8" src="{{ asset('undipLogo.png') }}" alt="Your Company">
                        <h3 class="ml-2 text-white">SiAKAM Undip</h3>
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
                            <h3 class="ml-3 text-white">Muhammad Ajisadda Firdaus</h3>

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
    <section>
        <div class=" w-2/3 mx-auto">
            <div class="text-white flex justify-between mt-10 text-sm">
                <p class="">Dasbor</p>
                <p class="">Home / Dasbor</p>
            </div>
            <h1 class="text-white w-80 text-4xl text-start mt-16">Selamat
                Datang,
            </h1>
            <h1 class="text-white w-101 h-20 text-4xl text-start"> Muhammad Ajisadda Firdaus!</h1>
            <div class="bg-white rounded-lg mt-10">
                <div class="p-7">
                    <div class="flex justify-between h-72">
                        <div class="flex w-2/4">
                            <div class=" w-72">
                                <p class="  font-semibold text-gray-700 w-full">Profil
                                    Ketua Program Studi
                                </p>

                                <img class="rounded-full ml-2 mt-5 w-36 h-36" src="{{ asset('profilPembimbing.png') }}"
                                    alt="">
                            </div>
                            <div class="text-base text-gray-500 mt-6 tracking-wide w-96">
                                <p>Muhammad Ajisadda Firdaus <br>
                                    199603032024061003 <br>
                                    msaddafirdaus@kaprodi.undip.ac.id <br>
                                    msaddafirdaus@gmail.com <br>
                                    085872251414
                                </p>

                                <br>
                                <p>Fakultas Sains Dan Matematika <span class="font-bold">(FSM)</span></p>
                                <p>Departemen Ilmu Komputer/Informatika</p>
                                <p>S1 Informatika</p>
                            </div>
                        </div>

                        <div class="border border-slate-300"></div>

                        <div class=" w-2/4">
                            <div class="pt-4 flex flex-wrap justify-center items-center gap-7 mt-5">
                                <div class="border border-gray-500 w-36 h-20 flex flex-col items-center rounded-xl">
                                    <p class="pt-2 text-xs text-gray-500">Total Mahasiswa</p>
                                    <p class="pt-2 font-semibold text-lg">1340</p>
                                </div>
                                <div class="border border-gray-500 w-36 h-20 flex flex-col items-center rounded-xl">
                                    <p class="pt-2 text-xs text-gray-500">Total Dosen</p>
                                    <p class="pt-2 font-semibold text-lg">258</p>
                                </div>
                                <div class="border border-gray-500 w-36 h-20 flex flex-col items-center rounded-xl">
                                    <p class="pt-2 text-xs text-gray-500">Retata IPK</p>
                                    <p class="pt-2 font-semibold text-lg">3.23</p>
                                </div>
                                <div class="border border-gray-500 w-36 h-20 flex flex-col items-center rounded-xl">
                                    <p class="pt-2 text-xs text-gray-500">Belum Bayar UKT</p>
                                    <p class="pt-2 font-semibold text-lg">234</p>
                                </div>
                                <div class="border border-gray-500 w-36 h-20 flex flex-col items-center rounded-xl">
                                    <p class="pt-2 text-xs text-gray-500">Belum mengisi IRS</p>
                                    <p class="pt-2 font-semibold text-lg">120</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="menu-container" class=" w-2/3 mx-auto">
            <div id="menu" class="w-100 mt-7 grid grid-cols-2 text-lg">
                <a href="{{ route('kaprodi.listPengajuan') }}">
                    <button class="flex h-20 w-64 border text-white items-center rounded-md ">
                        <img class="w-11 mr-2 ml-4" src="{{ asset('classroom.svg') }}" alt="">
                        <p class="mx-auto w-36">Pembuatan Jadwal</p>
                    </button>
                </a>
            </div>
        </div>
    </section>

    <footer class="bg-[#D9D9D9] bg-opacity-30 mt-20">
        <div class="flex w-2/3 h-9 mx-auto justify-between items-center text-white ">
            <p>TIM SiAKAM <span class="font-semibold"> Universitas Diponegoro</span></p>
            <p>Dibangun dengan penuh kekhawatiran 🔥🔥</p>
        </div>
    </footer>
</body>

</html>

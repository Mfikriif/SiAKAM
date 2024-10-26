<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
    <!-- Tambahkan SweetAlert2 CSS dan JS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <title>Her-Registrasi</title>
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
            <p class="font-bold">Her-Registrasi</p>
            <a href="{{ route('mahasiswa.dashboard') }}">
                <div class="flex">
                    <img src="{{ asset('home-outline.svg') }}" alt="">
                    <p class="ml-2">Dasbor / Her-Registrasi </p>
                </div>
            </a>
        </div>
        <div class="flex flex-col container mx-auto mt-24">
            <p class="text-white text-center font-bold text-3xl"> Pilih Status Akademik </p>
            <p class="text-white text-center font-normal text-xl mt-3"> Silahkan Pilih Salah Satu Status Akademik
                Berikut Untuk Semester Ini</p>
        </div>
    </section>

    <div class="flex justify-center space-x-10 mt-32">
        <!-- Container Aktif -->
        <div class="bg-white p-6 rounded-lg shadow-lg text-center w-1/3">
            <img src="{{ asset('aktif.svg') }}" alt="" class="mx-auto mb-4 w-16 h-16">
            <div class="text-4xl font-bold mb-2">
                Aktif
            </div>
            <p class="text-gray-700 mb-4">
                Anda akan mengikuti kegiatan perkuliahan pada semester ini serta mengisi Isian Rencana Studi (IRS).
            </p>
            <button
                onclick="showConfirm('Anda yakin memilih status Aktif?','Anda akan mengikuti kegiatan perkuliahan dan mengisi IRS','warning')"
                class="bg-blue-900 text-white font-normal py-2 px-6 rounded-lg">
                Pilih
            </button>
        </div>

        <!-- Container Cuti -->
        <div class="bg-white p-6 rounded-lg shadow-lg text-center w-1/3">
            <img src="{{ asset('cuti.svg') }}" alt="" class="mx-auto mb-4 w-16 h-16">
            <div class="text-4xl font-bold mb-2">
                Cuti
            </div>
            <p class="text-gray-700 mb-4">
                Menghentikan kuliah sementara untuk semester ini tanpa kehilangan status sebagai mahasiswa Undip.
            </p>
            <button
                onclick="showAlert('Anda yakin memilih status Cuti?','Anda akan menghentikan perkuliahan untuk semester ini!','warning')"
                class="bg-blue-900 text-white font-normal py-2 px-6 rounded-lg">
                Pilih
            </button>
        </div>
    </div>

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

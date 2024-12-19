<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>List Pengajuan IRS Mahasiswa</title>
    @vite('resources/css/app.css')
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/collapse@3.x.x/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @vite('resources/js/app.js')
</head>

<body class="flex flex-col min-h-screen bg-gradient-to-r from-fuchsia-800 to-pink-500">
    <nav class="bg-black" x-data="{ isOpen: false }">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex h-16 items-center justify-between">
                <div class="flex items-center">
                    <a href="{{ route('dosenwali.dashboard') }}">
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
                                    <img class="h-8 w-8 rounded-full object-cover" 
                                        src="{{ $user->profile_photo && file_exists(public_path($user->profile_photo)) ? asset($user->profile_photo) : asset('images/profiles/default_photo.jpg') }}" 
                                        alt="User Photo">
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
            <p class="font-bold">REKAP MAHASISWA PERWALIAN</p>
            <a href="{{ route('dosenwali.dashboard') }}">
                <div class="flex">
                    <img src="{{ asset('home-outline.svg') }}" alt="">
                    <p class="ml-2">Dasbor / Rekap Perwalian</p>
                </div>
            </a>
        </div>
    </section>

    <main class="flex-1">
        <section class="w-2/3 mx-auto relative top-36 bg-white rounded-lg pt-5 pb-5" id="body">
            <div class="container-table">
                <h2 class="text-2xl text-center mx-auto max-w-64 mt-5 mb-8">REKAP MAHASISWA PERWALIAN</h2>


                <!-- Daftar Mahasiswa -->
                <div class="flex flex-col space-y-4" x-data="{ openIndex: null, openModal: false, currentData: {} }">
                    <div class="overflow-hidden border rounded-lg border-gray-300 w-11/12 mx-auto my-6 pt-3 px-3">

                    <!-- Statistik -->
                    <div class="bg-gray-50 rounded-lg p-4 shadow-md mb-6">
                        <p class="text-lg font-semibold text-gray-800">Statistik Perwalian</p>
                        <ul class="mt-2 text-gray-700">
                            <li>Jumlah mahasiswa yang sudah mengisi IRS: <span class="text-green-500">{{ $jumlahSudahMengisi }}</span></li>
                            <li>Jumlah mahasiswa yang belum mengisi IRS: <span class="text-red-500">{{ $jumlahBelumMengisi }}</span></li>
                        </ul>
                    </div>
                    <p class="text-lg font-semibold text-gray-800">Mahasiswa yang Sudah Mengisi IRS</p>

                    @if ($mahasiswaSudahMengisi->isNotEmpty())
                        <div class="bg-gray-50 rounded-lg p-4 shadow-md mb-3">
                            <ul class="mt-2 text-gray-700">
                                @foreach ($mahasiswaSudahMengisi as $nama)
                                    <li class="text-gray-700">{{ $nama }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @else
                        <div class="bg-gray-50 rounded-lg p-4 shadow-md mb-6">
                            <p class="text-gray-700">Belum ada mahasiswa yang mengisi IRS.</p>
                        </div>
                    @endif
                    

                        <p class="text-lg font-semibold text-gray-800">Mahasiswa yang Belum Mengisi IRS</p>
                        @foreach ($mahasiswaBelumMengisi as $nama)
                        <!-- Daftar Mahasiswa yang Belum Mengisi -->
                        <div class="bg-gray-50 rounded-lg p-4 shadow-md mb-3">

                            <ul class="mt-2 text-gray-700">
                                @if ($mahasiswaBelumMengisi->isEmpty())
                                    <li class="text-green-500">Semua mahasiswa telah mengisi IRS.</li>
                                @else
                                        <li>{{ $nama }}</li>
                                @endif
                            </ul>
                        </div>
                    @endforeach
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer class="bg-[#D9D9D9] bg-opacity-30 mt-52">
        <div class="flex w-2/3 h-20 mx-auto justify-between items-center text-white">
            <p>TIM SiAKAM <span class="font-semibold"> Universitas Diponegoro</span></p>
            <p>Dibangun dengan penuh kekhawatiran 🔥🔥</p>
        </div>
    </footer>
</body>
</html>
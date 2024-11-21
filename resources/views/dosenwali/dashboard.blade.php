<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Dasbor Dosen Wali</title>
    <link rel="stylesheet" href="https://rsms.me/inter/inter.css">
    @vite('resources/css/app.css')
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    @vite('resources/js/app.js')
</head>

<body class="flex flex-col min-h-screen bg-gradient-to-r from-fuchsia-800 to-pink-500">
    <!-- Navbar -->
    <nav class="bg-black" x-data="{ isOpen: false }">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex h-16 items-center justify-between">
                <div class="flex items-center">
                    <div class="flex">
                        <img class="h-9 w-8" src="{{ asset('undipLogo.png') }}" alt="Your Company">
                        <h3 class="mt-1.5 ml-5 text-white">SiAKAM Undip</h3>
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
                            <h3 class="ml-3 text-white">{{ $userName }}</h3>
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

    <!-- Main content -->
    <main class="flex-1">
        <section>
            <div class=" w-2/3 mx-auto">
                <div class="text-white flex justify-between mt-20 text-lg">
                    <p class="">Dasbor</p>
                    <p class="">Beranda / Dasbor</p>
                </div>
                <h1 class="text-white text-5xl text-start mt-16">Selamat Datang,</h1>
                <h1 class="text-white text-5xl text-start mt-2 leading-normal">
                    <span id="typing-text"></span>!
                </h1>
                <div class="bg-white rounded-lg mt-10">
                    <div class="p-7">
                        <div class="flex justify-between h-72">
                            <div class="flex w-2/4">
                                <div class=" w-72">
                                    <p class="  font-semibold text-gray-700 w-full">Profil
                                        Pembimbing
                                        Akademik
                                    </p>
    
                                    <img class="rounded-full ml-2 mt-5 w-36 h-36 object-cover" 
                                        src="{{ $user->profile_photo && file_exists(public_path($user->profile_photo)) ? asset($user->profile_photo) : asset('images/profiles/default_photo.jpg') }}" 
                                        alt="User Photo">
                                </div>
                                <div class="text-base text-gray-500 mt-6 tracking-wide w-96">
                                    <p>{{ $userName }}<br>
                                        {{ $userNIP }} <br>
                                        {{ $userEmail }} <br>
                                        {{ $nomorHP }}
                                    </p>
    
                                    <br>
                                    <p>{{ $jurusan }}</p>
                                    <p>Fakultas Sains Dan Matematika <span class="font-bold">(FSM)</span></p>
                                    <p>Universitas Diponegoro</p>
                                </div>
                            </div>
    
                            <div class="border border-slate-300"></div>
    
                            <div class=" w-2/4">
                                <p class="ml-4 text-gray-500 tracking-wide ">Jadwal Mendatang</p>
                                <div class="mt-5">
                                    <div class="flex ml-5">
                                        <img src="{{ asset('Ellipse1.svg') }}" alt="">
                                        <p class="text-gray-500 tracking-wide ml-3">Pemrograman Berorientasi Objek C</p>
                                        <p class="text-gray-500 ml-4">07.00 s/d 09.30</p>
                                        <p class="text-gray-500 ml-4">E101</p>
                                    </div>
                                    <div class="flex ml-5">
                                        <img src="{{ asset('Ellipse1.svg') }}" alt="">
                                        <p class="text-gray-500 tracking-wide ml-3">Pemrograman Berorientasi Objek A</p>
                                        <p class="text-gray-500 ml-4">13.00 s/d 15.30</p>
                                        <p class="text-gray-500 ml-4">E101</p>
                                    </div>
                                    <div class="flex ml-5">
                                        <img src="{{ asset('Ellipse1.svg') }}" alt="">
                                        <p class="text-gray-500 tracking-wide ml-3">Pemrograman Berorientasi Objek B</p>
                                        <p class="text-gray-500 ml-4">15.40 s/d 18.10</p>
                                        <p class="text-gray-500 ml-4">E101</p>
                                    </div>
                                </div>
    
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    
            <div class="w-2/3 mx-auto mt-7 grid grid-cols-4 text-lg">
                <a href="{{ route('dosenwali.listPengajuanIRS') }}">
                    <button class="flex h-20 w-48 border text-white items-center rounded-md justify-center">
                        <img class="w-11 mr-2" src="{{ asset('irsLogo.svg') }}" alt="">
                        <p>Pengajuan IRS</p>
                    </button>
                </a>
                <a href="{{ route('dosenwali.mahasiswaPerwalian') }}">
                    <button class="flex h-20 w-64 border text-white items-center rounded-md justify-center ">
                        <img class="h-11 w-20  " src="{{ asset('logoMHS.svg') }}" alt="">
                        <p class=" text-center mr-5">Mahasiswa Perwalian</p>
                    </button>
                </a>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer class="bg-[#D9D9D9] bg-opacity-30 mt-auto">
        <div class="flex w-2/3 h-20 mx-auto justify-between items-center text-white">
            <p>TIM SiAKAM <span class="font-semibold"> Universitas Diponegoro</span></p>
            <p>Dibangun dengan penuh kekhawatiran 🔥🔥</p>
        </div>
    </footer>

    <script>
        const text = "{{ $userName }}";
        const typingText = document.getElementById("typing-text");
        let index = 0;
    
        function typeEffect() {
            if (index < text.length) {
                typingText.innerHTML += text.charAt(index);
                index++;
                setTimeout(typeEffect, 75);
            }
        }
        window.onload = typeEffect;
    </script>
</body>

</html>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Dasbor Mahasiswa</title>
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
            <div class="w-2/3 mx-auto">
                <div class="text-white flex justify-between mt-20 text-lg">
                    <p>Dasbor</p>
                    <p>Beranda / Dasbor</p>
                </div>
                <h1 class="text-white text-5xl text-start mt-16">Selamat Datang,</h1>
                <h1 class="text-white text-5xl text-start mt-2 leading-normal">
                    <span id="typing-text"></span>!
                </h1>
                <div class="bg-white rounded-lg mt-10">
                    <div class="p-7">
                        <p class="ml-4 font-semibold text-gray-700">Profil Mahasiswa</p>
                        <div class="flex">
                            <div class="flex w-2/4">
                                <img class="rounded-full ml-2 mt-5 w-36 h-36 object-cover" 
                                    src="{{ $user->profile_photo && file_exists(public_path($user->profile_photo)) ? asset($user->profile_photo) : asset('images/profiles/default_photo.jpg') }}" 
                                    alt="User Photo">
                                <div class="ml-6 text-base text-gray-500 mt-6 tracking-wide">
                                    <p>{{ $user->name }} <br>
                                        {{ $nim }} <br>
                                        {{ $user->email }} <br>
                                        {{ $nomorHP }}
                                    </p>
                                    <br>
                                    <p>{{ $jurusan }}</p>
                                    <p>Fakultas Sains Dan Matematika <span class="font-bold">(FSM)</span></p>
                                    <p>Universitas Diponegoro</p>
                                </div>
                            </div>
                            <div class="mx-auto mt-6 w-2/4">
                                <div class="w-32 mx-auto text-base">
                                    <div class="flex text-gray-500 w-44 items-center">
                                        <img class="w-5 h-4" src="{{ asset('trophy.svg') }}" alt="">
                                        <h1 class="ml-1">Prestasi Akademik</h1>
                                    </div>
                                    <div class="flex justify-between ml-1 mt-4 text-gray-500">
                                        <div>
                                            <p>IPk</p>
                                            <p>4.0</p>
                                        </div>
                                        <div class="w-px h-12 border-solid border border-slate-400"></div>
                                        <div>
                                            <p>SKSk</p>
                                            <p class="ml-1">87</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="h-px w-full border-solid border-slate-400 border mt-3 mx-auto"></div>
                                <div class="w-96 mx-auto">
                                    <div class="text-center text-xs font-light mt-2">
                                        <p><span class="font-semibold text-gray-500 text-xs">Dosen wali:</span> {{ $namaDoswal }}</p>
                                        <p><span class="font-semibold text-gray-500 text-xs">NIP:</span> {{ $nipDoswal }}</p>
                                    </div>
                                    <div class="flex justify-between mt-4">
                                        <div class="text-xs text-gray-500">
                                            <p>Semester Akademik</p>
                                            <p class="mt-2">2024/2025 Gasal</p>
                                        </div>
                                        <div class="w-px h-9 border-solid border-slate-400 border"></div>
                                        <div class="text-xs text-gray-500">
                                            <p>Semester Studi</p>
                                            <p class="mt-2 ml-9">5</p>
                                        </div>
                                        <div class="w-px h-9 border-solid border-slate-400 border"></div>
                                        <div class="text-xs text-gray-500">
                                            <p>Status Akademik</p>
                                            <p class="mt-2 bg-green-600 w-9 text-center text-white rounded-sm mx-auto">AKTIF</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="w-2/3 mx-auto mt-7 grid grid-cols-4 text-lg">
                <a href="{{ route('mahasiswa.herReg') }}" class="flex h-20 w-48 border text-white items-center rounded-md justify-center">
                    <img class="w-11 mr-2" src="{{ asset('logoMHS.svg') }}" alt="">
                    <p>Her-Registrasi</p>
                </a>
                <a href="{{ route('mahasiswa.irs') }}" class="flex h-20 w-48 border text-white items-center rounded-md justify-center">
                    <img class="h-11 w-11 pl-2" src="{{ asset('irsLogo.svg') }}" alt="">
                    <p class="ml-2">IRS Mahasiswa</p>
                </a>
                <a href="{{ route('mahasiswa.khs') }}" class="flex h-20 w-48 border text-white items-center rounded-md justify-center">
                    <img class="w-11 pl-2" src="{{ asset('khsLogo.svg') }}" alt="">
                    <p class="ml-2">KHS Mahasiswa</p>
                </a>
                <a href="{{ route('mahasiswa.jadwalKuliah') }}" class="flex h-20 w-48 border text-white items-center rounded-md justify-center">
                    <img class="w-11 pl-2" src="{{ asset('calendarLogo.svg') }}" alt="">
                    <p class="ml-2">Jadwal Kuliah</p>
                </a>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer class="bg-[#D9D9D9] bg-opacity-30 mt-24">
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
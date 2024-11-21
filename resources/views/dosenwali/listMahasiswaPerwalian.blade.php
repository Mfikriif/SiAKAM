<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>List Mahasiswa Perwalian</title>
    @vite('resources/css/app.css')
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
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
        <div class="w-2/3 mx-auto flex justify-between text-lg text-white">
            <p class="font-bold">MAHASISWA PERWALIAN</p>
            <a href="{{ route('dosenwali.dashboard') }}">
                <div class="flex items-center">
                    <img src="{{ asset('arrow-left.png') }}" alt="" class="w-8 h-8 mr-1">
                    <p>Dasbor / Mahasiswa Perwalian</p>
                </div>
            </a>
        </div>
    </section>

    <!-- Main content -->
    <main class="flex-1">
        <section class="w-2/3 mx-auto relative top-36 bg-white rounded-lg pt-5 " id="body">
            <div class="container-table ">
                <div id="table-list">
                    <h2 class="text-2xl text-center mx-auto max-w-64 mt-5">LIST MAHASISWA PERWALIAN</h2>
                    <div class="flex justify-end mt-5 mr-16">
                        <form method="GET" action="{{ route('dosenwali.mahasiswaPerwalian') }}" class="flex">
                            <!-- Dropdown for 'Angkatan' -->
                            <div id="dropdown">
                                <select name="angkatan" id="angkatan"
                                    class="bg-white border-gray-300 rounded-l-xl h-8 w-40 mr-3 text-sm py-px">
                                    <option value="" disabled selected>Angkatan</option>
                                    <option value="2019" {{ request('angkatan') == '2019' ? 'selected' : '' }}>2019
                                    </option>
                                    <option value="2020" {{ request('angkatan') == '2020' ? 'selected' : '' }}>2020
                                    </option>
                                    <option value="2021" {{ request('angkatan') == '2021' ? 'selected' : '' }}>2021
                                    </option>
                                    <option value="2022" {{ request('angkatan') == '2022' ? 'selected' : '' }}>2022
                                    </option>
                                    <option value="2023" {{ request('angkatan') == '2023' ? 'selected' : '' }}>2023
                                    </option>
                                    <option value="2024" {{ request('angkatan') == '2024' ? 'selected' : '' }}>2024
                                    </option>
                                </select>
                            </div>
    
                            <!-- Search input field -->
                            <div id="input-text">
                                <input name="search" value="{{ request('search') }}"
                                    class="bg-[#002687] text-white h-8 rounded-l-xl pl-3" placeholder="Search.."
                                    type="text">
                            </div>
    
                            <!-- Search button -->
                            <div id="button-search">
                                <button class="bg-[#002687] h-8 w-8 rounded-r-xl flex items-center justify-center"
                                    type="submit">
                                    <img src="{{ asset('searchLogo.svg') }}" alt="">
                                </button>
                            </div>
                        </form>
                    </div>
    
                    <table class="w-11/12 mx-auto text-center mt-10 border-separate border-spacing-y-3 pb-8">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th class="text-left pl-4">NIM</th>
                                <th class="text-left pl-4">NAMA</th>
                                <th>ANGKATAN</th>
                                <th>SKS</th>
                                <th>STATUS</th>
                            </tr>
    
                        </thead>
                        <tbody>
                            @foreach ($mahasiswaPerwalian as $index => $mahasiswa)
                                <tr>
                                    <td>{{ $index + 1 }}.</td>
                                    <td class="text-left pl-4">{{ $mahasiswa->nim }}</td>
                                    <td class="text-left pl-4">{{ $mahasiswa->nama }}</td>
                                    <td>{{ $mahasiswa->angkatan }}</td>
                                    <td>{{ $mahasiswa->sks }} SKS</td>
                                    <td>
                                        @if ($mahasiswa->status == 1)
                                            AKTIF
                                        @else
                                            TIDAK AKTIF
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
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

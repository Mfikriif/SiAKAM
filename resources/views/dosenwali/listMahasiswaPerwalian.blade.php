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
        <section class="w-2/3 mx-auto relative top-36 bg-white rounded-lg pt-5 pb-5" id="body">
            <div class="container-table px-6">
                <div id="table-list">
                    <!-- Heading -->
                    <h2 class="text-2xl text-center mx-auto max-w-64 mt-5 mb-8">LIST MAHASISWA PERWALIAN</h2>

                    <!-- Filter and Search -->
                    <div class="flex justify-end mb-6">
                        <form method="GET" action="{{ route('dosenwali.mahasiswaPerwalian') }}" class="flex items-center space-x-4">
                            <select name="angkatan" id="angkatan"
                                class="bg-white border border-gray-300 rounded-lg h-10 px-4 text-sm focus:ring focus:ring-blue-500 focus:outline-none">
                                <option value="">-- Angkatan --</option>
                                @for ($year = 2019; $year <= now()->year; $year++)
                                    <option value="{{ $year }}" {{ request('angkatan') == $year ? 'selected' : '' }}>
                                        {{ $year }}
                                    </option>
                                @endfor
                            </select>

                            <div class="flex">
                                <input name="search" value="{{ request('search') }}" type="text"
                                    class="bg-[#002687] text-white h-10 px-4 rounded-l-lg text-sm focus:ring focus:ring-blue-500 focus:outline-none"
                                    placeholder="Search...">
                                <button
                                    class="bg-[#002687] h-10 w-10 flex items-center justify-center rounded-r-lg hover:bg-blue-700 focus:ring focus:ring-blue-500">
                                    <img src="{{ asset('searchLogo.svg') }}" alt="Search Icon">
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Accordion List -->
                    <div class="flex flex-col space-y-4" x-data="{ openIndex: null }">
                        @foreach ($mahasiswaPerwalian as $index => $mahasiswa)
                            <div class="overflow-hidden border rounded-lg border-gray-300 bg-gray-50">
                                <!-- Accordion Header -->
                                <div class="flex justify-between items-center p-4 cursor-pointer hover:bg-gray-100 transition duration-200"
                                    :class="openIndex === {{ $index }} ? 'bg-gray-100' : ''"
                                    @click="openIndex = openIndex === {{ $index }} ? null : {{ $index }}">
                                    <div class="flex items-center space-x-4">
                                        <span class="text-gray-800 font-semibold">{{ $index + 1 }}.</span>
                                        <span class="text-gray-800">{{ $mahasiswa->nim }}</span>
                                        <span class="text-gray-700">{{ $mahasiswa->nama }}</span>
                                        <span class="text-blue-500">Angkatan {{ $mahasiswa->angkatan }}</span>
                                    </div>
                                    <svg :class="openIndex === {{ $index }} ? 'transform rotate-180' : ''"
                                        class="h-5 w-5 text-gray-600 transition-transform" xmlns="http://www.w3.org/2000/svg"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7" />
                                    </svg>
                                </div>

                                <!-- Accordion Content -->
                                <div x-show="openIndex === {{ $index }}" x-collapse class="transition-all duration-300">
                                    <div class="p-6 bg-white rounded-b-lg shadow-inner overflow-auto">
                                        <!-- Subheading -->
                                        <h3 class="font-semibold text-lg text-gray-800 mb-4">Transkrip Mahasiswa</h3>

                                        <!-- Print Button for Dosen Wali -->
                                        <div class="text-right mb-4">
                                            <a href="{{ route('dosenwali.printKhs', ['nim' => $mahasiswa->nim]) }}"
                                            class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition focus:outline-none focus:ring focus:ring-blue-300">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16h8M8 12h8M4 8h16M4 4h16"></path>
                                                </svg>
                                                Print Transkrip
                                            </a>
                                        </div>

                                        <!-- Table -->
                                        @if ($mahasiswa->khs->isNotEmpty())
                                            <table class="w-full text-left text-sm text-gray-600">
                                                <thead class="bg-gray-100 text-gray-800 border-b border-gray-300">
                                                    <tr>
                                                        <th class="py-3 px-4 text-center">No</th>
                                                        <th class="py-3 px-4 text-left">Kode MK</th>
                                                        <th class="py-3 px-4 text-left">Nama Mata Kuliah</th>
                                                        <th class="py-3 px-4 text-center">Semester</th>
                                                        <th class="py-3 px-4 text-center">SKS</th>
                                                        <th class="py-3 px-4 text-center">Nilai</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="divide-y divide-gray-200">
                                                    @foreach ($mahasiswa->khs as $key => $khs)
                                                        <tr>
                                                            <td class="py-3 px-4 text-center">{{ $key + 1 }}</td>
                                                            <td class="py-3 px-4">{{ $khs->kode_mk }}</td>
                                                            <td class="py-3 px-4">{{ $khs->nama_mk }}</td>
                                                            <td class="py-3 px-4 text-center">{{ $khs->semester }}</td>
                                                            <td class="py-3 px-4 text-center">{{ $khs->sks }}</td>
                                                            <td class="py-3 px-4 text-center">{{ $khs->nilai_huruf }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        @else
                                            <p class="text-center text-gray-500">Belum ada data KHS.</p>
                                        @endif
                                    </div>
                                </div>
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

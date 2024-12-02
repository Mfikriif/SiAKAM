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
            <p class="font-bold">IRS MAHASISWA</p>
            <a href="{{ route('dosenwali.dashboard') }}">
                <div class="flex">
                    <img src="{{ asset('home-outline.svg') }}" alt="">
                    <p class="ml-2">Dasbor / IRS Mahasiswa</p>
                </div>
            </a>
        </div>
    </section>

    <main class="flex-1">
        <section class="w-2/3 mx-auto relative top-36 bg-white rounded-lg pt-5 pb-5" id="body">
            <div class="container-table ">
                <div id="table-list">
                    <h2 class="text-2xl text-center mx-auto max-w-64 mt-5 mb-8">LIST PENGAJUAN IRS MAHASISWA</h2>
                    <div class=" flex justify-end mt-5 mr-16">
                        <form method="GET" action="{{ route('dosenwali.listPengajuanIRS') }}" class="flex">
                            <div>
                                <select name="status" id="status" class="bg-white border-gray-300 rounded-xl h-8 w-40 mr-3 text-sm py-px">
                                    <option value="">-- Status -- </option>
                                    <option value="Disetujui" {{ request('status') == 'Disetujui' ? 'selected' : '' }}>Disetujui
                                    </option>
                                    <option value="Belum Disetujui" {{ request('status') == 'Belum Disetujui' ? 'selected' : '' }}>Belum Disetujui
                                    </option>
                                </select>
                            </div>

                            <div>
                                <select name="angkatan" id="angkatan" class="bg-white border-gray-300 rounded-xl h-8 w-40 mr-3 text-sm py-px">
                                    <option value="">-- Angkatan -- </option>
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
    
                            <div>
                                <input name="search" value="{{ request('search') }}"
                                    class="bg-[#002687] text-white h-8 rounded-l-xl pl-3" placeholder="Search.."
                                    type="text">
                            </div>
    
                            <div>
                                <button class="bg-[#002687] h-8 w-8 rounded-r-xl flex items-center justify-center"
                                    type="submit">
                                    <img src="{{ asset('searchLogo.svg') }}" alt="">
                                </button>
                            </div>
                        </form>
                    </div>
    
                    <div class="flex flex-col space-y-4" x-data="{ openIndex: null, openModal: false, currentData: {} }">
                        <div class="overflow-hidden border rounded-lg border-gray-300 w-11/12 mx-auto my-6 pt-3 px-3">
                            @foreach ($mahasiswaPerwalian as $index => $mahasiswa)
                                <div class="border-b mb-3 rounded-lg overflow-hidden" id="mahasiswa-list">
                                    <!-- Accordion Header -->
                                    <div class="flex justify-between p-4 cursor-pointer bg-gray-50 hover:bg-gray-100 transition-colors duration-300"
                                        :class="openIndex === {{ $index }} ? 'bg-gray-100' : ' '"
                                        @click="openIndex = openIndex === {{ $index }} ? null : {{ $index }}">
                                        <div class="flex justify-between w-full">
                                            <div>
                                                <span class="text-gray-900">{{ $index + 1 }}.</span>
                                                <span class="ml-4">{{ $mahasiswa->nim }}</span>
                                                <span class="ml-4">{{ $mahasiswa->nama }}</span>
                                                <span class="ml-4 text-blue-500">Semester {{ $mahasiswa->semester }}</span>
                                            </div>
                                            <div>
                                                <div class="mr-3" id="status-{{ $mahasiswa->id }}">
                                                    @if ($mahasiswa->irs->first() && $mahasiswa->irs->first()->status === 1)
                                                        <span class="text-green-500">Disetujui</span>
                                                    @else
                                                        <span class="text-yellow-500">Belum Disetujui</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <svg :class="openIndex === {{ $index }} ? 'transform rotate-180' : ''"
                                            class="h-5 w-5 text-gray-600 transition-transform"
                                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </div>
                                    
                                    <!-- Accordion Content -->
                                    <div x-show="openIndex === {{ $index }}" x-collapse class="transition-all duration-300">
                                        <div class="p-5 bg-white rounded-b-lg shadow-inner overflow-auto">
                                        @if($mahasiswa->irs->isNotEmpty())
                                            <div x-data="{ checkAll: false }" class="overflow-hidden w-full overflow-x-auto rounded-md border border-neutral-300">
                                                <table class="w-full text-left text-sm text-neutral-600">
                                                    <thead class="border-b border-neutral-300 bg-grey-100 text-neutral-900">
                                                        <tr class="bg-gray-50">
                                                            <th scope="col"
                                                                class="p-5 text-center whitespace-nowrap text-sm leading-6 font-semibold text-gray-900 capitalize">
                                                                No </th>
                                                            <th scope="col"
                                                                class="p-5 text-left whitespace-nowrap text-sm leading-6 font-semibold text-gray-900 capitalize">
                                                                Kode MK </th>
                                                            <th scope="col"
                                                                class="p-5 text-left whitespace-nowrap text-sm leading-6 font-semibold text-gray-900 capitalize min-w-[150px]">
                                                                Nama </th>
                                                            <th scope="col"
                                                                class="p-5 text-center whitespace-nowrap text-sm leading-6 font-semibold text-gray-900 capitalize">
                                                                Semester </th>
                                                            <th scope="col"
                                                                class="p-5 text-center whitespace-nowrap text-sm leading-6 font-semibold text-gray-900 capitalize">
                                                                SKS </th>
                                                            <th scope="col"
                                                                class="p-5 text-left whitespace-nowrap text-sm leading-6 font-semibold text-gray-900 capitalize">
                                                                Sifat </th>
                                                            <th scope="col"
                                                                class="p-5 text-center whitespace-nowrap text-sm leading-6 font-semibold text-gray-900 capitalize">
                                                                Kelas </th>
                                                            <th scope="col"
                                                                class="p-5 text-center whitespace-nowrap text-sm leading-6 font-semibold text-gray-900 capitalize">
                                                                Ruangan </th>
                                                            <th scope="col"
                                                                class="p-5 text-left whitespace-nowrap text-sm leading-6 font-semibold text-gray-900 capitalize">
                                                                Hari </th>
                                                            <th scope="col"
                                                                class="p-5 text-center whitespace-nowrap text-sm leading-6 font-semibold text-gray-900 capitalize">
                                                                Jam </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="divide-y divide-neutral-0">
                                                        @foreach($mahasiswa->irs as $key => $irs)
                                                            <tr>
                                                                <td
                                                                    class="p-5 whitespace-nowrap text-sm leading-6 font-medium text-gray-900 text-center">
                                                                    {{ $loop->iteration }} </td>
                                                                <td
                                                                    class="p-5 whitespace-nowrap text-sm leading-6 font-medium text-gray-900">
                                                                    {{ $irs->kode_mk }} </td>
                                                                <td class=" px-5 py-3">
                                                                    <div class="w-48 flex items-center gap-3">
                                                                        <div class="data">
                                                                            <p class="font-normal text-sm text-gray-900">
                                                                                {{ $irs->nama_mk }}</p>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td
                                                                    class="text-center whitespace-nowrap text-sm leading-6 font-medium text-gray-900">
                                                                    {{ $irs->semester }} </td>
                                                                <td
                                                                    class="text-center whitespace-nowrap text-sm leading-6 font-medium text-gray-900">
                                                                    {{ $irs->sks }} </td>
                                                                <td
                                                                    class="p-5 whitespace-nowrap text-sm leading-6 font-medium text-gray-900">
                                                                    {{ $irs->JadwalMk->sifat }} </td>
                                                                <td
                                                                    class="p-5 text-center whitespace-nowrap text-sm leading-6 font-medium text-gray-900">
                                                                    {{ $irs->JadwalMk->kelas }} </td>
                                                                <td
                                                                    class="p-5 text-center whitespace-nowrap text-sm leading-6 font-medium text-gray-900">
                                                                    {{ $irs->JadwalMk->ruangan }} </td>
                                                                <td
                                                                    class="p-5 whitespace-nowrap text-sm leading-6 font-medium text-gray-900">
                                                                    {{ $irs->JadwalMk->hari }} </td>
                                                                <td
                                                                    class="p-5 text-center whitespace-nowrap text-sm leading-6 font-medium text-gray-900">
                                                                    {{ $irs->JadwalMk->jam_mulai }} - {{ $irs->JadwalMk->jam_selesai }} </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="flex justify-end mt-4 space-x-4" id="aksi-{{ $irs->mahasiswa_id }}">
                                                @if ($irs->status === 0)
                                                    <button onclick="approveCancelIrs({{ $irs->mahasiswa_id }}, 'approve')" class="bg-transparent hover:bg-green-500 text-green-700 font-semibold hover:text-white py-1 px-2 border border-green-500 hover:border-transparent rounded">Setujui</button>
                                                @elseif ($irs->status === 1)
                                                    <button onclick="approveCancelIrs({{ $irs->mahasiswa_id }}, 'cancel')" class="bg-transparent hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-1 px-2 border border-blue-500 hover:border-transparent rounded">Batalkan Persetujuan</button>
                                                @endif
                                            </div>
                                        @else
                                            <div class="flex justify-center">
                                                <p class="pl-4 py-3">Belum ada data IRS</p>
                                            </div>
                                        @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
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
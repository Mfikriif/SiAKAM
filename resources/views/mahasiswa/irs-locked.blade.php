<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Her-Registrasi</title>
</head>

<body class="bg-gradient-to-r from-fuchsia-800 from-1% to bg-pink-500">
    <!-- Navbar -->
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
                        <h3 class="ml-3 text-white">{{ Auth::user()->name }}</h3>
                        <div class="relative ml-3">
                            <button type="button" @click="isOpen = !isOpen"
                                class="relative flex max-w-xs items-center rounded-full bg-gray-800 text-sm focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800"
                                id="user-menu-button" aria-expanded="false" aria-haspopup="true">
                                <img class="h-8 w-8 rounded-full object-cover" 
                                    src="{{ $user->profile_photo && file_exists(public_path($user->profile_photo)) ? asset($user->profile_photo) : asset('images/profiles/default_photo.jpg') }}" 
                                    alt="User Photo">
                            </button>
                            <div x-show="isOpen" class="absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-md bg-white py-1 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none">
                                <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="block px-4 py-2 text-sm text-gray-700">Logout</a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Header -->
    <section class="relative top-20">
        <div class="w-2/3 mx-auto flex justify-between text-white" id="container-navigation">
            <p class="font-bold">IRS - Locked</p>
            <a href="{{ route('mahasiswa.dashboard') }}">
                <div class="flex">
                    <img src="{{ asset('home-outline.svg') }}" alt="">
                    <p class="ml-2">Dasbor / IRS</p>
                </div>
            </a>
        </div>
    </section>

    <section class="w-11/12 mx-auto relative top-36 bg-white rounded-lg pt-5 pb-6" id="body">
        <div class="container-table ">
            <div id="table-list">
                <div class="container-table text-center">
                    <h2 class="text-3xl font-bold text-gray-800">ISIAN RENCANA STUDI (IRS)</h2>
                    <p class="text-lg mt-5 text-gray-600">
                        IRS Anda telah <span class="text-green-600 font-semibold">disetujui</span> oleh dosen wali. <br>Anda dapat melakukan perubahan atau pembatalan dengan persetujuan Dosen Wali.
                    </p>
                    {{-- <div class="mt-10">
                        <a href="{{ route('irs.print', ['mahasiswaId' => $mahasiswa->id]) }}"
                            class="inline-flex items-center px-6 py-3 bg-blue-600 border border-transparent rounded-full font-semibold text-sm text-white tracking-widest shadow-lg hover:shadow-xl hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-300">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                stroke="currentColor" class="w-5 h-5 mr-2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m6-6H6"></path>
                            </svg>
                            Cetak IRS
                        </a>
                    </div>
                </div> --}}

                {{-- <h2 class="text-2xl text-center font-semibold mx-auto max-w-64 mt-5">Histori IRS</h2> --}}

                <div class="flex flex-col space-y-4" x-data="{ openIndex: null, openModal: false, currentData: {} }">
                    <div class="overflow-hidden border rounded-lg border-gray-300 w-11/12 mx-auto my-6 p-4">
                        @foreach ($khsMahasiswa as $semester => $khsPerSemester)
                            <div class="border-b mb-3 rounded-lg overflow-hidden" id="mahasiswa-list">
                                <!-- Accordion Header -->
                                <div class="flex justify-between p-4 cursor-pointer bg-gray-50 hover:bg-gray-100 transition-colors duration-300"
                                    :class="openIndex === {{ $semester }} ? 'bg-gray-100' : ' '"
                                    @click="openIndex = openIndex === {{ $semester }} ? null : {{ $semester }}">
                                    <div class="flex justify-between w-full">
                                        <div>
                                            <span class="ml-4 text-blue-500">Semester {{ $semester }}</span>
                                        </div>
                                        <svg :class="openIndex === {{ $semester }} ? 'transform rotate-180' : ''"
                                            class="h-5 w-5 text-gray-600 transition-transform"
                                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </div>
                                </div>

                                <!-- Accordion Content -->
                                <div x-show="openIndex === {{ $semester }}" x-collapse
                                    class="transition-all duration-300">
                                    <div class="p-5 bg-white rounded-b-lg shadow-inner overflow-auto">
                                        <div x-data="{ checkAll: false }"
                                            class="overflow-hidden w-full overflow-x-auto rounded-md border border-neutral-300">
                                            <table class="w-full text-left text-sm text-neutral-600">
                                                <thead
                                                    class="border-b border-neutral-300 bg-grey-100 text-neutral-900">
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
                                                    </tr>
                                                </thead>
                                                <tbody class="divide-y divide-neutral-0">
                                                    @foreach ($khsPerSemester as $key => $khs)
                                                        <tr>
                                                            <td
                                                                class="p-5 whitespace-nowrap text-sm leading-6 font-medium text-gray-900 text-center">
                                                                {{ $loop->iteration }} </td>
                                                            <td
                                                                class="p-5 whitespace-nowrap text-sm leading-6 font-medium text-gray-900">
                                                                {{ $khs->kode_mk }} </td>
                                                            <td class="px-5 py-3">
                                                                <div class="w-48 flex items-center gap-3">
                                                                    <div class="data">
                                                                        <p class="font-normal text-sm text-gray-900">
                                                                            {{ $khs->nama_mk }}</p>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td
                                                                class="text-center whitespace-nowrap text-sm leading-6 font-medium text-gray-900">
                                                                {{ $khs->semester }} </td>
                                                            <td
                                                                class="text-center whitespace-nowrap text-sm leading-6 font-medium text-gray-900">
                                                                {{ $khs->sks }} </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <div class="w-11/12 mx-auto flex justify-end mt-5">
            <a href="{{ route('irshistori.print', ['nim' => $mahasiswa->nim]) }}"
                class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                    stroke="currentColor" class="w-5 h-5 mr-2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m6-6H6"></path>
                </svg>
                Cetak Histori IRS
            </a>
        </div>
    </section>

    <footer class="bg-[#D9D9D9] bg-opacity-30 mt-[720px]">
        <div class="flex w-2/3 h-20 mx-auto justify-between items-center text-white">
            <p>TIM SiAKAM <span class="font-semibold"> Universitas Diponegoro</span></p>
            <p>Dibangun dengan penuh kekhawatiran 🔥🔥</p>
        </div>
    </footer>
</body>

</html>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- CSRF Token for AJAX requests -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @vite('resources/js/app.js')
    @vite('resources/css/app.css')
    <!-- Tambahkan SweetAlert2 CSS dan JS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>IRS Mahasiswa</title>
</head>

<body class="bg-gradient-to-r from-fuchsia-800 from-1% to bg-pink-500 ">
    <nav class="bg-black" x-data="{ isOpen: false }">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex h-16 items-center justify-between">
                <div class="flex items-center">
                    <a href="{{ route('mahasiswa.dashboard') }}">
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
            <p class="font-bold">IRS - INDEX</p>
            <a href="{{ route('mahasiswa.dashboard') }}">
                <div class="flex">
                    <img src="{{ asset('home-outline.svg') }}" alt="">
                    <p class="ml-2">Dasbor / IRS</p>
                </div>
            </a>
        </div>
    </section>


    <section class="w-10/12 mx-auto relative top-36 bg-white rounded-lg pt-5 pb-10" id="body">
        <div class="container-table ">
            <div id="table-list">

                <h2 class="text-2xl text-center mx-auto max-w-64 mt-5">ISIAN RENCANA STUDI (IRS)</h2>

                <div class="flex justify-between mb-5 mx-20">
                    <div class="flex-col items-center">
                        <p class="text-xs mb-1">STATUS IRS</p>
                        <div id="irs-status" class="flex flex-col">
                            <div
                                class="bg-[#2EC060] rounded-xl w-24 h-8 mr-3 pt-1.5 text-white text-xs text-center font-semibold">
                                belum distujui</div>

                            <div class="my-auto flex text-sm mt-2 font-semibold tracking-wide">
                                <p>Ip Semester Sebelumnya: {{ $ipSemester }}
                                </p>
                            </div>
                        </div>

                    </div>
                    <div class="flex">
                        <div class="flex-col items-center mt-5">
                            <div id="dropdown">
                                <select name="matakuliah" id="matakuliah"
                                    class="bg-white rounded-xl h-8 w-64 mc-5 text-sm py-px">
                                    <option value="" disabled selected>Cari mata kuliah</option>
                                    @foreach ($listMK as $mk)
                                        <option value="{{ $mk->kode_mk }}">{{ $mk->kode_mk . '-' . $mk->nama }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="flex-col items-center">
                            <p class="mr-3 text-xs mb-1">MAKSIMUM SKS</p>
                            <div id="sks-maksimum">
                                <div
                                    class="bg-[#002687] rounded-xl w-20 h-8 ml-1 pt-1.5 text-white text-sm text-center font-semibold">
                                    {{ $totalSksDiambil }} SKS</div>
                            </div>
                        </div>
                        <div class="flex-col items-center">
                            <p class="text-xs mb-1">SKS YANG DIAMBIL</p>
                            <div id="sks-diambil">
                                <div
                                    class="bg-[#002687] rounded-xl w-20 h-8 ml-2 pt-1.5 text-white text-sm text-center font-semibold">
                                    {{ $totalSksAmbil }} sks</div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="flex flex-col">
                    <div class=" overflow-x-auto pb-4">
                        <div class="min-w-full inline-block align-middle">
                            <div class="overflow-hidden  border rounded-lg border-gray-300 w-11/12 mx-auto">
                                <table class="table-auto min-w-full rounded-xl">
                                    <thead>
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
                                                class="p-5 text-left whitespace-nowrap text-sm leading-6 font-semibold text-gray-900 capitalize">
                                                Semester </th>
                                            <th scope="col"
                                                class="p-5 text-left whitespace-nowrap text-sm leading-6 font-semibold text-gray-900 capitalize">
                                                SKS </th>
                                            <th scope="col"
                                                class="p-5 text-left whitespace-nowrap text-sm leading-6 font-semibold text-gray-900 capitalize">
                                                Sifat </th>
                                            <th scope="col"
                                                class="p-5 text-left whitespace-nowrap text-sm leading-6 font-semibold text-gray-900 capitalize">
                                                Kelas </th>
                                            <th scope="col"
                                                class="p-5 text-left whitespace-nowrap text-sm leading-6 font-semibold text-gray-900 capitalize">
                                                Ruangan </th>
                                            <th scope="col"
                                                class="p-5 text-left whitespace-nowrap text-sm leading-6 font-semibold text-gray-900 capitalize">
                                                Hari </th>
                                            <th scope="col"
                                                class="p-5 text-left whitespace-nowrap text-sm leading-6 font-semibold text-gray-900 capitalize">
                                                Jam </th>
                                            <th scope="col"
                                                class="text-center whitespace-nowrap text-sm leading-6 font-semibold text-gray-900 capitalize">
                                                Aksi </th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-300 " id="courseList">
                                        @foreach ($jadwal_MK as $mk)
                                            <tr class="bg-white transition-all duration-500 hover:bg-gray-50 "
                                                class="row-mk" id="row-{{ $mk->kode_mk }}">
                                                <td
                                                    class="p-5 whitespace-nowrap text-sm leading-6 font-medium text-gray-900 text-center">
                                                    {{ $loop->iteration }} </td>
                                                <td
                                                    class="p-5 whitespace-nowrap text-sm leading-6 font-medium text-gray-900">
                                                    {{ $mk->kode_mk }} </td>
                                                <td class=" px-5 py-3">
                                                    <div class="w-48 flex items-center gap-3">
                                                        <div class="data">
                                                            <p class="font-normal text-sm text-gray-900">
                                                                {{ $mk->nama }}</p>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td
                                                    class="p-5 whitespace-nowrap text-sm leading-6 font-medium text-gray-900">
                                                    {{ $mk->semester }} </td>
                                                <td
                                                    class="p-5 whitespace-nowrap text-sm leading-6 font-medium text-gray-900">
                                                    {{ $mk->sks }} </td>
                                                <td
                                                    class="p-5 whitespace-nowrap text-sm leading-6 font-medium text-gray-900">
                                                    {{ $mk->sifat }} </td>
                                                <td
                                                    class="p-5 whitespace-nowrap text-sm leading-6 font-medium text-gray-900">
                                                    {{ $mk->kelas }} </td>
                                                <td
                                                    class="p-5 whitespace-nowrap text-sm leading-6 font-medium text-gray-900">
                                                    {{ $mk->ruangan }} </td>
                                                <td
                                                    class="p-5 whitespace-nowrap text-sm leading-6 font-medium text-gray-900">
                                                    {{ $mk->hari }} </td>
                                                <td
                                                    class="p-5 whitespace-nowrap text-sm leading-6 font-medium text-gray-900">
                                                    {{ $mk->jam_mulai }} - {{ $mk->jam_selesai }} </td>
                                                <td class="flex items-center gap-0.5">
                                                    <div class="">
                                                        @php
                                                            $sudah_diambil = false;
                                                            foreach ($irsDiambil as $diambil) {
                                                                if (
                                                                    $diambil->kode_mk == $mk->kode_mk &&
                                                                    $diambil->kelas == $mk->kelas
                                                                ) {
                                                                    $sudah_diambil = true;
                                                                    break;
                                                                }
                                                            }
                                                        @endphp

                                                        @if (!$sudah_diambil)
                                                            <!-- Tampilkan tombol Pilih jika mata kuliah belum diambil -->
                                                            <form action="{{ route('irs.store') }}" method="POST">
                                                                @csrf
                                                                <input type="hidden" name="semester"
                                                                    value="{{ $mk->semester }}">
                                                                <input type="hidden" name="kode_mk"
                                                                    value="{{ $mk->kode_mk }}">
                                                                <input type="hidden" name="nama_mk"
                                                                    value="{{ $mk->nama }}">
                                                                <input type="hidden" name="sks"
                                                                    value="{{ $mk->sks }}">
                                                                <input type="hidden" name="kelas"
                                                                    value="{{ $mk->kelas }}">
                                                                <button
                                                                    class="pilih-matkul w-16 h-8 text-center pt-px rounded-lg mt-4 ml-2 bg-[#2EC060] text-white"
                                                                    type="submit">
                                                                    Pilih
                                                                </button>
                                                            </form>
                                                        @else
                                                            <!-- Tampilkan tombol Batal jika mata kuliah sudah diambil -->
                                                            <form action="{{ route('irs.delete') }}" method="POST">
                                                                @csrf
                                                                @method('DELETE')
                                                                <input type="hidden" name="kode_mk"
                                                                    value="{{ $mk->kode_mk }}">
                                                                <input type="hidden" name="kelas"
                                                                    value="{{ $mk->kelas }}">
                                                                <input type="hidden" name="nama_mhs"
                                                                    value="{{ $mahasiswa->nama }}">
                                                                <button
                                                                    class="pilih-matkul w-16 h-8 text-center pt-px rounded-lg mt-4 ml-2 bg-red-600 text-white"
                                                                    onclick="deleteIrs(event, 'Konfirmasi', 'Apakah Anda yakin?', 'warning', 'Ya, batalkan!', 'success')"
                                                                    type="submit">
                                                                    Batal
                                                                </button>
                                                            </form>
                                                        @endif
                                                    </div>
                                                </td>

                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="w-11/12 mx-auto flex justify-end mt-5">
            <a href="{{ route('irs.print', ['mahasiswaId' => $mahasiswa->id]) }}"    class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5 mr-2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m6-6H6"></path>
                </svg>
                Cetak IRS
            </a>
            </div>
    </section>

    <!-- Footer -->
    <footer class="bg-[#D9D9D9] bg-opacity-30 mt-52">
        <div class="flex w-2/3 h-20 mx-auto justify-between items-center text-white">
            <p>TIM SiAKAM <span class="font-semibold"> Universitas Diponegoro</span></p>
            <p>Dibangun dengan penuh kekhawatiran 🔥🔥</p>
        </div>
    </footer>

    <script>
        // Tampilkan SweetAlert jika ada pesan di session
        @if (session('alert_type') && session('alert_message'))
            Swal.fire({
                icon: '{{ session('alert_type') }}', // error, success, warning, info
                title: '{{ session('alert_type') === 'error' ? 'Gagal' : 'Berhasil' }}',
                text: '{{ session('alert_message') }}',
                showConfirmButton: true
            });
        @endif
    </script>
</body>

</html>

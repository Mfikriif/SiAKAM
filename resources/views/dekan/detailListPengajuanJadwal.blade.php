<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @vite('resources/css/app.css')
    <title>List Pengajuan Jadwal Kuliah</title>
</head>

<body class="flex flex-col min-h-screen bg-gradient-to-r from-fuchsia-800 to-pink-500">
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
            <p class="font-bold">Detail Pengajuan Jadwal</p>
            <a href="{{ route('dekan.listPengajuanJadwal') }}">
                <div class="flex items-center">
                    <img src="{{ asset('arrow-left.png') }}" alt="" class="w-8 h-8 mr-1">
                    <p>Pengajuan Jadwal / Detail Pengajuan Jadwal</p>
                </div>
            </a>
        </div>
    </section>

    <main class="flex-1">
        <section class="w-11/12 mx-auto relative top-36 bg-white rounded-lg pt-5 pb-6" id="body">
            <div class="container-table">
                <h2 class="text-2xl text-center mx-auto max-w-64">LIST DETAIL PENGAJUAN JADWAL</h2>

                <div class="flex mt-4 ml-20">
                    <p>Jurusan :</p>
                    <p class="font-semibold ml-1"> Informatika</p>
                </div>

                <div class="text-right mt-4 mb-2 mr-20">
                    <form action="{{ route('jadwal.approveAll') }}" method="POST">
                        @csrf
                        <input type="hidden" name="program_studi" value="{{ $program_studi }}">
                        <label for="semester">Pilih Semester:</label>
                        <select name="semester" id="semester" onchange="filterTable()">
                            <option value="">-- Pilih Semester --</option>
                            @for ($i = 1; $i <= 8; $i++)
                                <option value="{{ $i }}">Semester {{ $i }}</option>
                            @endfor
                        </select>
                        <button type="submit" class="bg-transparent hover:bg-green-500 text-green-700 font-semibold hover:text-white py-2 px-4 border border-green-500 hover:border-transparent rounded">
                            Setujui Semua
                        </button>
                    </form>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-11/12 mx-auto text-center mt-2 border-separate border-spacing-y-3 pb-8">
                        <thead class="bg-gray-100 text-gray-700">
                            <tr>
                                <th class="px-4 py-2 border">Kode MK</th>
                                <th class="px-4 py-2 border">Mata Kuliah</th>
                                <th class="px-4 py-2 border">Semester</th>
                                <th class="px-4 py-2 border">SKS</th>
                                <th class="px-4 py-2 border">Sifat</th>
                                <th class="px-4 py-2 border">Koordinator MK</th>
                                <th class="px-4 py-2 border">Pengampu</th>
                                <th class="px-4 py-2 border">Kelas</th>
                                <th class="px-4 py-2 border">Ruangan</th>
                                <th class="px-4 py-2 border">Hari</th>
                                <th class="px-4 py-2 border">Jam</th>
                                <th class="px-4 py-2 border">Keterangan</th>
                                <th class="px-4 py-2 border">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="jadwal-tbody">
                            @foreach($jadwalPengajuan as $jadwal)
                                <tr class="even:bg-gray-50 hover:bg-gray-100 transition duration-200" data-semester="{{ $jadwal->semester }}">
                                    <td class="px-4 py-2 border">{{ $jadwal->kode_mk }}</td>
                                    <td class="px-4 py-2 border">{{ $jadwal->nama }}</td>
                                    <td class="px-4 py-2 border">{{ $jadwal->semester }}</td>
                                    <td class="px-4 py-2 border">{{ $jadwal->sks }}</td>
                                    <td class="px-4 py-2 border">{{ $jadwal->sifat }}</td>
                                    <td class="px-4 py-2 border">{{ $jadwal->koordinator_mk }}</td>
                                    <td class="px-4 py-2 border">
                                        @php
                                            $pengampu = collect([$jadwal->pengampu_1, $jadwal->pengampu_2, $jadwal->pengampu_3])
                                                        ->filter()
                                                        ->implode(', ');
                                        @endphp
                                        {{ $pengampu ?: 'Tidak ada pengampu' }}
                                    </td>
                                    <td class="px-4 py-2 border">{{ $jadwal->kelas }}</td>
                                    <td class="px-4 py-2 border">{{ $jadwal->ruangan }}</td>
                                    <td class="px-4 py-2 border">{{ $jadwal->hari }}</td>
                                    <td class="px-4 py-2 border">{{ $jadwal->jam_mulai }} - {{ $jadwal->jam_selesai }}</td>
                                    <td class="px-4 py-2 border">
                                        @if ($jadwal->persetujuan)
                                            <span class="text-green-500">Disetujui</span>
                                        @else
                                            <span class="text-red-500">Belum Disetujui</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-2 border">
                                        <div class="flex space-x-2">
                                            <form action="{{ route('jadwal.approve', $jadwal->id) }}" method="POST" class="inline">
                                                @csrf
                                                <button type="submit" class="bg-transparent hover:bg-green-500 text-green-700 font-semibold hover:text-white py-2 px-4 border border-green-500 hover:border-transparent rounded">
                                                    Setujui
                                                </button>
                                            </form>
                                            <form action="{{ route('jadwal.reject', $jadwal->id) }}" method="POST" class="inline">
                                                @csrf
                                                @method('POST')
                                                <button type="submit" class="bg-transparent hover:bg-red-500 text-red-700 font-semibold hover:text-white py-2 px-4 border border-red-500 hover:border-transparent rounded">
                                                    Tolak
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </main>

    <script>
        function filterTable() {
            var semester = document.getElementById("semester").value;
            var rows = document.querySelectorAll("[data-semester]");

            rows.forEach(function(row) {
                if (semester === "" || row.getAttribute("data-semester") === semester) {
                    row.style.display = "";
                } else {
                    row.style.display = "none";
                }
            });
        }
    </script>

    <!-- Footer -->
    <footer class="bg-[#D9D9D9] bg-opacity-30 mt-52">
        <div class="flex w-2/3 h-20 mx-auto justify-between items-center text-white">
            <p>TIM SiAKAM <span class="font-semibold"> Universitas Diponegoro</span></p>
            <p>Dibangun dengan penuh kekhawatiran 🔥🔥</p>
        </div>
    </footer>
</body>

</html>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>List Pengajuan Jadwal Kuliah</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    @vite('resources/css/app.css')
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @vite('resources/js/app.js')
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

    <section class="relative top-20">
        <div class="w-2/3 mx-auto flex justify-between text-lg text-white">
            <p class="font-bold">PENGAJUAN JADWAL</p>
            <a href="{{ route('dekan.dashboard') }}">
                <div class="flex items-center">
                    <img src="{{ asset('arrow-left.png') }}" alt="" class="w-8 h-8 mr-1">
                    <p>Dasbor / Pengajuan Jadwal</p>
                </div>
            </a>
        </div>
    </section>

    <!-- Main Content -->
    <main class="flex-1">
        <section class="w-11/12 mx-auto relative top-36 bg-white rounded-lg pt-5 pb-6">
            <div class="container-table">
                <h2 class="text-2xl text-center mx-auto mt-8 max-w-64">LIST DETAIL PENGAJUAN JADWAL</h2>

                <div class="flex items-center justify-end mt-8 mb-2 mr-20 space-x-4">
                    <div class="flex items-center">
                        <label for="semester" class="mr-2">Pilih Semester:</label>
                        <select name="semester" id="semester" onchange="filterTable()" class="border rounded px-4 py-1 w-52">
                            <option value="">-- Pilih Semester --</option>
                            @for ($i = 1; $i <= 8; $i++)
                                <option value="{{ $i }}">Semester {{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="flex items-center">
                        <label for="jurusan" class="mr-2">Pilih Jurusan:</label>
                        <select name="jurusan" id="jurusan" onchange="filterTable()" class="border rounded px-4 py-1 w-52">
                            <option value="">-- Pilih Jurusan --</option>
                            <option value="informatika">Informatika</option>
                            <option value="bioteknologi">Bioteknologi</option>
                        </select>
                    </div>
                    <button onclick="approveAllJadwal()" class="bg-green-600 text-white font-semibold px-4 py-1 rounded transition duration-200 hover:bg-white hover:text-green-600 border border-green-600">
                        Setujui Semua
                    </button>
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
                                <th class="px-4 py-2 border">Koordinator</th>
                                <th class="px-4 py-2 border">Pengampu</th>
                                <th class="px-4 py-2 border">Kelas</th>
                                <th class="px-4 py-2 border">Ruangan</th>
                                <th class="px-4 py-2 border">Hari</th>
                                <th class="px-4 py-2 border">Jam</th>
                                <th class="px-4 py-2 border">Aksi</th>
                                <th class="px-4 py-2 border">Keterangan</th>
                            </tr>
                        </thead>
                        <tbody id="jadwal-tbody">
                            @foreach($jadwalList as $jadwal)
                                <tr class="even:bg-gray-50 hover:bg-gray-100 transition duration-200" data-semester="{{ $jadwal->semester }}">
                                    <td class="px-4 py-7 border">{{ $jadwal->kode_mk }}</td>
                                    <td class="px-4 py-2 border">{{ $jadwal->nama }}</td>
                                    <td class="px-4 py-2 border">{{ $jadwal->semester }}</td>
                                    <td class="px-4 py-2 border">{{ $jadwal->sks }}</td>
                                    <td class="px-4 py-2 border">{{ $jadwal->sifat }}</td>
                                    <td class="px-4 py-2 border">{{ $jadwal->koordinator_mk }}</td>
                                    <td class="px-4 py-2 border">
                                        {{ implode(', ', array_filter([$jadwal->pengampu_1, $jadwal->pengampu_2, $jadwal->pengampu_3])) ?: 'Tidak ada pengampu' }}
                                    </td>
                                    <td class="px-4 py-2 border">{{ $jadwal->kelas }}</td>
                                    <td class="px-4 py-2 border">{{ $jadwal->ruangan }}</td>
                                    <td class="px-4 py-2 border">{{ $jadwal->hari }}</td>
                                    <td class="px-4 py-2 border">{{ $jadwal->jam_mulai }} - {{ $jadwal->jam_selesai }}</td>
                                    <td class="px-4 py-2 border w-44" id="aksi-{{ $jadwal->id }}">
                                        <div class="flex justify-center space-x-2">
                                            @if ($jadwal->persetujuan === 0)
                                                <button onclick="approveRejectJadwal({{ $jadwal->id }}, 'approve')" class="bg-transparent hover:bg-green-500 text-green-700 font-semibold hover:text-white py-1 px-2 border border-green-500 hover:border-transparent rounded">Setujui</button>
                                                <button onclick="approveRejectJadwal({{ $jadwal->id }}, 'reject')" class="bg-transparent hover:bg-red-500 text-red-700 font-semibold hover:text-white py-1 px-2 border border-red-500 hover:border-transparent rounded">Tolak</button>
                                            @elseif ($jadwal->persetujuan === 1)
                                                <button onclick="approveRejectJadwal({{ $jadwal->id }}, 'cancel')" class="bg-transparent hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-1 px-2 border border-blue-500 hover:border-transparent rounded">Batalkan Persetujuan</button>
                                            @elseif ($jadwal->persetujuan === -1)
                                                <button onclick="approveRejectJadwal({{ $jadwal->id }}, 'cancel')" class="bg-transparent hover:bg-red-500 text-red-700 font-semibold hover:text-white py-1 px-2 border border-red-500 hover:border-transparent rounded">Batalkan Penolakan</button>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-4 py-2 border" id="status-{{ $jadwal->id }}">
                                        @if ($jadwal->persetujuan === 1)
                                            <span class="text-green-500">Disetujui</span>
                                        @elseif ($jadwal->persetujuan === -1)
                                            <span class="text-red-500">Ditolak: {{ $jadwal->reason_for_rejection }}</span>
                                        @else
                                            <span class="text-gray-500">Belum Disetujui</span>
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
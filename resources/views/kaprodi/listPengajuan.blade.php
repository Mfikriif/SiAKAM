<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>List Pengajuan IRS Mahasiswa</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    @vite('resources/css/app.css')
    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('path/to/sweetalertHelper.js') }}"></script>
    @vite('resources/js/app.js')
</head>

<body class="flex flex-col min-h-screen bg-gradient-to-r from-fuchsia-800 to-pink-500">
    <nav class="bg-black" x-data="{ isOpen: false }">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex h-16 items-center justify-between">
                <div class="flex items-center">
                    <a href="{{ route('kaprodi.dashboard') }}" class="flex items-center">
                        <img class="h-9 w-8" src="{{ asset('undipLogo.png') }}" alt="Your Company">
                        <h3 class="ml-2 text-white">SiAKAM Undip</h3>
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
                        <div class="relative ml-3">
                            <button type="button" @click="isOpen = !isOpen"
                                class="relative flex max-w-xs items-center rounded-full bg-gray-800 text-sm focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800"
                                id="user-menu-button" aria-expanded="false" aria-haspopup="true">
                                <span class="absolute -inset-1.5"></span>
                                <span class="sr-only">Open user menu</span>

                                <img class="h-8 w-8 rounded-full object-cover" 
                                    src="{{ $user->profile_photo && file_exists(public_path($user->profile_photo)) ? asset($user->profile_photo) : asset('images/profiles/default_photo.jpg') }}" 
                                    alt="User Photo">
                            </button>
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
        <div class="w-2/3 mx-auto flex justify-between text-lg text-white" id="container-navigation">
            <p class="font-bold">PEMBUATAN JADWAL</p>
            <a href="{{ route('kaprodi.dashboard') }}">
                <div class="flex items-center">
                    <img src="{{ asset('arrow-left.png') }}" alt="" class="w-8 h-8 mr-1">
                    <p>Dasbor / Pembuatan Jadwal</p>
                </div>
            </a>
        </div>
    </section>
    
    <!-- Main content -->
    <main class="flex-1">
        <section class="w-11/12 mx-auto relative top-36 bg-white rounded-lg pt-5 pb-6" id="body">
            <div class="container-table">
                <div id="table-list">
                    <h2 class="text-2xl text-center mx-auto max-w-64 mt-8">LIST PENGAJUAN JADWAL PERKULIAHAN</h2>
                    <div x-data="{ isModalOpen: false }">
                        <div class="flex justify mt-5 mb-3 ml-20">
                            <button @click="isModalOpen = true" class="h-9 max-w-52 flex items-center justify-center bg-[#002687] text-white rounded-lg px-4 py-2 mb-4 hover:bg-[#001b58]">
                                Tambah Jadwal 
                                <img class="w-5 h-5 ml-2" src="{{ asset('plus.svg') }}" alt="">
                            </button>
                        </div>
                        <div x-show="isModalOpen" x-cloak class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-50 z-50">
                            <div class="bg-white rounded-lg shadow-lg w-1/2 max-w-4xl">
                                <div class="flex justify-between items-center border-b px-4 py-2">
                                    <h3 class="text-lg font-semibold">Tambah Jadwal Perkuliahan</h3>
                                    <button @click="isModalOpen = false" class="text-gray-400 hover:text-gray-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>
                                <form action="{{ route('jadwal.store') }}" method="POST" 
                                        class="p-6 bg-white shadow-lg rounded-lg max-w-4xl mx-auto" 
                                        x-data="{ kode_mk: '', nama_mk: '', sks: '', semester: '', pengampu: '', sifat: '', mataKuliahList: {{ $mataKuliah->toJson() }} }">
                                    @csrf
                                    <h2 class="text-2xl font-semibold text-gray-800 mb-6 text-center">Pengajuan Jadwal</h2>
                                    
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <!-- Kolom Kiri -->
                                        <div class="space-y-4">
                                            <!-- Kode MK -->
                                            <div>
                                                <label for="kode_mk" class="block text-sm font-medium text-gray-600">Kode MK</label>
                                                <select name="kode_mk" id="kode_mk" required x-model="kode_mk"
                                                        @change="
                                                            const selectedMk = mataKuliahList.find(mk => mk.kode_mk === kode_mk);
                                                            nama_mk = selectedMk ? selectedMk.nama_mk : ''; 
                                                            sks = selectedMk ? selectedMk.sks : '';
                                                            semester = selectedMk ? selectedMk.semester : '';
                                                            sifat = selectedMk ? selectedMk.sifat : '';
                                                            calculateJamSelesai(); // Calculate jam_selesai whenever sks changes
                                                        "
                                                        class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm transition">
                                                    <option value="">Pilih Kode Mata Kuliah</option>
                                                    @foreach($filteredMataKuliah as $mk)
                                                        <option value="{{ $mk->kode_mk }}">{{ $mk->kode_mk }} - {{ $mk->nama_mk }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            
                                            <!-- Nama -->
                                            <div>
                                                <label for="nama" class="block text-sm font-medium text-gray-600">Nama</label>
                                                <input type="text" name="nama" id="nama" x-model="nama_mk" readonly required
                                                    class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm transition">
                                            </div>
                                            
                                            <!-- Semester -->
                                            <div>
                                                <label for="semester" class="block text-sm font-medium text-gray-600">Semester</label>
                                                <input type="text" name="semester" id="semester" x-model="semester" readonly required
                                                    class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm transition">
                                            </div>
                                            
                                            <!-- SKS -->
                                            <div>
                                                <label for="sks" class="block text-sm font-medium text-gray-600">SKS</label>
                                                <input type="number" name="sks" id="sks" x-model="sks" readonly required
                                                    class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm transition">
                                            </div>
                                            
                                            <!-- Sifat -->
                                            <div>
                                                <label for="sifat" class="block text-sm font-medium text-gray-600">Sifat</label>
                                                <input type="text" name="sifat" id="sifat" x-model="sifat" readonly required
                                                    class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm transition">
                                            </div>
                                
                                            <!-- Koordinator Mata Kuliah -->
                                            <div>
                                                <label for="koordinator_mk" class="block text-sm font-medium text-gray-600">Koordinator Mata Kuliah</label>
                                                <select name="koordinator_mk" id="koordinator_mk" required
                                                        class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm transition">
                                                    <option value="">Pilih Koordinator Mata Kuliah</option>
                                                    @foreach($filteredPengampu as $pengampu)
                                                        <option value="{{ $pengampu->nama }}">{{ $pengampu->nama }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                
                                        <!-- Kolom Kanan -->
                                        <div class="space-y-4">
                                            <!-- Pengampu -->
                                            <div>
                                                <label for="pengampu" class="block text-sm font-medium text-gray-600">Pengampu</label>
                                                
                                                <select name="pengampu_1" id="pengampu_1" required
                                                        class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm transition">
                                                    <option value="">Pilih Pengampu 1</option>
                                                    @foreach($filteredPengampu as $pengampu)
                                                        <option value="{{ $pengampu->nama }}">{{ $pengampu->nama }}</option>
                                                    @endforeach
                                                </select>
                                                
                                                <select name="pengampu_2" id="pengampu_2"
                                                        class="mt-2 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm transition">
                                                    <option value="">Pilih Pengampu 2</option>
                                                    @foreach($filteredPengampu as $pengampu)
                                                        <option value="{{ $pengampu->nama }}">{{ $pengampu->nama }}</option>
                                                    @endforeach
                                                </select>
                                                
                                                <select name="pengampu_3" id="pengampu_3"
                                                        class="mt-2 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm transition">
                                                    <option value="">Pilih Pengampu 3</option>
                                                    @foreach($filteredPengampu as $pengampu)
                                                        <option value="{{ $pengampu->nama }}">{{ $pengampu->nama }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            
                                            <!-- Kelas -->
                                            <div x-data="{ customKelas: false, kelas: '', kelasCustom: '' }">
                                                <label for="kelas" class="block text-sm font-medium text-gray-600">Kelas</label>
                                                <select name="kelas" id="kelas" x-model="kelas" @change="customKelas = (kelas === 'Other'); if (!customKelas) kelasCustom = ''" required
                                                        class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm transition">
                                                    <option value="">Pilih Kelas</option>
                                                    <option value="A">A</option>
                                                    <option value="B">B</option>
                                                    <option value="C">C</option>
                                                    <option value="D">D</option>
                                                    <option value="Other">Lainnya</option>
                                                </select>
                                                <input type="text" name="kelas_custom" id="kelas_custom" x-show="customKelas" x-model="kelasCustom" placeholder="Masukkan Kelas"
                                                    class="mt-2 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm transition">
                                            </div>
                                            
                                            <!-- Ruangan -->
                                            <div>
                                                <label for="ruangan" class="block text-sm font-medium text-gray-600">Ruangan</label>
                                                <select name="ruangan" id="ruangan" required
                                                        class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm transition">
                                                    <option value="">Pilih Ruangan</option>
                                                    @foreach($ruangan as $r)
                                                        <option value="{{ $r->kode_ruangan }}">{{ $r->kode_ruangan }} (Kapasitas: {{ $r->kapasitas }})</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            
                                            <!-- Hari -->
                                            <div>
                                                <label for="hari" class="block text-sm font-medium text-gray-600">Hari</label>
                                                <select name="hari" id="hari" required
                                                        class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm transition">
                                                    <option value="">Pilih Hari</option>
                                                    <option value="Senin">Senin</option>
                                                    <option value="Selasa">Selasa</option>
                                                    <option value="Rabu">Rabu</option>
                                                    <option value="Kamis">Kamis</option>
                                                    <option value="Jumat">Jumat</option>
                                                </select>
                                            </div>
                                            
                                            <!-- Jam Mulai & Jam Selesai -->
                                            <div class="flex space-x-4">
                                                <div class="flex-1">
                                                    <label for="jam_mulai" class="block text-sm font-medium text-gray-600">Jam Mulai</label>
                                                    <input type="time" name="jam_mulai" id="jam_mulai" onchange="calculateJamSelesai()" required
                                                        class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm transition">
                                                </div>
                                                <div class="flex-1">
                                                    <label for="jam_selesai" class="block text-sm font-medium text-gray-600">Jam Selesai</label>
                                                    <input type="time" name="jam_selesai" id="jam_selesai" readonly
                                                        class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm transition">
                                                </div>
                                            </div>
                                            
                                            <!-- Tombol Simpan dan Batal -->
                                            <div class="flex justify-end mt-6 space-x-4">
                                                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg shadow-lg transition duration-200">Simpan</button>
                                                <button type="button" @click="isModalOpen = false" class="bg-gray-300 hover:bg-gray-400 text-black font-bold py-2 px-4 rounded-lg shadow-lg transition duration-200">Batal</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-11/12 mx-auto text-center mt-2 border-separate border-spacing-y-3 pb-8">
                        <thead class="bg-gray-100 text-gray-700">
                            <tr>
                                <th class="px-2 py-4 border-b">Kode MK</th>
                                <th class="px-2 py-4 border-b">Mata Kuliah</th>
                                <th class="px-2 py-4 border-b">Semester</th>
                                <th class="px-2 py-4 border-b">SKS</th>
                                <th class="px-2 py-4 border-b">Sifat</th>
                                <th class="px-2 py-4 border-b">Koordinator</th>
                                <th class="px-2 py-4 border-b">Pengampu</th>
                                <th class="px-2 py-4 border-b">Kelas</th>
                                <th class="px-2 py-4 border-b">Ruangan</th>
                                <th class="px-2 py-4 border-b">Hari</th>
                                <th class="px-2 py-4 border-b">Jam</th>
                                <th class="px-2 py-4 border-b w-52">Aksi</th>
                                <th class="px-2 py-4 border-b">Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($filteredJadwalList as $jadwal)
                                <tr class="even:bg-gray-50 hover:bg-gray-100 transition duration-200">
                                    <td class="px-2 py-4 border">{{ $jadwal->kode_mk }}</td>
                                    <td class="px-2 py-4 border">{{ $jadwal->nama }}</td>
                                    <td class="px-2 py-4 border">{{ $jadwal->semester }}</td>
                                    <td class="px-2 py-4 border">{{ $jadwal->sks }}</td>
                                    <td class="px-2 py-4 border">{{ $jadwal->sifat }}</td>
                                    <td class="px-2 py-4 border">{{ $jadwal->koordinator_mk }}</td>
                                    <td class="px-2 py-4 border">
                                        @php
                                            $pengampu = collect([$jadwal->pengampu_1, $jadwal->pengampu_2, $jadwal->pengampu_3])
                                                        ->filter()
                                                        ->implode(', ');
                                        @endphp
                                        {{ $pengampu ?: 'Tidak ada pengampu' }}
                                    </td>
                                    <td class="px-2 py-4 border">{{ $jadwal->kelas }}</td>
                                    <td class="px-2 py-4 border">{{ $jadwal->ruangan }}</td>
                                    <td class="px-2 py-4 border">{{ $jadwal->hari }}</td>
                                    <td class="px-2 py-4 border">{{ $jadwal->jam_mulai }} - {{ $jadwal->jam_selesai }}</td>
                                    <td class="px-2 py-4 border">
                                        @if ($jadwal->persetujuan === 1)
                                            <span class="text-gray-500">Tidak dapat diubah atau dihapus</span>
                                        @else
                                            <div x-data="{ isEditModalOpen: false, selectedJadwal: null, jam_selesai: '', calculateJamSelesai() {
                                                if (this.selectedJadwal && this.selectedJadwal.jam_mulai && this.selectedJadwal.sks) {
                                                    const [hours, minutes] = this.selectedJadwal.jam_mulai.split(':').map(Number);
                                                    const durationMinutes = this.selectedJadwal.sks * 50; // 1 SKS = 50 minutes
                                                    const jamMulaiDate = new Date();
                                                    jamMulaiDate.setHours(hours, minutes);
                                    
                                                    const jamSelesaiDate = new Date(jamMulaiDate.getTime() + durationMinutes * 60000);
                                                    this.jam_selesai = `${String(jamSelesaiDate.getHours()).padStart(2, '0')}:${String(jamSelesaiDate.getMinutes()).padStart(2, '0')}`;
                                                }
                                            } }">
                                                <button @click="isEditModalOpen = true; selectedJadwal = {{ json_encode($jadwal) }}; calculateJamSelesai()" class="bg-transparent hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-2 px-4 border border-blue-500 hover:border-transparent rounded transition duration-200">
                                                    Ubah
                                                </button>
                                                <button class="mt-2 bg-transparent hover:bg-red-500 text-red-700 font-semibold hover:text-white py-2 px-4 border border-red-500 hover:border-transparent rounded transition duration-200" 
                                                onclick="confirmDelete('{{ route('jadwal.destroy', $jadwal->id) }}')">
                                                    Hapus
                                                </button>
                                    
                                                <!-- Form Edit Modal -->
                                                <div x-show="isEditModalOpen" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-50 z-50">
                                                    <div class="bg-white rounded-lg shadow-lg w-11/12 max-w-4xl p-6">
                                                        <div class="flex justify-between items-center border-b pb-3 mb-4">
                                                            <h3 class="text-lg font-semibold">Ubah Jadwal Perkuliahan</h3>
                                                            <button @click="isEditModalOpen = false" class="text-gray-500 hover:text-gray-600">
                                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                                </svg>
                                                            </button>
                                                        </div>
                                    
                                                        <!-- Form untuk Edit Data -->
                                                        <form :action="`/jadwal/update/${selectedJadwal.id}`" method="POST">
                                                            @csrf
                                                            @method('PUT')
                                                            <h2 class="text-2xl font-semibold text-gray-800 mb-4">Edit Jadwal</h2>
                                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                                                <!-- Kolom Kiri -->
                                                                <div class="space-y-4">
                                                                    <!-- Kode MK -->
                                                                    <div>
                                                                        <label for="kode_mk" class="block text-sm font-medium text-gray-600">Kode MK</label>
                                                                        <input type="text" name="kode_mk" id="kode_mk" x-model="selectedJadwal.kode_mk" readonly required
                                                                            class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm transition">
                                                                    </div>
                                    
                                                                    <!-- Nama -->
                                                                    <div>
                                                                        <label for="nama" class="block text-sm font-medium text-gray-600">Nama</label>
                                                                        <input type="text" name="nama" id="nama" x-model="selectedJadwal.nama" readonly required
                                                                            class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm transition">
                                                                    </div>

                                                                    <!-- Semester -->
                                                                    <div>
                                                                        <label for="semester" class="block text-sm font-medium text-gray-600">Semester</label>
                                                                        <input type="text" name="semester" id="semester" x-model="selectedJadwal.semester" readonly required
                                                                            class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm transition">
                                                                    </div>
                                    
                                                                    <!-- Sks -->
                                                                    <div>
                                                                        <label for="sks" class="block text-sm font-medium text-gray-600">SKS</label>
                                                                        <input type="text" name="sks" id="sks" x-model="selectedJadwal.sks" readonly required
                                                                            class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm transition">
                                                                    </div>
                                    
                                                                    <!-- Koordinator Mata Kuliah -->
                                                                    <div>
                                                                        <label for="koordinator_mk" class="block text-sm font-medium text-gray-600">Koordinator Mata Kuliah</label>
                                                                        <select name="koordinator_mk" id="koordinator_mk" x-model="selectedJadwal.koordinator_mk" required
                                                                                class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm transition">
                                                                            <option value="">Pilih Koordinator Mata Kuliah</option>
                                                                            @foreach($filteredPengampu as $pengampu)
                                                                                <option value="{{ $pengampu->nama }}">{{ $pengampu->nama }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                </div>
                                    
                                                                <!-- Kolom Kanan -->
                                                                <div class="space-y-4">
                                                                    <!-- Pengampu -->
                                                                    <div>
                                                                        <label for="pengampu" class="block text-sm font-medium text-gray-600">Pengampu</label>
                                                                        <!-- Pengampu 1 -->
                                                                        <select name="pengampu_1" id="pengampu_1" x-model="selectedJadwal.pengampu_1" required
                                                                                class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm transition">
                                                                            <option value="">Pilih Pengampu 1</option>
                                                                            @foreach($filteredPengampu as $pengampu)
                                                                                <option value="{{ $pengampu->nama }}">{{ $pengampu->nama }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                        <!-- Pengampu 2 -->
                                                                        <select name="pengampu_2" id="pengampu_2" x-model="selectedJadwal.pengampu_2"
                                                                                class="mt-2 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm transition">
                                                                            <option value="">Pilih Pengampu 2</option>
                                                                            @foreach($filteredPengampu as $pengampu)
                                                                                <option value="{{ $pengampu->nama }}">{{ $pengampu->nama }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                        <!-- Pengampu 3 -->
                                                                        <select name="pengampu_3" id="pengampu_3" x-model="selectedJadwal.pengampu_3"
                                                                                class="mt-2 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm transition">
                                                                            <option value="">Pilih Pengampu 3</option>
                                                                            @foreach($filteredPengampu as $pengampu)
                                                                                <option value="{{ $pengampu->nama }}">{{ $pengampu->nama }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>

                                                                    <!-- Kelas -->
                                                                    <div x-data="{ customKelas: false }">
                                                                        <label for="kelas" class="block text-sm font-medium text-gray-600">Kelas</label>
                                                                        <select name="kelas" id="kelas" x-model="selectedJadwal.kelas" 
                                                                                @change="customKelas = (selectedJadwal.kelas === 'Other')"
                                                                                class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm transition">
                                                                            <option value="">Pilih Kelas</option>
                                                                            <option value="A">A</option>
                                                                            <option value="B">B</option>
                                                                            <option value="C">C</option>
                                                                            <option value="D">D</option>
                                                                            <option value="Other">Lainnya</option>
                                                                        </select>
                                                                        <input type="text" name="kelas_custom" id="kelas_custom" x-show="customKelas"
                                                                            x-model="selectedJadwal.kelas_custom" placeholder="Masukkan Kelas"
                                                                            class="mt-2 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm transition">
                                                                    </div>
                                    
                                                                    <!-- Ruangan -->
                                                                    <div>
                                                                        <label for="ruangan" class="block text-sm font-medium text-gray-600">Ruangan</label>
                                                                        <select name="ruangan" id="ruangan" x-model="selectedJadwal.ruangan" required
                                                                                class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm transition">
                                                                            <option value="">Pilih Ruangan</option>
                                                                            @foreach($ruangan as $r)
                                                                                <option value="{{ $r->kode_ruangan }}">{{ $r->kode_ruangan }} (Kapasitas: {{ $r->kapasitas }})</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                    
                                                                    <!-- Hari -->
                                                                    <div>
                                                                        <label for="hari" class="block text-sm font-medium text-gray-600">Hari</label>
                                                                        <select name="hari" id="hari" x-model="selectedJadwal.hari" required
                                                                                class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm transition">
                                                                            <option value="">Pilih Hari</option>
                                                                            <option value="Senin">Senin</option>
                                                                            <option value="Selasa">Selasa</option>
                                                                            <option value="Rabu">Rabu</option>
                                                                            <option value="Kamis">Kamis</option>
                                                                            <option value="Jumat">Jumat</option>
                                                                        </select>
                                                                    </div>
                                    
                                                                    <!-- Jam Mulai & Jam Selesai -->
                                                                    <div class="flex space-x-4">
                                                                        <div class="flex-1">
                                                                            <label for="jam_mulai" class="block text-sm font-medium text-gray-600">Jam Mulai</label>
                                                                            <input type="time" name="jam_mulai" id="jam_mulai" x-model="selectedJadwal.jam_mulai" @change="calculateJamSelesai()" required
                                                                                class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm transition">
                                                                        </div>
                                                                        <div class="flex-1">
                                                                            <label for="jam_selesai" class="block text-sm font-medium text-gray-600">Jam Selesai</label>
                                                                            <input type="time" name="jam_selesai" id="jam_selesai" x-model="jam_selesai" readonly
                                                                                class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm transition">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                    
                                                            <!-- Tombol Simpan dan Batal -->
                                                            <div class="flex justify-end mt-6 space-x-4">
                                                                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg shadow-lg transition duration-200">Simpan</button>
                                                                <button type="button" @click="isEditModalOpen = false" class="bg-gray-300 hover:bg-gray-400 text-black font-bold py-2 px-4 rounded-lg shadow-lg transition duration-200">Batal</button>
                                                            </div>
                                                        </form>    
                                                    </div>                                                    
                                                </div>
                                            </div>
                                        @endif
                                    </td>
                                    <td class="px-4 py-2 border">
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
                    <div class="flex justify-center">
                        {{ $filteredJadwalList->links() }}
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

    @if ($errors->any())
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                const errors = @json($errors->all());
                showErrors(errors);
            });
        </script>
    @endif

    @if (session('success'))
    <script>
        Swal.fire({
            title: "Success",
            text: "{{ session('success') }}",
            icon: "success",
            confirmButtonText: "OK"
        });
    </script>
    @endif
</body>
</html>

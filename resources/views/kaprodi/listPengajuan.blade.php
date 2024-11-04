<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
    @vite('resources/css/app.css')
    <title>List Pengajuan IRS Mahasiswa</title>
    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
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
                                <img class="h-8 w-8 rounded-full" src="{{ asset('profilPembimbing.png') }}"
                                    alt="">
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
        <div class="w-2/3 mx-auto flex justify-between text-white" id="container-navigation">
            <p class="font-bold">PENGAJUAN JADWAL</p>
            <a href="{{ route('kaprodi.dashboard') }}">
                <div class="flex">
                    <img src="{{ asset('home-outline.svg') }}" alt="">
                    <p class="ml-2">Dasbor / Pengajuan Jadwal</p>
                </div>
            </a>
        </div>
    </section>

    <section class="w-11/12 mx-auto relative top-36 bg-white rounded-lg pt-5 pb-6" id="body">
        <div class="container-table">
            <div id="table-list">
                <h2 class="text-2xl text-center mx-auto max-w-64 mt-5">LIST PENGAJUAN JADWAL PERKULIAHAN</h2>
                <div x-data="{ isModalOpen: false }">
                    <div class="flex justify mt-5 mb-3 ml-20">
                        <button @click="isModalOpen = true"
                            class="h-8 w-48 flex bg-[#002687] text-white rounded-lg pt-1 pl-4 mb-4">
                            Jadwal Perkuliahan
                            <img class="w-5 h-5 mx-auto pt-1 ml-2" src="{{ asset('plus.svg') }}" alt="">
                        </button>
                    </div>
                    <div x-show="isModalOpen" x-cloak
                        class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-50 z-50">
                        <div class="bg-white rounded-lg shadow-lg w-1/2 max-w-4xl">
                            <div class="flex justify-between items-center border-b px-4 py-2">
                                <h3 class="text-lg font-semibold">Tambah Jadwal Perkuliahan</h3>
                                <button @click="isModalOpen = false" class="text-gray-400 hover:text-gray-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>
                            <form action="{{ route('jadwal.store') }}" method="POST" class="px-4 py-6"
                                x-data="{ kode_mk: '', nama_mk: '', sks: '', semester: '', pengampu: '', sifat: '', mataKuliahList: {{ $mataKuliah->toJson() }} }">
                                @csrf
                                <div class="flex space-x-6">
                                    <!-- Kolom Kiri -->
                                    <div class="flex-1">
                                        <div class="mb-4">
                                            <label for="kode_mk" class="block text-sm font-medium text-gray-700">Kode
                                                MK</label>
                                            <select name="kode_mk" id="kode_mk" required x-model="kode_mk"
                                                @change="
                                                nama_mk = mataKuliahList.find(mk => mk.kode_mk === kode_mk)?.nama_mk || ''; 
                                                sks = mataKuliahList.find(mk => mk.kode_mk === kode_mk)?.sks || '';
                                                semester = mataKuliahList.find(mk => mk.kode_mk === kode_mk)?.semester || '';
                                                sifat = mataKuliahList.find(mk => mk.kode_mk === kode_mk)?.sifat || '';
                                                pengampu = mataKuliahList.find(mk => mk.kode_mk === kode_mk)?.pengampu || ''"
                                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                                <option value="">Pilih Kode Mata Kuliah</option>
                                                @foreach ($mataKuliah as $mk)
                                                    <option value="{{ $mk->kode_mk }}">{{ $mk->kode_mk }} -
                                                        {{ $mk->nama_mk }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-4">
                                            <label for="nama"
                                                class="block text-sm font-medium text-gray-700">Nama</label>
                                            <input type="text" name="nama" id="nama" x-model="nama_mk"
                                                readonly required
                                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                        </div>
                                        <div class="mb-4">
                                            <label for="semester"
                                                class="block text-sm font-medium text-gray-700">Semester</label>
                                            <input type="text" name="semester" id="semester" x-model="semester"
                                                readonly required
                                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                        </div>
                                        <div class="mb-4">
                                            <label for="sks"
                                                class="block text-sm font-medium text-gray-700">SKS</label>
                                            <input type="text" name="sks" id="sks" x-model="sks"
                                                readonly required
                                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                        </div>
                                        <div class="mb-4">
                                            <label for="sifat"
                                                class="block text-sm font-medium text-gray-700">Sifat</label>
                                            <input type="text" name="sifat" id="sifat" x-model="sifat"
                                                readonly required
                                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                        </div>
                                        <div class="mb-4">
                                            <label for="pengampu"
                                                class="block text-sm font-medium text-gray-700">Pengampu</label>
                                            <textarea name="pengampu" id="pengampu" x-model="pengampu" readonly required
                                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"></textarea>
                                        </div>
                                    </div>
                                    <!-- Kolom Kanan -->
                                    <div class="flex-1">
                                        <div class="mb-4" x-data="{ customKelas: false, kelas: '', kelasCustom: '' }">
                                            <label for="kelas"
                                                class="block text-sm font-medium text-gray-700">Kelas</label>
                                            <select name="kelas" id="kelas" x-model="kelas"
                                                @change="customKelas = (kelas === 'Other'); if (!customKelas) kelasCustom = ''"
                                                required
                                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                                <option value="">Pilih Kelas</option>
                                                <option value="A">A</option>
                                                <option value="B">B</option>
                                                <option value="C">C</option>
                                                <option value="D">D</option>
                                                <option value="Other">Lainnya</option>
                                            </select>
                                            <input type="text" name="kelas_custom" id="kelas_custom"
                                                x-show="customKelas" x-model="kelasCustom"
                                                placeholder="Masukkan Kelas"
                                                class="mt-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                        </div>
                                        <div class="mb-4">
                                            <label for="ruangan"
                                                class="block text-sm font-medium text-gray-700">Ruangan</label>
                                            <select name="ruangan" id="ruangan" required
                                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                                <option value="">Pilih Ruangan</option>
                                                @foreach ($ruangan as $r)
                                                    <option value="{{ $r->kode_ruangan }}">{{ $r->kode_ruangan }}
                                                        (Kapasitas: {{ $r->kapasitas }})
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-4">
                                            <label for="hari"
                                                class="block text-sm font-medium text-gray-700">Hari</label>
                                            <select name="hari" id="hari" required
                                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                                <option value="">Pilih Hari</option>
                                                <option value="Senin">Senin</option>
                                                <option value="Selasa">Selasa</option>
                                                <option value="Rabu">Rabu</option>
                                                <option value="Kamis">Kamis</option>
                                                <option value="Jumat">Jumat</option>
                                            </select>
                                        </div>
                                        <div class="mb-4">
                                            <label for="jam_mulai" class="block text-sm font-medium text-gray-700">Jam
                                                Mulai</label>
                                            <input type="time" name="jam_mulai" id="jam_mulai" required
                                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                        </div>
                                        <div class="mb-4">
                                            <label for="jam_selesai"
                                                class="block text-sm font-medium text-gray-700">Jam Selesai</label>
                                            <input type="time" name="jam_selesai" id="jam_selesai" required
                                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                        </div>
                                        <div class="flex justify-end">
                                            <button type="submit"
                                                class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg mr-2">Simpan</button>
                                            <button type="button" @click="isModalOpen = false"
                                                class="bg-gray-300 hover:bg-gray-400 text-black font-bold py-2 px-4 rounded-lg">Batal</button>
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
                    <thead>
                        <tr>
                            <th class="px-4 py-2 text-left border">Kode MK</th>
                            <th class="px-4 py-2 text-middle border">Mata Kuliah</th>
                            <th class="px-4 py-2 text-left border">Semester</th>
                            <th class="px-4 py-2 text-left border">SKS</th>
                            <th class="px-4 py-2 text-left border">Sifat</th>
                            <th class="px-4 py-2 text-middle border">Pengampu</th>
                            <th class="px-4 py-2 text-left border">Kelas</th>
                            <th class="px-4 py-2 text-left border">Ruangan</th>
                            <th class="px-4 py-2 text-left border">Hari</th>
                            <th class="px-4 py-2 text-middle border">Jam</th>
                            <th class="px-4 py-2 text-middle border">Keterangan</th>
                            <th class="px-4 py-2 text-middle border">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($jadwalList as $jadwal)
                            <tr class="even:bg-gray-50">
                                <td class="px-4 py-2 border">{{ $jadwal->kode_mk }}</td>
                                <td class="px-4 py-2 border">{{ $jadwal->nama }}</td>
                                <td class="px-4 py-2 border">{{ $jadwal->semester }}</td>
                                <td class="px-4 py-2 border">{{ $jadwal->sks }}</td>
                                <td class="px-4 py-2 border">{{ $jadwal->sifat }}</td>
                                <td class="px-4 py-2 border">{{ $jadwal->pengampu }}</td>
                                <td class="px-4 py-2 border">{{ $jadwal->kelas }}</td>
                                <td class="px-4 py-2 border">{{ $jadwal->ruangan }}</td>
                                <td class="px-4 py-2 border">{{ $jadwal->hari }}</td>
                                <td class="px-4 py-2 border">{{ $jadwal->jam_mulai }} - {{ $jadwal->jam_selesai }}
                                </td>
                                <td class="px-4 py-2 border">
                                    @if ($jadwal->persetujuan)
                                        <!-- Memeriksa status persetujuan -->
                                        <span class="text-green-500">Disetujui</span>
                                    @else
                                        <span class="text-red-500">Belum Disetujui</span>
                                    @endif
                                </td>
                                <td class="px-4 py-2 border">
                                    @if (!$jadwal->persetujuan)
                                        <!-- Hanya tampilkan tombol jika belum disetujui -->
                                        <button
                                            class="bg-transparent hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-2 px-4 border border-blue-500 hover:border-transparent rounded">Ubah</button>
                                        <button
                                            class="mt-2 bg-transparent hover:bg-red-500 text-red-700 font-semibold hover:text-white py-2 px-4 border border-red-500 hover:border-transparent rounded"
                                            onclick="confirmDelete('{{ route('jadwal.destroy', $jadwal->id) }}')">Hapus</button>
                                    @else
                                        <span class="text-gray-500">Tidak dapat diubah atau dihapus</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
    </section>

    <footer class="bg-[#D9D9D9] bg-opacity-30 mt-52">
        <div class="flex w-2/3 h-20 mx-auto justify-between items-center text-white">
            <p>TIM SiAKAM <span class="font-semibold"> Universitas Diponegoro</span></p>
            <p>Dibangun dengan penuh kekhawatiran 🔥🔥</p>
        </div>
    </footer>
    <script>
        function confirmDelete(url) {
            Swal.fire({
                title: 'Apakah kamu yakin?',
                text: 'Anda tidak akan dapat memulihkan data ini!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Tidak, batalkan!'
            }).then((result) => {
                if (result.isConfirmed) {
                    var form = document.createElement('form');
                    form.method = 'POST';
                    form.action = url;

                    var csrfInput = document.createElement('input');
                    csrfInput.type = 'hidden';
                    csrfInput.name = '_token';
                    csrfInput.value = '{{ csrf_token() }}';
                    form.appendChild(csrfInput);

                    var methodInput = document.createElement('input');
                    methodInput.type = 'hidden';
                    methodInput.name = '_method';
                    methodInput.value = 'DELETE';
                    form.appendChild(methodInput);

                    document.body.appendChild(form);
                    form.submit();
                } else {
                    Swal.fire('Dibatalkan', 'Data Anda aman!', 'error');
                }
            });
        }
    </script>
    @if ($errors->any())
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    html: `
                    <ul style="text-align: center;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                `,
                });
            });
        </script>
    @endif
</body>

</html>

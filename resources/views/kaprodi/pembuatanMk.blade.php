<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>List Pembuatan Mata Kuliah</title>
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
            <p class="font-bold">PEMBUATAN MATA KULIAH</p>
            <a href="{{ route('kaprodi.dashboard') }}">
                <div class="flex items-center">
                    <img src="{{ asset('arrow-left.png') }}" alt="" class="w-8 h-8 mr-1">
                    <p>Dasbor / Pembuatan Mata Kuliah</p>
                </div>
            </a>
        </div>
    </section>
    
    <!-- Main content -->
    <main class="flex-1">
        <section class="w-9/12 mx-auto relative top-36 bg-white rounded-lg pt-5 pb-6" id="body">
            <div class="container-table">
                <div id="table-list">
                    <h2 class="text-2xl text-center mx-auto max-w-64 mt-8">LIST JADWAL MATA KULIAH</h2>
                    <div x-data="{ isModalOpen: false }">
                        <div class="flex justify mt-5 mb-3 ml-20">
                            <button @click="isModalOpen = true" class="h-9 max-w-52 flex items-center justify-center bg-[#002687] text-white rounded-lg px-4 py-2 mb-4 hover:bg-[#001b58]">
                                Tambah Mata Kuliah
                                <img class="w-5 h-5 ml-2" src="{{ asset('plus.svg') }}" alt="">
                            </button>
                        </div>
                        <div x-show="isModalOpen" x-cloak class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-50 z-50">
                            <div class="bg-white rounded-lg shadow-lg w-1/2 max-w-4xl">
                                <div class="flex justify-between items-center border-b px-4 py-2">
                                    <h3 class="text-lg font-semibold">Tambah Mata Kuliah</h3>
                                    <button @click="isModalOpen = false" class="text-gray-400 hover:text-gray-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>

                                <!-- Instruction Section -->
                                <div class="p-6 bg-white rounded-t-lg shadow-lg">
                                    <h4 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">
                                        <span>Petunjuk Pengisian</span>
                                    </h4>

                                    <div x-data="{ open: false }">
                                        <button @click="open = !open" class="flex items-center w-full text-left font-semibold text-blue-600 hover:text-blue-800">
                                            <span class="mr-2">Klik untuk melihat petunjuk pengisian</span>
                                            <svg x-show="!open" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path>
                                            </svg>
                                            <svg x-show="open" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 15l7-7 7 7"></path>
                                            </svg>
                                        </button>

                                        <div x-show="open" x-collapse class="mt-4 text-sm text-gray-700">
                                            <ul class="list-inside space-y-3">
                                                <li>
                                                    <strong class="text-blue-600">Kode MK:</strong>
                                                    Kode mata kuliah harus diawali dengan kode jurusan, diikuti dengan semester dan nomor urut mata kuliah.<br>Contoh: <code class="bg-gray-200 text-gray-800 px-2 py-1 rounded-md">PAIK6101</code>.
                                                </li>
                                                <li>
                                                    <strong class="text-blue-600">Nama:</strong>
                                                    Masukkan nama lengkap mata kuliah.
                                                </li>
                                                <li>
                                                    <strong class="text-blue-600">Semester:</strong>
                                                    Pilih semester mata kuliah (misalnya, Semester 1 -> 1, Semester 2 -> 2).
                                                </li>
                                                <li>
                                                    <strong class="text-blue-600">SKS:</strong>
                                                    Masukkan jumlah SKS untuk mata kuliah tersebut.
                                                </li>
                                                <li>
                                                    <strong class="text-blue-600">Sifat:</strong>
                                                    Pilih apakah mata kuliah ini bersifat WAJIB atau PILIHAN.
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                
                                <form action="{{ route('matkul.store') }}" method="POST" 
                                        class="p-6 bg-white shadow-lg rounded-lg max-w-4xl mx-auto">
                                    @csrf
                                    <h2 class="text-2xl font-semibold text-gray-800 mb-6 text-center">Mata Kuliah</h2>
                                    <div class="md:grid-cols-2 gap-6">
                                        <!-- Kolom Kiri -->
                                        <div class="space-y-4">
                                            <!-- Kode MK -->
                                            <div>
                                                <label for="kode_mk" class="block text-sm font-medium text-gray-600">Kode MK</label>
                                                <input type="text" name="kode_mk" id="kode_mk" placeholder="KODEXXXX"
                                                    class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm transition">
                                            </div>                                         
                                            <!-- Nama -->
                                            <div>
                                                <label for="nama_mk" class="block text-sm font-medium text-gray-600">Nama</label>
                                                <input type="text" name="nama_mk" id="nama_mk"
                                                    class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm transition">
                                            </div>                                            
                                            <!-- Semester -->
                                            <div>
                                                <label for="semester" class="block text-sm font-medium text-gray-600">Semester</label>
                                                <input type="text" name="semester" id="semester"
                                                    class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm transition">
                                            </div>                                            
                                            <!-- SKS -->
                                            <div>
                                                <label for="sks" class="block text-sm font-medium text-gray-600">SKS</label>
                                                <input type="number" name="sks" id="sks"
                                                    class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm transition">
                                            </div>                                            
                                            <!-- Sifat -->
                                            <div>
                                                <label class="block text-sm font-medium text-gray-600">Sifat</label>
                                                <div class="mt-1 space-x-4">
                                                    <label class="inline-flex items-center">
                                                        <input type="radio" name="sifat" value="WAJIB" id="sifat_wajib" class="form-radio h-5 w-5 text-blue-500 focus:ring-blue-500">
                                                        <span class="ml-2 text-sm text-gray-600">WAJIB</span>
                                                    </label>
                                                    <label class="inline-flex items-center">
                                                        <input type="radio" name="sifat" value="PILIHAN" id="sifat_pilihan" class="form-radio h-5 w-5 text-blue-500 focus:ring-blue-500">
                                                        <span class="ml-2 text-sm text-gray-600">PILIHAN</span>
                                                    </label>
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
                <div class="overflow-x-auto mb-4" id="mataKuliahContainer">
                    @if($filteredMataKuliah->isEmpty())
                        <div class="flex flex-col items-center justify-center py-5 text-gray-500">
                            <h3 class="text-lg font-semibold">Belum Ada Data</h3>
                            <p class="text-sm">Silakan tambahkan data terlebih dahulu menggunakan tombol di atas.</p>
                        </div>
                    @else
                        @include('kaprodi.partialMataKuliah')
                    @endif
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

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Tangkap klik pada pagination
            document.addEventListener('click', function (e) {
                if (e.target.closest('#paginationLinks a')) {
                    e.preventDefault();
                    const url = e.target.closest('a').href;

                    // Panggil data baru menggunakan fetch
                    fetch(url, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                        .then(response => response.text())
                        .then(html => {
                            document.getElementById('mataKuliahContainer').innerHTML = html;
                        })
                        .catch(error => console.error('Error fetching data:', error));
                }
            });
        });
    </script>
</body>
</html>

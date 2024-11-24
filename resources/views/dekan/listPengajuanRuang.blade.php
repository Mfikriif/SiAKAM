<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>List Pengajuan Ruang Kuliah</title>
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
        <div class="w-2/3 mx-auto flex justify-between text-lg text-white" id="container-navigation">
            <p class="font-bold">PENGAJUAN RUANG</p>
            <a href="{{ route('dekan.dashboard') }}">
                <div class="flex items-center">
                    <img src="{{ asset('arrow-left.png') }}" alt="" class="w-8 h-8 mr-1">
                    <p>Dasbor / Pengajuan Ruang</p>
                </div>
            </a>
        </div>
    </section>

        <!-- Main Content -->
        <main class="flex-1" x-data="{ jurusanFilter: '' }">
            <section class="w-9/12 mx-auto relative top-36 bg-white rounded-lg pt-5 pb-6" id="body">
                <div class="container-table">
                    <h2 class="text-2xl text-center mx-auto max-w-64 mt-8">LIST PENGAJUAN RUANG KULIAH</h2>
    
                    <div class="flex items-center justify-end mt-4 mx-20 space-x-4">
                        <div class="flex items-center">
                            <label for="jurusanFilter" class="mr-2">Jurusan:</label>
                            <select name="jurusanFilter" id="jurusanFilter" onchange="filterRuangan()" class="border rounded px-4 py-1 w-52">
                                <option value="">-- Semua Jurusan --</option>
                                <option value="Informatika">Informatika</option>
                                <option value="Bioteknologi">Bioteknologi</option>
                            </select>
                        </div>
                        <button onclick="approveAllRuangan()" class="bg-green-600 text-white font-semibold px-4 py-1 rounded transition duration-200 hover:bg-white hover:text-green-600 border border-green-600">
                            Setujui Semua
                        </button>
                    </div>
    
                    <div class="overflow-x-auto mb-4" id="pengajuanRuangContainer">
                        @if($ruanganList->isEmpty())
                            <div class="flex flex-col items-center justify-center py-5 text-gray-500">
                                <h3 class="text-lg font-semibold">Belum Ada Data</h3>
                                <p class="text-sm">Silakan tambahkan data terlebih dahulu menggunakan tombol di atas.</p>
                            </div>
                        @else
                            @include('dekan.partialPengajuanRuang')
                        @endif
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

    <script>
        document.addEventListener('DOMContentLoaded', function () {
        // Tangkap klik pada pagination jadwal
        document.addEventListener('click', function (e) {
            if (e.target.closest('#paginationLinksPengajuanRuang a')) {
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
                        document.getElementById('pengajuanRuangContainer').innerHTML = html;
                    })
                    .catch(error => console.error('Error fetching data:', error));
                }
            });
        });
    </script>
</body>

</html>
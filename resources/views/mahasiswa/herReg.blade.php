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
        <div class="w-2/3 mx-auto flex justify-between text-white">
            <p class="font-bold">Her-Registrasi</p>
            <a href="{{ route('mahasiswa.dashboard') }}" class="flex items-center">
                <img src="{{ asset('home-outline.svg') }}" alt="Home">
                <p class="ml-2">Dasbor / Her-Registrasi</p>
            </a>
        </div>
        <div class="flex flex-col container mx-auto mt-28">
            <p class="text-white text-center font-bold text-3xl">Pilih Status Akademik</p>
            <p class="text-white text-center font-normal text-xl mt-3">Silahkan Pilih Salah Satu Status Akademik Berikut Untuk Semester Ini</p>
        </div>
    </section>

    <section class="w-10/12 mx-auto relative top-36 rounded-lg pt-5 pb-10">
        <div class="flex justify-center space-x-10 mt-auto">
            <!-- Aktif Container -->
            <div id="aktif-container" class="bg-white p-6 rounded-lg shadow-lg text-center w-1/3">
                <img src="{{ asset('aktif.svg') }}" alt="Aktif" class="mx-auto mb-4 w-16 h-16">
                <div class="text-4xl font-bold mb-2">Aktif</div>
                <p class="text-gray-700 mb-4">Anda akan mengikuti kegiatan perkuliahan pada semester ini serta mengisi Isian Rencana Studi (IRS).</p>
    
                @if ($mahasiswa->status === 1)
                    <!-- Jika status aktif -->
                    <form action="{{ route('mahasiswa.batalkanStatus', $mahasiswa->id) }}" method="POST" id="form-batal-aktif">
                        @csrf
                        <button 
                            type="button" 
                            onclick="confirmSubmit('form-batal-aktif', 'batalkan status Aktif')" 
                            class="bg-transparent hover:bg-blue-600 text-blue-800 font-semibold hover:text-white py-2 px-6 border border-blue-600 hover:border-transparent rounded">
                            Batalkan
                        </button>
                    </form>
                @elseif ($mahasiswa->status === 0)
                    <!-- Jika status belum dipilih -->
                    <form action="{{ route('mahasiswa.setAktif', $mahasiswa->id) }}" method="POST" id="form-aktif">
                        @csrf
                        <button 
                            type="button" 
                            onclick="confirmSubmit('form-aktif', 'aktif')" 
                            class="bg-blue-900 text-white font-normal py-2 px-6 rounded-lg hover:bg-blue-700 transition duration-200">
                            Pilih
                        </button>
                    </form>
                @endif
            </div>
    
            <!-- Cuti Container -->
            <div id="cuti-container" class="bg-white p-6 rounded-lg shadow-lg text-center w-1/3">
                <img src="{{ asset('cuti.svg') }}" alt="Cuti" class="mx-auto mb-4 w-16 h-16">
                <div class="text-4xl font-bold mb-2">Cuti</div>
                <p class="text-gray-700 mb-4">Menghentikan kuliah sementara untuk semester ini tanpa kehilangan status sebagai mahasiswa Undip.</p>
    
                @if ($mahasiswa->status === -1)
                    <!-- Jika status cuti -->
                    <form action="{{ route('mahasiswa.batalkanStatus', $mahasiswa->id) }}" method="POST" id="form-batal-cuti">
                        @csrf
                        <button 
                            type="button" 
                            onclick="confirmSubmit('form-batal-cuti', 'batalkan status Cuti')" 
                            class="bg-transparent hover:bg-blue-600 text-blue-800 font-semibold hover:text-white py-2 px-6 border border-blue-600 hover:border-transparent rounded">
                            Batalkan
                        </button>
                    </form>
                @elseif ($mahasiswa->status === 0)
                    <!-- Jika status belum dipilih -->
                    <form action="{{ route('mahasiswa.setCuti', $mahasiswa->id) }}" method="POST" id="form-cuti">
                        @csrf
                        <button 
                            type="button" 
                            onclick="confirmSubmit('form-cuti', 'cuti')" 
                            class="bg-blue-900 text-white font-normal py-2 px-6 rounded-lg hover:bg-blue-700 transition duration-200">
                            Pilih
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-[#D9D9D9] bg-opacity-30 mt-96">
        <div class="flex w-2/3 h-20 mx-auto justify-between items-center text-white">
            <p>TIM SiAKAM <span class="font-semibold"> Universitas Diponegoro</span></p>
            <p>Dibangun dengan penuh kekhawatiran 🔥🔥</p>
        </div>
    </footer>

    <script>
        function confirmSubmit(formId, action) {
            Swal.fire({
                title: 'Konfirmasi',
                text: `Apakah Anda yakin ingin ${action}?`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Lanjutkan',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById(formId).submit();
                }
            });
        }
        
        // Function to disable/reduce other container when one is selected
        document.addEventListener('DOMContentLoaded', function () {
            const aktifContainer = document.getElementById('aktif-container');
            const cutiContainer = document.getElementById('cuti-container');
    
            if ({{ $mahasiswa->status }} === 1) {
                // If "Aktif" is selected, reduce opacity of "Cuti"
                cutiContainer.style.opacity = '0.5';
                cutiContainer.querySelector('button').disabled = true;
            } else if ({{ $mahasiswa->status }} === -1) {
                // If "Cuti" is selected, reduce opacity of "Aktif"
                aktifContainer.style.opacity = '0.5';
                aktifContainer.querySelector('button').disabled = true;
            }
        });
    </script>
</body>

</html>
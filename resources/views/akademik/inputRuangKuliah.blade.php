<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Input Ruang Kuliah</title>
    @vite('resources/css/app.css')
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</head>

<body class="bg-gradient-to-r from-fuchsia-800 from-1% to bg-pink-500">
    <nav class="bg-black" x-data="{ isOpen: false }">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex h-16 items-center justify-between">
                <div class="flex items-center">
                    <a href="{{ route('akademik.dashboard') }}" class="flex items-center">
                        <img class="h-9 w-8" src="{{ asset('undipLogo.png') }}" alt="Your Company">
                        <h3 class="ml-2 text-white">SiAKAM Undip</h3>
                    </a>
                </div>
                <div class="hidden md:block">
                    <div class="ml-4 flex items-center md:ml-6">
                        <button type="button"
                            class="relative rounded-full bg-gray-800 p-1 text-gray-400 hover:text-white focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800">
                            <span class="sr-only">View notifications</span>
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
                            </svg>
                        </button>
                        <h3 class="ml-3 text-white">{{ Auth::user()->name }}</h3>
                        <div class="relative ml-3">
                            <button type="button" @click="isOpen = !isOpen"
                                class="relative flex max-w-xs items-center rounded-full bg-gray-800 text-sm focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800"
                                id="user-menu-button" aria-expanded="false" aria-haspopup="true">
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
                                    class="block px-4 py-2 text-sm text-gray-700" role="menuitem"
                                    tabindex="-1">Logout</a>
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
            <p class="font-bold">INPUT RUANG KULIAH</p>
            <a href="{{ route('akademik.listRuangKuliah') }}">
                <div class="flex items-center">
                    <img src="{{ asset('arrow-left.png') }}" alt="" class="w-8 h-8 mr-1">
                    <p>Kembali / List Ruang Kuliah</p>
                </div>
            </a>
        </div>
    </section>

    <section class="w-2/3 mx-auto relative top-36 bg-white rounded-lg p-6" id="body">
        <h2 class="text-2xl text-center text-gray-800 mb-6">INPUT RUANG KULIAH</h2>
        <form action="{{ route('Ruangan.store') }}" method="POST" class="w-full">
            @csrf
            <div class="flex justify-between w-101 mx-auto">
                <div id="input-prodi-kapasitas">
                    <div class="mb-4 w-80">
                        <label for="jurusan" class="block text-gray-700">Program Studi:</label>
                        <select id="jurusan" name="jurusan"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                            <option value="" disabled selected>-- Pilih Prodi --</option>
                            <option value="Informatika">Informatika</option>
                            <option value="Matematika">Matematika</option>
                            <option value="Biologi">Biologi</option>
                            <option value="Statistika">Statistika</option>
                            <option value="Bioteknologi">Bioteknologi</option>
                            <option value="Fisika">Fisika</option>
                            <option value="Kimia">Kimia</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="kapasitas" class="block text-gray-700">Kapasitas:</label>
                        <input type="number" id="kapasitas" name="kapasitas" placeholder="Masukkan kapasitas"
                            min="1" class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                    </div>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700">Ruangan:</label>
                    <div class="grid grid-cols-4 gap-2">
                        @foreach ($daftarRuangan as $item)
                            <div class="flex items-center">
                                <input type="checkbox" 
                                    id="{{ $item->kode_ruangan }}" 
                                    name="kode_ruangan[]"
                                    value="{{ $item->kode_ruangan }}" 
                                    class="mr-2"
                                    @if (in_array($item->kode_ruangan, $kodeRuanganSelected)) 
                                        checked disabled class="opacity-50 cursor-not-allowed"
                                    @endif>
                                <label for="{{ $item->kode_ruangan }}" 
                                    class="text-gray-700" @if (in_array($item->kode_ruangan, $kodeRuanganSelected)) opacity-50 @endif>{{ $item->kode_ruangan }}</label>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="flex justify-center mt-6">
                <button type="submit"
                    class="bg-blue-700 hover:bg-blue-800 text-white px-4 py-2 rounded-lg mr-2">Simpan</button>
                <button type="reset"
                    class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg">Batalkan</button>
            </div>
        </form>
    </section>

    <footer class="bg-[#D9D9D9] bg-opacity-30 mt-52">
        <div class="flex w-2/3 h-20 mx-auto justify-between items-center text-white">
            <p>TIM SiAKAM <span class="font-semibold"> Universitas Diponegoro</span></p>
            <p>Dibangun dengan penuh kekhawatiran 🔥🔥</p>
        </div>
    </footer>

    @if ($errors->has('conflict'))
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'error',
                title: 'Waduh...',
                text: '{{ $errors->first('conflict') }}',
                confirmButtonText: 'OK'
            });
        });
    </script>
    @endif

</body>

</html>

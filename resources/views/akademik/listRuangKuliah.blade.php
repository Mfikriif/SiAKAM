<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>List Ruang Kuliah</title>
    @vite('resources/css/app.css')
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</head>

<body class="bg-gradient-to-r from-fuchsia-800 from-1% to bg-pink-500 ">
    <nav class="bg-black" x-data="{ isOpen: false }">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex h-16 items-center justify-between">
                <div class="flex items-center">
                    <div class="flex">
                        <a href="{{ route('kaprodi.dashboard') }}" class="flex items-center">
                            <img class="h-9 w-8" src="{{ asset('undipLogo.png') }}" alt="Your Company">
                            <h3 class="ml-2 text-white">SiAKAM Undip</h3>
                        </a>
                    </div>
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

    <section class="w-2/3 mx-auto relative top-36 bg-white rounded-lg pt-6" id="body" x-data="{ openModal: false, currentData: {} }">
        <div class="container-table ">
            <div id="table-list">
                <h2 class="text-2xl text-center mx-auto max-w-64 mt-5">LIST RUANG KULIAH</h2>

                <!-- Tombol Atur Ruang dan Search -->
                <div class="flex justify-between items-center w-11/12 mx-auto mt-5 mb-3">
                    <a href="{{ route('akademik.inputRuangKuliah') }}" class="h-8 w-32 inline-flex bg-[#002687] text-white rounded-lg pt-1 pl-2">
                        Atur Ruang
                        <img class="w-5 h-5 pt-1 ml-2" src="{{ asset('plus.svg') }}" alt="">
                    </a>
                    <div class="flex items-center">
                        <input class="bg-[#002687] rounded-l-xl h-8 mr-1 text-white px-2" placeholder="Search" type="text">
                        <button class="bg-[#002687] h-8 w-8 rounded-r-xl pl-2">
                            <img src="{{ asset('searchLogo.svg') }}" alt="">
                        </button>
                    </div>
                </div>

                <!-- Tabel Ruang Kuliah -->
                <div class="flex flex-col">
                    <div class=" overflow-x-auto pb-4">
                        <div class="min-w-full inline-block align-middle">
                            <div class="overflow-hidden border rounded-lg border-gray-300 w-11/12 mx-auto">
                                <table class="table-auto min-w-full rounded-xl">
                                    <thead>
                                        <tr class="bg-gray-50">
                                            <th class="p-5 text-center whitespace-nowrap text-sm font-semibold text-gray-900 capitalize">NO</th>
                                            <th class="p-5 text-left whitespace-nowrap text-sm font-semibold text-gray-900 capitalize">PROGRAM STUDI</th>
                                            <th class="p-5 text-left whitespace-nowrap text-sm font-semibold text-gray-900 capitalize">RUANGAN</th>
                                            <th class="p-5 text-left whitespace-nowrap text-sm font-semibold text-gray-900 capitalize">KETERANGAN</th>
                                            <th class="p-5 text-left whitespace-nowrap text-sm font-semibold text-gray-900 capitalize">AKSI</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-300">
                                        @foreach ($ruangan as $index => $room)
                                        <tr class="bg-white transition-all duration-500 hover:bg-gray-50">
                                            <td class="p-5 text-center text-sm font-medium text-gray-900">{{ $index + 1 }}</td>
                                            <td class="p-5 text-sm font-medium text-gray-900">{{ $room->jurusan }}</td>
                                            <td class="p-5 text-sm font-medium text-gray-900">{{ $room->kode_ruangan }}</td>
                                            <td class="p-5 text-sm font-medium text-gray-900">
                                                <span class="{{ $room->persetujuan ? 'text-green-500' : 'text-red-500' }}">
                                                    {{ $room->persetujuan ? 'Disetujui' : 'Belum Disetujui' }}
                                                </span>
                                            </td>
                                            <td>
                                                <button @click="openModal = true; currentData = { id: '{{ $room->id }}', jurusan: '{{ $room->jurusan }}', kapasitas: '{{ $room->kapasitas }}', kode_ruangan: '{{ $room->kode_ruangan }}' }"
                                                    class="bg-blue-700 hover:bg-blue-800 text-white px-4 py-2 rounded-lg">Edit</button>
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
        </div>

        <!-- Modal Edit -->
        <template x-if="openModal">
            <div class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">
                <div class="bg-white w-1/2 p-6 rounded-lg shadow-lg">
                    <h2 class="text-2xl font-semibold text-center mb-4">Edit Ruang Kuliah</h2>
                    <form :action="`/akademik/updateRuangKuliah/${currentData.id}`" method="POST" class="mx-auto max-w-lg">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-4">
                            <label for="jurusan" class="block text-gray-700">Program Studi:</label>
                            <select id="jurusan" name="jurusan" x-model="currentData.jurusan" class="w-full px-3 py-2 border border-gray-300 rounded-lg">
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
                            <input type="number" id="kapasitas" name="kapasitas" x-model="currentData.kapasitas" class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                        </div>

                        <div class="mb-4">
                            <label for="kode_ruangan" class="block text-gray-700">Kode Ruangan:</label>
                            <input type="text" id="kode_ruangan" name="kode_ruangan" x-model="currentData.kode_ruangan" class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                        </div>

                        <div class="flex justify-center mt-6">
                            <button type="submit" class="bg-blue-700 hover:bg-blue-800 text-white px-4 py-2 rounded-lg mr-2">Simpan</button>
                            <button type="button" @click="openModal = false" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg">Batalkan</button>
                        </div>
                    </form>
                </div>
            </div>
        </template>
    </section>

    <footer class="bg-[#D9D9D9] bg-opacity-30 mt-52">
        <div class="flex w-2/3 h-20 mx-auto justify-between items-center text-white">
            <p>TIM SiAKAM <span class="font-semibold"> Universitas Diponegoro</span></p>
            <p>Dibangun dengan penuh kekhawatiran 🔥🔥</p>
        </div>
    </footer>
</body>

</html>

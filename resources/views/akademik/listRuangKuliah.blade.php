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
                                <img class="h-8 w-8 rounded-full" src="{{ asset('firmanUtina.png') }}" alt="">
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
        <div class="w-2/3 mx-auto flex justify-between text-white" id="container-navigation">
            <p class="font-bold">List Ruang Kuliah</p>
            <a href="{{ route('akademik.dashboard') }}">
                <div class="flex">
                    <img src="{{ asset('home-outline.svg') }}" alt="">
                    <p class="ml-2">Dasbor / List Ruang Kuliah</p>
                </div>
            </a>
        </div>
    </section>

    <section class="w-2/3 mx-auto relative top-36 bg-white rounded-lg pt-6" id="body" x-data="{ openIndex: null, openModal: false, currentData: {} }">
        <div class="container-table">
            <div id="table-list">
                <h2 class="text-2xl text-center mx-auto max-w-64 mt-5">LIST RUANG KULIAH</h2>

                <!-- Tombol Atur Ruang dan Search -->
                <div class="flex justify-between items-center w-11/12 mx-auto mt-5 mb-3">
                    <a href="{{ route('akademik.inputRuangKuliah') }}" class="h-8 w-32 inline-flex bg-[#002687] text-white rounded-lg pt-1 pl-2">
                        Atur Ruang
                        <img class="w-5 h-5 pt-1 ml-2" src="{{ asset('plus.svg') }}" alt="">
                    </a>
                    <div class="flex items-center">
                        <form method="GET" action="{{ route('akademik.listRuangKuliah') }}" class="flex items-center">
                            <input 
                                type="text" 
                                name="search" 
                                value="{{ request('search') }}" 
                                class="bg-[#002687] rounded-l-xl h-8 mr-1 text-white px-2" 
                                placeholder="Search">
                            <button type="submit" class="bg-[#002687] h-8 w-8 rounded-r-xl pl-2">
                                <img src="{{ asset('searchLogo.svg') }}" alt="">
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Accordion Tabel Ruang Kuliah -->
                <div class="flex flex-col space-y-4" x-data="{ openIndex: null, openModal: false, currentData: {} }">
                    <div class="overflow-hidden border rounded-lg border-gray-300 w-11/12 mx-auto my-6 p-4">
                        @foreach ($ruangan as $index => $ruang)
                            <div class="border-b mb-3 rounded-lg overflow-hidden">
                                <!-- Accordion Header -->
                                <div class="flex justify-between p-4 cursor-pointer bg-gray-50 hover:bg-gray-100 transition-colors duration-300"
                                     :class="openIndex === {{ $index }} ? 'bg-gray-100' : ''"
                                     @click="openIndex = openIndex === {{ $index }} ? null : {{ $index }}">
                                    <div>
                                        <span class="font-semibold text-gray-900">{{ $index + 1 }}. {{ $ruang->jurusan }}</span>
                                        <span class="ml-4">{{ $ruang->kode_ruangan }}</span>
                                    </div>
                                    <svg :class="openIndex === {{ $index }} ? 'transform rotate-180' : ''"
                                         class="h-5 w-5 text-gray-600 transition-transform"
                                         xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                         stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M19 9l-7 7-7-7" />
                                    </svg>
                                </div>
                                
                                <!-- Accordion Content -->
                                <div x-show="openIndex === {{ $index }}" x-collapse>
                                    <div class="p-5 bg-white rounded-b-lg shadow-inner">
                                        <div x-data="{ checkAll: false }" class="overflow-hidden w-full rounded-md border border-neutral-300">
                                            <table class="w-full text-left text-sm text-neutral-600">
                                                <thead class="border-b border-neutral-300 bg-grey-100 text-neutral-900">
                                                    <tr>
                                                        <th scope="col" class="p-4">No</th>
                                                        <th scope="col" class="p-4">Kode Ruangan</th>
                                                        <th scope="col" class="p-4">Kapasitas</th>
                                                        <th scope="col" class="p-4">Status</th>
                                                        <th scope="col" class="p-4">Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="divide-y divide-neutral-0">
                                                    @foreach($ruang->ruang as $kode)
                                                    <tr>
                                                        <td class="p-4">{{ $loop->iteration }}</td>
                                                        <td class="p-4">{{ $kode->kode_ruangan }}</td>
                                                        <td class="p-4">{{ $kode->kapasitas }}</td>
                                                        <td class="p-4 {{ $kode->persetujuan == 1 ? 'text-green-500' : ($kode->persetujuan == 0 ? 'text-yellow-500' : 'text-red-500') }}">
                                                            {{ $kode->persetujuan == 1 ? 'Disetujui' : ($kode->persetujuan == 0 ? 'Belum Disetujui' : 'Ditolak') }}
                                                        </td>
                                                        <td class="p-4">
                                                            @if($kode->persetujuan == -1)
                                                            <button onclick="confirmDelete('{{ route('Ruangan.destroy', $kode->id) }}')" class="bg-transparent hover:bg-red-500 text-red-700 font-semibold hover:text-white py-1 px-2 border border-red-500 hover:border-transparent rounded transition duration-200">
                                                                Hapus
                                                            </button>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                
                </div>
            </div>
        </div>
        
    </section>

    <footer class="bg-[#D9D9D9] bg-opacity-30 mt-52">
        <div class="flex w-2/3 h-20 mx-auto justify-between items-center text-white">
            <p>TIM SiAKAM <span class="font-semibold"> Universitas Diponegoro</span></p>
            <p>Dibangun dengan penuh kekhawatiran 🔥🔥</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
</body>

</html>

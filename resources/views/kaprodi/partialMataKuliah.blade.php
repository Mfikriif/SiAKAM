<table class="w-11/12 mx-auto text-center mt-2 border-separate border-spacing-y-3 pb-8">
    <thead class="bg-gray-100 text-gray-700">
        <tr>
            <th class="px-2 py-4 border-b">Kode MK</th>
            <th class="px-2 py-4 border-b">Mata Kuliah</th>
            <th class="px-2 py-4 border-b">Semester</th>
            <th class="px-2 py-4 border-b">SKS</th>
            <th class="px-2 py-4 border-b">Sifat</th>
            <th class="px-2 py-4 border-b">Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach($filteredMataKuliah as $matkul)
            <tr class="even:bg-gray-50 hover:bg-gray-100 transition duration-200">
                <td class="px-2 py-1 border w-32">{{ $matkul->kode_mk }}</td>
                <td class="px-2 py-1 border w-96">{{ $matkul->nama_mk }}</td>
                <td class="px-2 py-1 border w-32">{{ $matkul->semester }}</td>
                <td class="px-2 py-1 border w-32">{{ $matkul->sks }}</td>
                <td class="px-2 py-1 border w-32">{{ $matkul->sifat }}</td>
                <td class="px-2 py-1 border w-44">
                    <div x-data="{isEditModalOpen: false, selectedJadwal: null}">
                        <button @click="isEditModalOpen = true; selectedJadwal = {{ json_encode($matkul) }}; calculateJamSelesai()" class="bg-transparent hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-2 px-4 border border-blue-500 hover:border-transparent rounded transition duration-200">
                            Ubah
                        </button>
                        <button class="mt-2 bg-transparent hover:bg-red-500 text-red-700 font-semibold hover:text-white py-2 px-4 border border-red-500 hover:border-transparent rounded transition duration-200" 
                        onclick="confirmDelete('{{ route('matkul.destroy', $matkul->kode_mk) }}')">
                            Hapus
                        </button>                                
                        <!-- Form Edit Modal -->
                        <div x-show="isEditModalOpen" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-50 z-50">
                            <div class="bg-white rounded-lg shadow-lg w-11/12 max-w-4xl p-6">
                                <div class="flex justify-between items-center border-b pb-3 mb-4">
                                    <h3 class="text-lg font-semibold">Ubah Mata Kuliah</h3>
                                    <button @click="isEditModalOpen = false" class="text-gray-500 hover:text-gray-600">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>                                
                                <!-- Form untuk Edit Data -->
                                <form :action="`/matkul/update/${selectedJadwal.kode_mk}`" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <h2 class="text-2xl font-semibold text-gray-800 mb-4">Edit Jadwal</h2>
                                    <div class="md:grid-cols-2 gap-6">
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
                                                <label for="nama_mk" class="block text-sm font-medium text-gray-600">Nama</label>
                                                <input type="text" name="nama_mk" id="nama_mk" x-model="selectedJadwal.nama_mk" required
                                                    class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm transition">
                                            </div>
                                            <!-- Semester -->
                                            <div>
                                                <label for="semester" class="block text-sm font-medium text-gray-600">Semester</label>
                                                <input type="text" name="semester" id="semester" x-model="selectedJadwal.semester" required
                                                    class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm transition">
                                            </div>
                                            <!-- Sks -->
                                            <div>
                                                <label for="sks" class="block text-sm font-medium text-gray-600">SKS</label>
                                                <input type="text" name="sks" id="sks" x-model="selectedJadwal.sks" required
                                                    class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm transition">
                                            </div>
                                            <!-- Sifat -->
                                            <div>
                                                <label class="block text-sm font-medium text-gray-600">Sifat</label>
                                                <div class="mt-1 space-x-4">
                                                    <label class="inline-flex items-center">
                                                        <input type="radio" name="sifat" value="WAJIB" id="sifat_wajib" class="form-radio h-5 w-5 text-blue-500 focus:ring-blue-500"
                                                            x-bind:checked="selectedJadwal.sifat === 'WAJIB'">
                                                        <span class="ml-2 text-sm text-gray-600">WAJIB</span>
                                                    </label>
                                                    <label class="inline-flex items-center">
                                                        <input type="radio" name="sifat" value="PILIHAN" id="sifat_pilihan" class="form-radio h-5 w-5 text-blue-500 focus:ring-blue-500"
                                                            x-bind:checked="selectedJadwal.sifat === 'PILIHAN'">
                                                        <span class="ml-2 text-sm text-gray-600">PILIHAN</span>
                                                    </label>
                                                </div>
                                            </div>
                                            <!-- Tombol Simpan dan Batal -->
                                            <div class="flex justify-end mt-6 space-x-4">
                                                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg shadow-lg transition duration-200">Simpan</button>
                                                <button type="button" @click="isEditModalOpen = false" class="bg-gray-300 hover:bg-gray-400 text-black font-bold py-2 px-4 rounded-lg shadow-lg transition duration-200">Batal</button>
                                            </div>                                
                                        </div>
                                    </div>                                
                                </form>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

<div class="flex justify-center mt-6" id="paginationLinks">
    {{ $filteredMataKuliah->onEachSide(1)->links('pagination::tailwind') }}
</div>
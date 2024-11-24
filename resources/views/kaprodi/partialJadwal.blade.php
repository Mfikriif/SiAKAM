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
            <th class="px-2 py-4 border-b">Kuota Kelas</th>
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
                <td class="px-2 py-4 border">{{ $jadwal->kuota_kelas }}</td>
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

                                                <!-- Sifat -->
                                                <div>
                                                    <label for="sifat" class="block text-sm font-medium text-gray-600">Sifat</label>
                                                    <input type="text" name="sifat" id="sifat" x-model="selectedJadwal.sifat" readonly required
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

                                                <!-- Kuota Ruangan -->
                                                <div>
                                                    <label for="kuota_kelas" class="block text-sm font-medium text-gray-600">Kuota Kelas</label>
                                                    <input type="text" name="kuota_kelas" id="semester" x-model="selectedJadwal.kuota_kelas" required
                                                        class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm transition">
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
                                                        <input type="time" name="jam_mulai" id="jam_mulai" x-model="selectedJadwal.jam_mulai" @change="calculateJamSelesai()"  required
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

<div class="flex justify-center mt-6" id="paginationLinksJadwal">
    {{ $filteredJadwalList->links('pagination::tailwind') }}
</div>
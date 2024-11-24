<table class="w-11/12 mx-auto text-center mt-2 border-separate border-spacing-y-3 pb-8">
    <thead class="bg-gray-100 text-gray-700">
        <tr>
            <th class="px-4 py-2 border">Kode MK</th>
            <th class="px-4 py-2 border">Mata Kuliah</th>
            <th class="px-4 py-2 border">Semester</th>
            <th class="px-4 py-2 border">SKS</th>
            <th class="px-4 py-2 border">Sifat</th>
            <th class="px-4 py-2 border">Koordinator</th>
            <th class="px-4 py-2 border">Pengampu</th>
            <th class="px-4 py-2 border">Kelas</th>
            <th class="px-4 py-2 border">Ruangan</th>
            <th class="px-4 py-2 border">Hari</th>
            <th class="px-4 py-2 border">Jam</th>
            <th class="px-4 py-2 border">Aksi</th>
            <th class="px-4 py-2 border">Keterangan</th>
        </tr>
    </thead>
    <tbody id="jadwal-tbody">
        @foreach($jadwalList as $jadwal)
            <tr class="even:bg-gray-50 hover:bg-gray-100 transition duration-200" data-semester="{{ $jadwal->semester }}">
                <td class="px-4 py-7 border">{{ $jadwal->kode_mk }}</td>
                <td class="px-4 py-2 border">{{ $jadwal->nama }}</td>
                <td class="px-4 py-2 border">{{ $jadwal->semester }}</td>
                <td class="px-4 py-2 border">{{ $jadwal->sks }}</td>
                <td class="px-4 py-2 border">{{ $jadwal->sifat }}</td>
                <td class="px-4 py-2 border">{{ $jadwal->koordinator_mk }}</td>
                <td class="px-4 py-2 border">
                    {{ implode(', ', array_filter([$jadwal->pengampu_1, $jadwal->pengampu_2, $jadwal->pengampu_3])) ?: 'Tidak ada pengampu' }}
                </td>
                <td class="px-4 py-2 border">{{ $jadwal->kelas }}</td>
                <td class="px-4 py-2 border">{{ $jadwal->ruangan }}</td>
                <td class="px-4 py-2 border">{{ $jadwal->hari }}</td>
                <td class="px-4 py-2 border">{{ $jadwal->jam_mulai }} - {{ $jadwal->jam_selesai }}</td>
                <td class="px-4 py-2 border w-44" id="aksi-{{ $jadwal->id }}">
                    <div class="flex justify-center space-x-2">
                        @if ($jadwal->persetujuan === 0)
                            <button onclick="approveRejectJadwal({{ $jadwal->id }}, 'approve')" class="bg-transparent hover:bg-green-500 text-green-700 font-semibold hover:text-white py-1 px-2 border border-green-500 hover:border-transparent rounded">Setujui</button>
                            <button onclick="approveRejectJadwal({{ $jadwal->id }}, 'reject')" class="bg-transparent hover:bg-red-500 text-red-700 font-semibold hover:text-white py-1 px-2 border border-red-500 hover:border-transparent rounded">Tolak</button>
                        @elseif ($jadwal->persetujuan === 1)
                            <button onclick="approveRejectJadwal({{ $jadwal->id }}, 'cancel')" class="bg-transparent hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-1 px-2 border border-blue-500 hover:border-transparent rounded">Batalkan Persetujuan</button>
                        @elseif ($jadwal->persetujuan === -1)
                            <button onclick="approveRejectJadwal({{ $jadwal->id }}, 'cancel')" class="bg-transparent hover:bg-red-500 text-red-700 font-semibold hover:text-white py-1 px-2 border border-red-500 hover:border-transparent rounded">Batalkan Penolakan</button>
                        @endif
                    </div>
                </td>
                <td class="px-4 py-2 border" id="status-{{ $jadwal->id }}">
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

<div class="flex justify-center mt-6" id="paginationLinksPengajuanJadwal">
    {{ $jadwalList->links('pagination::tailwind') }}
</div>
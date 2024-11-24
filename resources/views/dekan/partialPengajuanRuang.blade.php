<table class="w-11/12 mx-auto text-center mt-2 border-separate border-spacing-y-2 pb-8">
    <thead class="bg-gray-100 text-gray-700">
        <tr>
            <th class="px-2 py-1 border">No</th>
            <th class="px-2 py-1 border">Program Studi</th>
            <th class="px-2 py-1 border">Kapasitas</th>
            <th class="px-2 py-1 border">Ruangan</th>
            <th class="px-2 py-1 border w-44">Aksi</th>
            <th class="px-2 py-1 border w-36">Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($ruanganList as $index => $ruangan)
            <tr class="even:bg-gray-50 hover:bg-gray-100 transition duration-200 jurusan-row" data-jurusan="{{ $ruangan->jurusan }}">
                <td class="px-2 py-6 border">{{ $index + 1 }}.</td>
                <td class="px-2 py-1 border">{{ $ruangan->jurusan }}</td>
                <td class="px-2 py-1 border">{{ $ruangan->kapasitas }}</td>
                <td class="px-2 py-1 border max-w-xs overflow-hidden text-ellipsis whitespace-nowrap">{{ $ruangan->kode_ruangan }}</td>
                <td class="px-2 py-1 border" id="aksi-{{ $ruangan->id }}">
                    <div class="flex justify-center space-x-2">
                        @if ($ruangan->persetujuan === 0)
                            <button onclick="approveReject({{ $ruangan->id }}, 'approve')" class="bg-transparent hover:bg-green-500 text-green-700 font-semibold hover:text-white py-1 px-2 border border-green-500 hover:border-transparent rounded">
                                Terima
                            </button>
                            <button onclick="approveReject({{ $ruangan->id }}, 'reject')" class="bg-transparent hover:bg-red-500 text-red-700 font-semibold hover:text-white py-1 px-2 border border-red-500 hover:border-transparent rounded">
                                Tolak
                            </button>
                        @elseif ($ruangan->persetujuan === 1)
                            <button onclick="changeStatus({{ $ruangan->id }})" class="bg-transparent hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-1 px-2 border border-blue-500 hover:border-transparent rounded">
                                Batalkan Persetujuan
                            </button>
                        @elseif ($ruangan->persetujuan === -1)
                            <button onclick="approveReject({{ $ruangan->id }}, 'cancel-reject')" class="bg-transparent hover:bg-red-500 text-red-700 font-semibold hover:text-white py-1 px-2 border border-red-500 hover:border-transparent rounded">
                                Batalkan Penolakan
                            </button>
                        @endif
                    </div>
                </td>
                <td class="px-2 py-1 border" id="status-{{ $ruangan->id }}">
                    @if ($ruangan->persetujuan === 1)
                        <span class="text-green-500">Disetujui</span>
                    @elseif ($ruangan->persetujuan === -1)
                        <span class="text-red-500">Ditolak</span>
                    @else    
                        <span class="text-gray-500">Belum Disetujui</span>
                    @endif
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

<div class="flex justify-center mt-6" id="paginationLinksPengajuanRuang">
    {{ $ruanganList->links('pagination::tailwind') }}
</div>
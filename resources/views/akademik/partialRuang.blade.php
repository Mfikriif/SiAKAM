<table class="w-11/12 mx-auto text-center mt-2 border-separate border-spacing-y-3 pb-8">
    <thead class="bg-gray-100 text-gray-700">
        <tr>
            <th class="px-2 py-4 border-b">No</th>
            <th class="px-2 py-4 border-b">Kode Ruangan</th>
            <th class="px-2 py-4 border-b">Keterangan</th>
            <th class="px-2 py-4 border-b">Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach($daftarRuangan as $index => $ruang)
            <tr class="even:bg-gray-50 hover:bg-gray-100 transition duration-200">
                <td class="px-4 py-2 border">{{ ($daftarRuangan->currentPage() -1) * $daftarRuangan->perPage() + $loop->iteration }}</td>
                <td class="px-4 py-2 border">{{ $ruang->kode_ruangan }}</td>
                <td class="px-4 py-2 border">{{ $ruang->keterangan }}</td>
                <td class="px-4 py-2 border">
                    <button onclick="confirmDelete('{{ route('ruang.destroy', $ruang->id) }}')"
                        class="mt-2 bg-transparent hover:bg-red-500 text-red-700 font-semibold hover:text-white py-2 px-4 border border-red-500 hover:border-transparent rounded transition duration-200">
                        Hapus
                    </button>
                <td>
            </tr>
        @endforeach
    </tbody>
</table>

<div class="flex justify-center mt-6" id="paginationLinks">
    {{ $daftarRuangan->onEachSide(1)->links('pagination::tailwind') }}
</div>
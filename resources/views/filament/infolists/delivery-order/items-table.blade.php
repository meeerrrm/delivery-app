<div class="rounded-lg overflow-hidden border overflow-x-scroll">
    <table class="w-full text-sm text-left rtl:text-right text-gray-800 dark:text-gray-400 overflow-x-scroll">
        <thead class="text-xs text-gray-700 uppercase bg-gray-100">
            <tr>
                <th scope="col" class="px-4 py-3">Nama Barang</th>
                <th scope="col" class="px-4 py-3">Jenis Barang</th>
                <th scope="col" class="px-4 py-3">Jumlah</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($getState() as $item)
                <tr class="bg-white border-t">
                    <td class="px-4 py-3">{{ $item['name'] ?? '-' }}</td>
                    <td class="px-4 py-3">{{ $item['type'] ?? '-' }}</td>
                    <td class="px-4 py-3">{{ $item['quantity'] ?? '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

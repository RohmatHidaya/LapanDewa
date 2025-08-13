<x-tables>
    <x-slot name="thead">
        <th>Tanggal</th>
        <th>Kategori</th>
        <th>Keterangan</th>
        <th>Jumlah(Rp)</th>
    </x-slot>
    @foreach ($laporanKeuangan as $item)
    <tr>
        <td>{{ $item->created_at->format('Y-m-d') }}</td>
        <td>{{ $item->kategori }}</td>
        <td>{{ $item->keterangan }}</td>
        <td>{{ number_format($item->jumlah) }}</td>
    </tr>
    @endforeach
</x-tables>
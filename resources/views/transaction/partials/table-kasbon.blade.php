                    <x-tables>
                        <x-slot name="thead">
                            <th>Nama</th>
                            <th>Invoice Number</th>
                            <th>Total(Rp)</th>
                            <th>Bayar(Rp)</th>
                            <th>Kasbon(Rp)</th>
                            <th>Tanggal Transaksi</th>
                        </x-slot>
                            @foreach ($kasbons as $kasbon)
                            <tr>
                                <td>{{ $kasbon->user->name }}</td>
                                <td>{{ $kasbon->invoice_number }}</td>
                                <td>{{ number_format($kasbon->total_price, 0, ',', '.') }}</td>
                                <td>{{ number_format($kasbon->paid_amount, 0, ',', '.') }}</td>
                                <td>{{ number_format($kasbon->due_amount, 0, ',', '.') }}</td>
                                <td>{{ $kasbon->created_at->format('Y-m-d H:i') }}</td>
                                <td>
                                    <a href="{{ route('transaksi.detail', $kasbon->id) }}">
                                        <button 
                                            class="bg-red-600 text-white text-xs px-2 py-1 rounded hover:bg-red-700 transition">
                                            Detail
                                        </button>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                    </x-tables>
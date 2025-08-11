                    <x-tables>
                        <x-slot name="thead">
                            <th>Nama</th>
                            <th>Invoice Number</th>
                            <th>Total(Rp)</th>
                            <th>Bayar(Rp)</th>
                            <th>Kembali(Rp)</th>
                            <th>Tanggal Transaksi</th>
                        </x-slot>
                            @foreach ($transactions as $transaction)
                            <tr>
                                <td>{{ $transaction->user->name }}</td>
                                <td>{{ $transaction->invoice_number }}</td>
                                <td>{{ number_format($transaction->total_price, 0, ',', '.') }}</td>
                                <td>{{ number_format($transaction->paid_amount, 0, ',', '.') }}</td>
                                <td>{{ number_format($transaction->change_amount, 0, ',', '.') }}</td>
                                <td>{{ $transaction->created_at->format('Y-m-d H:i') }}</td>
                                <td>
                                    <a href="{{ route('transaksi.detail', $transaction->id) }}">
                                        <button 
                                            class="bg-red-600 text-white text-xs px-2 py-1 rounded hover:bg-red-700 transition">
                                            Detail
                                        </button>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                    </x-tables>
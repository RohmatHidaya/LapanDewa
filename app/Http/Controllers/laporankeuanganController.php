<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\LaporanKeuangan;

class laporankeuanganController extends Controller
{
    public function index() 
    {
        $laporanKeuangan = LaporanKeuangan::orderBy('created_at', 'desc')->paginate(10);

        return view('laporan-keuangan', compact('laporanKeuangan'));
    }

    public function pemasukanHarian()
    {
        $tanggalHariIni = Carbon::today()->toDateString();

        $totalPendapatan = Transaction::whereDate('created_at', $tanggalHariIni)->sum('total_price');
        
        $hasLaporanKeuangan = LaporanKeuangan::whereDate('created_at', $tanggalHariIni)
        ->where('keterangan', 'penjualan barang dagang')
        ->first();

        if ($hasLaporanKeuangan) {
            $hasLaporanKeuangan->update(['jumlah' => $totalPendapatan]);

            return redirect()->back()->with('success', 'Laporan di Update');
        }

        LaporanKeuangan::create([
            'kategori' => 'pemasukan',
            'keterangan' => 'penjualan barang dagang',
            'jumlah' => $totalPendapatan,
        ]);

        return redirect()->back()->with('success', 'Laporan Berhasil ditambahkan');
    }

    public function store(Request $request, LaporanKeuangan $laporanKeuangan)
    {
        $laporanKeuangan->create($request->validate([
            'kategori' => 'required|in:pemasukan,pengeluaran',
            'keterangan' => 'required|max:255|string',
            'jumlah' => 'required|min:0|numeric',
        ]));

        return redirect()->back()->with('success', 'Laporan Berhasil dibuat');
    }
}

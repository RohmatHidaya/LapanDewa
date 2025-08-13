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
        $laporanKeuangan = LaporanKeuangan::orderBy('created_at', 'desc')->paginate(5);

        return view('laporan-keuangan', compact('laporanKeuangan'));
    }

    public function pemasukanHarian()
    {
        $tanggalHariIni = Carbon::today()->toDateString();

        $totalPendapatan = Transaction::whereDate('created_at', $tanggalHariIni)->sum('total_price');
        

        LaporanKeuangan::create([
            'kategori' => 'pemasukan',
            'keterangan' => 'penjualan barang dagang',
            'jumlah' => $totalPendapatan,
        ]);

        return redirect()->back()->with('success', 'Berhasil');
    }

    public function store()
    {

    }
}

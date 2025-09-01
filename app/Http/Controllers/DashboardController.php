<?php

namespace App\Http\Controllers;

use App\Models\LaporanKeuangan;
use App\Models\Transaction;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $harian = Transaction::whereDate('created_at', Carbon::today())->sum('total_price');

        $bulanan = Transaction::whereMonth('created_at', Carbon::now()->month)
        ->whereYear('created_at', Carbon::now()->year)
        ->sum('total_price');

        $tahunan = Transaction::whereYear('created_at', Carbon::now()->year)
        ->sum('total_price');

        $pendapatan = LaporanKeuangan::where('kategori', 'pemasukan')->sum('jumlah');

        $startLastMonth = Carbon::now()->subMonth()->startOfMonth();
        $endLastMonth   = Carbon::now()->subMonth()->endOfMonth();

        $pendapatanLastMonth = LaporanKeuangan::where('kategori', 'pemasukan')
            ->whereBetween('created_at', [$startLastMonth, $endLastMonth])
            ->sum('jumlah');

        $pengeluaranLastMonth = LaporanKeuangan::where('kategori', 'pengeluaran')
            ->whereBetween('created_at', [$startLastMonth, $endLastMonth])
            ->sum('jumlah');
            
        return view('dashboard', compact('harian', 'bulanan', 'tahunan', 'pendapatanLastMonth', 'pengeluaranLastMonth'));
    }
}

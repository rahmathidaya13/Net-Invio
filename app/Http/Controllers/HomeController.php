<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Pelanggan\PelangganModel;
use App\Models\StokBarang\StokBarangModel;
use App\Models\BarangMasuk\BarangMasukModel;
use App\Models\BarangKeluar\BarangKeluarModel;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        $month = Carbon::now()->month;
        $years = Carbon::now()->year;

        $stokAll = StokBarangModel::whereMonth("tanggal", $month)
            ->whereYear("tanggal", $years)
            ->sum("jumlah_barang");

        $brgMasukAll = BarangMasukModel::whereMonth("tanggal", $month)
            ->whereYear("tanggal", $years)
            ->sum("jumlah");

        $brgKeluarAll = BarangKeluarModel::whereMonth("tanggal", $month)
            ->whereYear("tanggal", $years)
            ->sum("jumlah");

        $pelangganAll = PelangganModel::whereMonth("tanggal", $month)
            ->whereYear("tanggal", $years)
            ->count();
        // dd($stokAll);
        return view('Home.index', compact('stokAll', 'brgMasukAll', 'brgKeluarAll', 'pelangganAll'));
    }
}

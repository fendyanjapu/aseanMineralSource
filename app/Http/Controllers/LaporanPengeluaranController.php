<?php

namespace App\Http\Controllers;

use App\Models\PembelianBarang;
use App\Models\Penggajihan;
use App\Models\PerbaikanUnit;
use PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LaporanPengeluaranController extends Controller
{
    public function index()
    {
        $bulan = date('m');
        $tahun = date('Y');
        return view('laporanPengeluaran.index', compact('bulan', 'tahun'));
    }

    public function print(Request $request)
    {
        $bulan = $request->bulan;
        $tahun = $request->tahun;

        $pembelianBarangs = PembelianBarang::where(DB::raw('MONTH(tanggal)'), '=', $bulan)
                                ->where(DB::raw('YEAR(tanggal)'), '=', $tahun)
                                ->get();

        $perbaikanUnits = PerbaikanUnit::where(DB::raw('MONTH(tanggal)'), '=', $bulan)
                                ->where(DB::raw('YEAR(tanggal)'), '=', $tahun)
                                 ->get();
        
        $penggajihans = Penggajihan::where(DB::raw('MONTH(tanggal)'), '=', $bulan)
                                ->where(DB::raw('YEAR(tanggal)'), '=', $tahun)
                                ->get();

        $namaBulan = $this->namaBulan($bulan);
        $pdf = PDF::loadview('laporanPengeluaran.laporan', compact(
            'pembelianBarangs',
            'perbaikanUnits',
            'penggajihans',
            'bulan', 
            'namaBulan', 
            'tahun'));
        return $pdf->stream();
    }

    private function namaBulan($bulan)
    {
        switch ($bulan) {
            case '01':
                $namaBulan = 'Januari';
                break;
            case '02':
                $namaBulan = 'Februari';
                break;
            case '03':
                $namaBulan = 'Maret';
                break;
            case '04':
                $namaBulan = 'April';
                break;
            case '05':
                $namaBulan = 'Mei';
                break;
            case '06':
                $namaBulan = 'Juni';
                break;
            case '07':
                $namaBulan = 'Juli';
                break;
            case '08':
                $namaBulan = 'Agustus';
                break;
            case '09':
                $namaBulan = 'September';
                break;
            case '10':
                $namaBulan = 'Oktober';
                break;
            case '11':
                $namaBulan = 'November';
                break;
            case '12':
                $namaBulan = 'Desember';
            default:
                $namaBulan = '';
        }

        return $namaBulan;
    }
}

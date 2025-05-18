<?php

namespace App\Http\Controllers;

use App\Models\OperasionalSite;
use App\Models\Pemasukan;
use App\Models\Pengapalan;
use App\Models\RotasiUnit;
use App\Models\Site;
use Illuminate\Http\Request;
use App\Models\PembelianBatu;
use App\Models\PengeluaranSite;
use App\Models\PembelianDariJetty;

class DashboardController extends Controller
{
    public function index()
    {
        $sites = Site::all();
        $pemasukan = Pemasukan::sum('jumlah');
        $pengeluaran = PengeluaranSite::sum('jumlah');
        $saldo = $pemasukan - $pengeluaran;

        $pembelianDariSiteRP = PembelianBatu::sum('total_penjualan');
        $pembelianDariJettyRP = PembelianDariJetty::sum('total_penjualan');
        $pembelianDariSiteTonase = PembelianBatu::sum('jumlah_tonase');
        $pembelianDariJettyTonase = PembelianDariJetty::sum('jumlah_tonase');
        $totalPembelianRP = $pembelianDariSiteRP + $pembelianDariJettyRP;
        $totalPembelianTonase = $pembelianDariSiteTonase + $pembelianDariJettyTonase;

        $pengapalanRP = Pengapalan::sum('total_harga_penjualan');
        $pengapalanTonase = Pengapalan::sum('tonase');

        return view("dashboard", compact(
            'sites',
            'pemasukan',
            'pengeluaran',
            'saldo',
            'totalPembelianRP',
            'totalPembelianTonase',
            'pengapalanRP',
            'pengapalanTonase',
        ));
    }

    public function produksiTonase(Request $request)
    {
        $query = RotasiUnit::where('site_id', '=', $request->site_id);
        $totalRotasi = $query->count();
        if ($totalRotasi > 0) {
            $jumlahTonase = $query->sum('berat_bersih');
        } else {
            $jumlahTonase = 0;
        }
        $data = [
            'jumlahTonase' => number_format($jumlahTonase,2),
        ];
        return json_encode($data);
    }

    public function hutangSite(Request $request)
    {
        $site_id = $request->site_id;
        $totalHutang = PengeluaranSite::where('site_id', '=', $site_id)->sum('jumlah');
        $pembayaranHutang = PembelianBatu::where('site_id', '=', $site_id)->sum('total_penjualan');
        $sisaHutang = $totalHutang - $pembayaranHutang;
        $data = [
            'totalHutang' => number_format($totalHutang),
            'pembayaranHutang' => number_format($pembayaranHutang),
            'sisaHutang' => number_format($sisaHutang),
        ];
        return json_encode($data);
    }

    public function pengeluaranSite(Request $request)
    {
        $site_id = $request->site_id;
        $pemasukanSite = PengeluaranSite::where('site_id', '=', $site_id)->sum('jumlah');
        $operasionalSite = OperasionalSite::where('site_id', '=', $site_id)->sum('biaya');
        $saldoSite = $pemasukanSite - $operasionalSite;
        $data = [
            'pemasukanSite' => number_format($pemasukanSite),
            'operasionalSite' => number_format($operasionalSite),
            'saldoSite' => number_format($saldoSite),
        ];
        return json_encode($data);
    }
}

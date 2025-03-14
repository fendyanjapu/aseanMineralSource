<?php

namespace App\Http\Controllers;

use App\Models\Pemasukan;
use App\Models\PembelianBatu;
use App\Models\Site;
use App\Models\HutangSite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\PembayaranPenjualan;

class PembayaranPenjualanController extends Controller
{
    public function index(Request $request)
    {
        $pembayaranPenjualans  = PembayaranPenjualan::orderBy('id', 'desc')->get();
        $sites = Site::all();
        return view('pembayaranPenjualan.index', compact('pembayaranPenjualans', 'sites'));
    }

    public function laporan(Request $request)
    {
        $dariTanggal = $request->dari_tanggal;
        $sampaiTanggal = $request->sampai_tanggal;
        $site_id = $request->site_id;
        if ($dariTanggal != null && $sampaiTanggal != null) {
            $query = PembayaranPenjualan::where('tanggal_transaksi', '>=', $dariTanggal)
                        ->where('tanggal_transaksi', '<=', $sampaiTanggal);
            
        } else {
            $query = PembayaranPenjualan::where('tanggal_transaksi', '<=', '2000-01-01');
        }

        if ($site_id != 'all') {
            $query->where('site_id', '=', $site_id);
        }
        $pembayaranPenjualans = $query->get();
        $sites = Site::all();
        return view('pembayaranPenjualan.laporan', compact(
            'pembayaranPenjualans', 
            'dariTanggal', 
            'sampaiTanggal', 
            'site_id',
            'sites'
        ));
    }
    public function create()
    {
        $query = PembayaranPenjualan::where(DB::raw('YEAR(created_at)'), '=', date('Y'));
        if ($query->count() == 0) {
            $lastId = 0;
        } else {
            $lastId = $query->orderBy('created_at', 'desc')->first()->id;
        }
        $nextId = $lastId + 1;
        $nextKode = str_pad($nextId,7,'0',STR_PAD_LEFT);
        $kode = 'A'.date('y').$nextKode;

        $sites = Site::all();
        $pengeluaranSites = Pemasukan::where('status_hutang', '=', '1')->get();
        
        return view('pembayaranPenjualan.create', compact(
            'sites', 
            'kode', 
            'pengeluaranSites',
        ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'kode_transaksi' => 'required',
            'site_id' => 'required',
            'data_pembelian_site' => 'required',
            'tanggal_pembelian' => 'required',
            'tonase' => 'required',
            'total_harga_pembelian' => 'required',
            'dana_operasional_site' => 'required',
            'tanggal_transfer_ke_site' => 'required',
            'jumlah_hutang_site' => 'required',
            'total_pembayaran_site' => 'required',
            'tanggal_transaksi' => 'required',
            'bukti_transaksi' => 'required|file|mimes:jpg,jpeg,png,pdf|max:4096',
            'sisa_hutang_site' => 'required',
        ];

        $gambar = $request->file('bukti_transaksi');
        $tujuan_upload = 'upload/pembayaranPenjualan';
        $nama_gbr = time()."_".$gambar->getClientOriginalName(); 

        $validatedData = $request->validate($rules);
        $validatedData['created_by'] = auth()->user()->name;
        $validatedData['user_id'] = auth()->user()->id;
        $validatedData['bukti_transaksi'] = $nama_gbr;
        $store = PembayaranPenjualan::create($validatedData);

        if ($store) {
            $gambar->move($tujuan_upload,$nama_gbr);

            $data = ['status_hutang' => '0'];
            $explode_kode = explode(',', $request->dana_operasional_site);
            foreach ($explode_kode as $kode) {
                Pemasukan::where('kode_transaksi', '=', $kode)->update($data);
            }

            $dibayar = str_replace(',', '', $request->jumlah_hutang_site);
            $data = [
                'site_id' => $request->site_id,
                'pembayaran_penjualan_id' => $store->id,
                'dibayar' => $dibayar,
            ];
            HutangSite::create($data);

            return redirect(route('pembayaranPenjualan.index'))->with('success','Data berhasil disimpan');
        }
        
    }

    /**
     * Display the specified resource.
     */
    public function show(PembayaranPenjualan $pembayaranPenjualan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PembayaranPenjualan $pembayaranPenjualan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PembayaranPenjualan $pembayaranPenjualan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PembayaranPenjualan $pembayaranPenjualan)
    {
        //
    }

    public function getTotalHutang(Request $request)
    {
        $site_id = $request->site_id;
        $hutang = HutangSite::where('site_id', '=', $site_id)->sum('hutang');
        $dibayar = HutangSite::where('site_id', '=', $site_id)->sum('dibayar');
        $totalHutang = $hutang - $dibayar;
        return json_encode($totalHutang);
    }

    public function getDataPembelian(Request $request)
    {
        $pembelianBatus = PembelianBatu::where('tgl_pembelian', '=', $request->tgl_pembelian)
                                    ->where('site_id', '=', $request->site_id)->get();
        echo "<option value=''></option>";
        foreach ($pembelianBatus as $pembelianBatu) {
            $cek = PembayaranPenjualan::where('data_pembelian_site', 'like', '%'.$pembelianBatu->kode_transaksi.'%')->count();
            if ($cek == 0) {
                echo "<option value='".$pembelianBatu->kode_transaksi."'>".$pembelianBatu->kode_transaksi.
            " | Nama Jetty: ".$pembelianBatu->nama_jetty."</option>";
            }
        }
    }

    public function getHarga(Request $request)
    {
        $pembelianBatu = PembelianBatu::where('kode_transaksi', '=', $request->kode_transaksi)->first();
        return json_encode($pembelianBatu);
    }

    public function cekPembelian(Request $request)
    {
        $kode_transaksi = $request->kode_transaksi;
        $cek = PembayaranPenjualan::where('data_pembelian_site', 'like', '%'.$kode_transaksi.'%')->count();
        if ($cek > 0) {
            $alert = 1;
        } else {
            $alert = 0;
        }
        return json_encode($alert);
    }

    public function getPengeluaranSite(Request $request)
    {
        $kode_transaksi = $request->kode_transaksi;
        $pengeluaranSite = Pemasukan::where('kode_transaksi', '=', $kode_transaksi)->first();
        return json_encode($pengeluaranSite);
    }
}

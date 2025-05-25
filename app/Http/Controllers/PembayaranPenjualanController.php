<?php

namespace App\Http\Controllers;

use App\Models\Site;
use App\Models\Pemasukan;
use App\Models\HutangSite;
use Illuminate\Http\Request;
use App\Models\PembelianBatu;
use Illuminate\Support\Facades\DB;
use App\Models\PembayaranPenjualan;
use Illuminate\Support\Facades\File;

class PembayaranPenjualanController extends Controller
{
    public function index(Request $request)
    {
        $this->authorize('viewAny', PembayaranPenjualan::class);

        $pembayaranPenjualans  = PembayaranPenjualan::orderBy('id', 'desc')->get();
        $sites = Site::all();
        return view('pembayaranPenjualan.index', compact('pembayaranPenjualans', 'sites'));
    }

    public function create()
    {
        $this->authorize('create', PembayaranPenjualan::class);

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
        
        return view('pembayaranPenjualan.create', compact(
            'sites', 
            'kode',
        ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create', PembayaranPenjualan::class);

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
            'sisa_hutang_site' => 'required',
        ];

        $validatedData = $request->validate($rules);
        $validatedData['created_by'] = auth()->user()->username;
        $validatedData['user_id'] = auth()->user()->id;

        $tujuan_upload = 'upload/pembayaranPenjualan';
        $bukti_transaksi = '';
        $jumlahFile = $request->jumlah_bukti_transaksi;
        if ($jumlahFile != '' && $jumlahFile != 0) {
            for ($i = 1; $i <= $jumlahFile; $i++) {
                $fileSize = $request->file('bukti_transaksi_'.$i)->getSize();
                if ($fileSize <= 4194304) { // 4 MB
                    $gambar = $request->file('bukti_transaksi_'.$i);
                    $nama_gbr = time().'-'.$gambar->getClientOriginalName();
                    $gambar->move($tujuan_upload,$nama_gbr);
                    $bukti_transaksi .= $nama_gbr.',';
                }
            }
        }
        $validatedData['bukti_transaksi'] = $bukti_transaksi;

        $store = PembayaranPenjualan::create($validatedData);

        if ($store) {

            $data = ['status_hutang' => '0'];
            $explode_kode = explode(',', $request->dana_operasional_site);
            foreach ($explode_kode as $kode) {
                Pemasukan::where('kode_transaksi', '=', $kode)->update($data);
            }

            $total_harga_pembelian = str_replace(',', '', $request->total_harga_pembelian);
            $jumlah_hutang_site = str_replace(',', '', $request->jumlah_hutang_site);
            if ($total_harga_pembelian > $jumlah_hutang_site) {
                $dibayar =  $jumlah_hutang_site;
            } else {
                $dibayar = $total_harga_pembelian;
            }
            
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
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PembayaranPenjualan $pembayaranPenjualan)
    {
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PembayaranPenjualan $pembayaranPenjualan)
    {
        $this->authorize('delete', $pembayaranPenjualan);

        $dana_operasional_site = $pembayaranPenjualan->dana_operasional_site;
        $pembayaran_penjualan_id = $pembayaranPenjualan->id;

        $query = PembayaranPenjualan::findOrFail($pembayaranPenjualan->id);
        $files  = $query->bukti_transaksi;

        $delete = PembayaranPenjualan::destroy($pembayaranPenjualan->id);

        $file = explode(",",$files);
        $jumlahFile = count($file) - 1;
        for ($i = 0; $i < $jumlahFile; $i++) {
            $file_path = public_path('upload/pembayaranPenjualan/'.$file[$i]);
            if (File::exists($file_path)) {
                File::delete($file_path);
            }
        }

        if ($delete) {
            $data = ['status_hutang' => '1'];
            $explode_kode = explode(',', $dana_operasional_site);
            foreach ($explode_kode as $kode) {
                Pemasukan::where('kode_transaksi', '=', $kode)->update($data);
            }
            HutangSite::where('pembayaran_penjualan_id', '=', $pembayaran_penjualan_id)->delete();
        }

        return redirect(route('pembayaranPenjualan.index'))->with('success','Data berhasil dihapus');
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

    public function getTotalHutang(Request $request)
    {
        $site_id = $request->site_id;
        $hutang = HutangSite::where('site_id', '=', $site_id)->sum('hutang');
        $dibayar = HutangSite::where('site_id', '=', $site_id)->sum('dibayar');
        $totalHutang = $hutang - $dibayar;

        $pembelianBatus = PembelianBatu::where('site_id', '=', $site_id)->get();
        $tgl_pembelian = '';
        foreach ($pembelianBatus as $pembelianBatu) {
            $tgl_pembelian .= ','.$pembelianBatu->tgl_pembelian;
        }
        $data = [
            'tgl_pembelian' => $tgl_pembelian,
            'total_hutang' => $totalHutang,
        ];

        return json_encode($data);
    }

    public function getDataPembelian(Request $request)
    {
        $tanggal = $request->tgl_pembelian;
        $tanggal = date_format(date_create($tanggal), 'Y-m-d');
        $pembelianBatus = PembelianBatu::where('tgl_pembelian', '=', $tanggal)
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

    public function getOperasional(Request $request)
    {
        $query = Pemasukan::where('status_hutang', '=', '1')
                            ->where('site_id', '=', $request->site_id)->get();
        echo "<option></option>";
        foreach ($query as $key) {
            echo "<option value='".$key->kode_transaksi."'>".$key->kode_transaksi."</option>";
        }
    }
}

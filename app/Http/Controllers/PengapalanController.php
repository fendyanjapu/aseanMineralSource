<?php

namespace App\Http\Controllers;

use App\Models\PembelianBatu;
use App\Models\PembelianDariJetty;
use App\Models\Site;
use App\Models\Pengapalan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PengapalanController extends Controller
{
    private $rules = [
        'kode_transaksi'=> 'required|max:255',
        'tanggal_pengapalan'=> 'required|date',
        'nama_tongkang'=> 'required|max:255',
        'tanggal_pembelian' => 'required',
        'site_id'=> 'required',
        'harga'=> 'required',
        'tonase'=> 'required|max:255',
        'harga_di_site'=> 'required|max:255',
        'pembelian_dari_jetty_id'=> 'required',
        'biaya_dokumen'=> 'required|max:255',
        'biaya_jetty'=> 'required|max:255',
        'biaya_operasional_dll'=> 'required|max:255',
    ];
    public function index()
    {
        $this->authorize('viewAny', Pengapalan::class);

        $pengapalans = Pengapalan::all();
        return view('pengapalan.index', compact('pengapalans'));
        // return view('pengapalan.date');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Pengapalan::class);

        $query = Pengapalan::where(DB::raw('YEAR(created_at)'), '=', date('Y'));
        if ($query->count() == 0) {
            $lastId = 0;
        } else {
            $lastId = $query->orderBy('created_at', 'desc')->first()->id;
        }
        $nextId = $lastId + 1;
        $nextKode = str_pad($nextId,5,'0',STR_PAD_LEFT);
        $kode = 'L'.date('y').$nextKode;

        $sites = Site::all();
        $pembelianDariJetty = PembelianDariJetty::where('status_pengapalan', '=', '0')->get();
        return view('pengapalan.create', compact('kode', 'sites', 'pembelianDariJetty'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create', Pengapalan::class);

        $tujuan_upload = 'upload/pengapalan';
        $bukti_biaya_dokumen = $request->file('bukti_biaya_dokumen');
        $nama_bukti_biaya_dokumen = time()."_".$bukti_biaya_dokumen->getClientOriginalName(); 

        $bukti_biaya_jetty = $request->file('bukti_biaya_jetty');
        $nama_bukti_biaya_jetty = time()."_".$bukti_biaya_jetty->getClientOriginalName();
        
        $bukti_biaya_operasional_dll = $request->file('bukti_biaya_operasional_dll');
        $nama_bukti_biaya_operasional_dll = time()."_".$bukti_biaya_operasional_dll->getClientOriginalName();

        $validatedData = $request->validate($this->rules);
        $validatedData['id_pembelian_batu'] = $request->id_pembelian_batu;
        $validatedData['harga_jual_per_tonase'] = $request->harga_jual_per_tonase;
        $validatedData['total_harga_penjualan'] = $request->total_harga_penjualan;
        $validatedData['laba_bersih'] = $request->laba_bersih;
        $validatedData['created_by'] = auth()->user()->username;
        $validatedData['user_id'] = auth()->user()->id;
        $validatedData['bukti_biaya_dokumen'] = $nama_bukti_biaya_dokumen;
        $validatedData['bukti_biaya_jetty'] = $nama_bukti_biaya_jetty;
        $validatedData['bukti_biaya_operasional_dll'] = $nama_bukti_biaya_operasional_dll;

        $store = Pengapalan::create($validatedData);

        if ($store) {
            // ubah status pembelian dari site
            $ids = explode(',',$request->id_pembelian_batu);
            $data['status_pengapalan'] = '1';
            foreach ($ids as $id) {
                PembelianBatu::findOrFail($id)->update($data);
            }
            $bukti_biaya_dokumen->move($tujuan_upload,$nama_bukti_biaya_dokumen);
            $bukti_biaya_jetty->move($tujuan_upload,$nama_bukti_biaya_jetty);
            $bukti_biaya_operasional_dll->move($tujuan_upload,$nama_bukti_biaya_operasional_dll);
        }

        return redirect()->route('pengapalan.index')->with('success','Data berhasil ditambah');
    }

    public function show(Pengapalan $pengapalan)
    {
        return view('pengapalan.show', compact('pengapalan'));
    }

    public function edit(Pengapalan $pengapalan)
    {
        $this->authorize('update', $pengapalan);

        $sites = Site::all();
        $pembelianDariJetty = PembelianDariJetty::all();
        return view('pengapalan.edit', compact('pengapalan', 'sites', 'pembelianDariJetty'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pengapalan $pengapalan)
    {
        $this->authorize('update', $pengapalan);

        $validatedData = $request->validate($this->rules);
        $validatedData['harga_jual_per_tonase'] = $request->harga_jual_per_tonase;
        $validatedData['total_harga_penjualan'] = $request->total_harga_penjualan;
        $validatedData['laba_bersih'] = $request->laba_bersih;
        $validatedData['updated_by'] = auth()->user()->username;
        Pengapalan::findOrFail($pengapalan->id)->update($validatedData);

        return redirect(route('pengapalan.index'))->with('success','Data berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pengapalan $pengapalan)
    {
        $this->authorize('delete', $pengapalan);

        $id_pembelian_batu = $pengapalan->id_pembelian_batu;

        $delete = Pengapalan::destroy($pengapalan->id);

        if ($delete) {
            // ubah status pembelian dari site
            $ids = explode(',',$id_pembelian_batu);
            $data['status_pengapalan'] = '0';
            foreach ($ids as $id) {
                PembelianBatu::findOrFail($id)->update($data);
            }
        }

        return redirect(route('pengapalan.index'))->with('success','Data berhasil dihapus');
    }
    public function laporan(Request $request)
    {
        $dariTanggal = $request->dari_tanggal;
        $sampaiTanggal = $request->sampai_tanggal;
        $site_id = $request->site_id;
        if ($dariTanggal != null && $sampaiTanggal != null) {
            $query = Pengapalan::where('tanggal_pengapalan', '>=', $dariTanggal)
                        ->where('tanggal_pengapalan', '<=', $sampaiTanggal);
            
        } else {
            $query = Pengapalan::where('tanggal_pengapalan', '<=', '2000-01-01');
        }

        if ($site_id != 'all') {
            $query->where('site_id', '=', $site_id);
        }
        $pengapalans = $query->get();
        $sites = Site::all();
        return view('pengapalan.laporan', compact(
            'pengapalans', 
            'dariTanggal', 
            'sampaiTanggal', 
            'site_id',
            'sites'
        ));
    }

    public function penjualanBatu(Request $request)
    {
        $dariTanggal = $request->dari_tanggal;
        $sampaiTanggal = $request->sampai_tanggal;
        if ($dariTanggal != null && $sampaiTanggal != null) {
            $query = Pengapalan::where('tanggal_pengapalan', '>=', $dariTanggal)
                        ->where('tanggal_pengapalan', '<=', $sampaiTanggal);
            
        } else {
            $query = Pengapalan::where('tanggal_pengapalan', '<=', '2000-01-01');
        }

        $pengapalans = $query->get();
        return view('pengapalan.laporanPenjualanBatu', compact(
            'pengapalans', 
            'dariTanggal', 
            'sampaiTanggal', 
        ));
    }

    public function getSite(Request $request)
    {
        $site_id = $request->site_id;
        $pembelianBatus = PembelianBatu::where('site_id', '=', $site_id)
                                        ->where('status_pengapalan', '=', '0')
                                        ->get();
        $tgl_pembelian = '';
        foreach ($pembelianBatus as $pembelianBatu) {
            $tgl_pembelian .= ','.$pembelianBatu->tgl_pembelian;
        }
        $data = [
            'tgl_pembelian' => $tgl_pembelian,
        ];
        return json_encode($data);
    }

    public function getDataPembelianbatu(Request $request)
    {
        $site_id = $request->site_id;
        $tanggal = $request->tgl_pembelian;
        $tanggal = date_format(date_create($tanggal), 'Y-m-d');
        $pembelianBatus = PembelianBatu::where('site_id', '=', $site_id)
                                        ->where('status_pengapalan', '=', '0')
                                        ->where('tgl_pembelian', '=', $tanggal)
                                        ->get();
        $jumlah_tonase = 0;
        $total_penjualan = 0;
        // $id_pembelian_batu = [];
        foreach ($pembelianBatus as $pembelianBatu) {
            $jumlah_tonase += str_replace(',', '', $pembelianBatu->jumlah_tonase);
            $total_penjualan += str_replace(',', '', $pembelianBatu->total_penjualan);
            $harga = str_replace(',', '', $pembelianBatu->harga);
            $id_pembelian_batu = $pembelianBatu->id;
        }
        $data = [
            'jumlah_tonase' => $jumlah_tonase,
            'total_penjualan' => $total_penjualan,
            'harga' => $harga,
            'id_pembelian_batu' => $id_pembelian_batu,
            'tanggal' => $tanggal,
        ];
        return json_encode($data);
    }

}

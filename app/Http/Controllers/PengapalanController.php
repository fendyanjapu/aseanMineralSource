<?php

namespace App\Http\Controllers;

use App\Models\PembelianBatu;
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
        'site_id'=> 'required',
        'tonase'=> 'required|max:255',
        'harga_di_site'=> 'required|max:255',
    ];
    public function index()
    {
        $pengapalans = Pengapalan::all();
        return view('pengapalan.index', compact('pengapalans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
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
        return view('pengapalan.create', compact('sites', 'kode'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate($this->rules);
        $validatedData['harga_jual_per_tonase'] = $request->harga_jual_per_tonase;
        $validatedData['document_dll'] = $request->document_dll;
        $validatedData['total_harga_penjualan'] = $request->total_harga_penjualan;
        $validatedData['laba_bersih'] = $request->laba_bersih;
        $validatedData['created_by'] = auth()->user()->name;
        $validatedData['user_id'] = auth()->user()->id;

        Pengapalan::create($validatedData);

        // ubah status pembelian dari site
        $ids = explode(',',$request->id_pembelian_batu);
        $data['status_pengapalan'] = '1';
        foreach ($ids as $id) {
            PembelianBatu::findOrFail($id)->update($data);
        }

        return redirect()->route('pengapalan.index')->with('success','Data berhasil ditambah');
    }

    /**
     * Display the specified resource.
     */
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
    public function edit(Pengapalan $pengapalan)
    {
        $this->authorize('update', $pengapalan);

        $sites = Site::all();

        return view('pengapalan.edit', compact('pengapalan', 'sites'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pengapalan $pengapalan)
    {
        $this->authorize('update', $pengapalan);

        $validatedData = $request->validate($this->rules);
        $validatedData['harga_jual_per_tonase'] = $request->harga_jual_per_tonase;
        $validatedData['document_dll'] = $request->document_dll;
        $validatedData['total_harga_penjualan'] = $request->total_harga_penjualan;
        $validatedData['laba_bersih'] = $request->laba_bersih;
        $validatedData['updated_by'] = auth()->user()->name;
        Pengapalan::findOrFail($pengapalan->id)->update($validatedData);

        return redirect(route('pengapalan.index'))->with('success','Data berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pengapalan $pengapalan)
    {
        $this->authorize('delete', $pengapalan);

        Pengapalan::destroy($pengapalan->id);

        return redirect(route('pengapalan.index'))->with('success','Data berhasil dihapus');
    }

    public function getSite(Request $request)
    {
        $site_id = $request->site_id;
        $pembelianBatus = PembelianBatu::where('site_id', '=', $site_id)->where('status_pengapalan', '=', '0')->get();
        $jumlah_tonase = 0;
        $total_penjualan = 0;
        $id_pembelian_batu = [];
        foreach ($pembelianBatus as $pembelianBatu) {
            $jumlah_tonase += str_replace(',', '', $pembelianBatu->jumlah_tonase);
            $total_penjualan += str_replace(',', '', $pembelianBatu->total_penjualan);
            $id_pembelian_batu[] = $pembelianBatu->id;
        }
        $data = [
            'jumlah_tonase' => $jumlah_tonase,
            'total_penjualan' => $total_penjualan,
            'id_pembelian_batu' => $id_pembelian_batu,
        ];
        return json_encode($data);
    }

}

<?php

namespace App\Http\Controllers;

use App\Models\Site;
use App\Models\RotasiUnit;
use Illuminate\Http\Request;
use App\Models\PembelianBatu;
use Illuminate\Support\Facades\DB;

class PembelianBatuController extends Controller
{
    private $rules = [
        'kode_transaksi'=> 'required|max:255',
        'site_id'=> 'required',
        'tgl_pembelian'=> 'required|date',
        'tgl_rotasi'=> 'required',
        'jumlah_tonase'=> 'required',
        'harga'=> 'required|max:255',
        'total_penjualan'=> 'required|max:255',
    ];
    public function index()
    {
        $this->authorize('viewAny', PembelianBatu::class);

        $pembelianBatus = PembelianBatu::all();
        return view('pembelianBatu.index', compact('pembelianBatus'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', PembelianBatu::class);

        $query = PembelianBatu::where(DB::raw('YEAR(created_at)'), '=', date('Y'));
        if ($query->count() == 0) {
            $lastId = 0;
        } else {
            $lastId = $query->orderBy('created_at', 'desc')->first()->id;
        }
        $nextId = $lastId + 1;
        $nextKode = str_pad($nextId,5,'0',STR_PAD_LEFT);
        $kode = 'P'.date('y').$nextKode;

        $sites = Site::all();
        return view('pembelianBatu.create', compact('sites', 'kode'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create', PembelianBatu::class);
        
        $validatedData = $request->validate($this->rules);
        $validatedData['created_by'] = auth()->user()->username;
        $validatedData['user_id'] = auth()->user()->id;
        $validatedData['status_pengapalan'] = "0";

        PembelianBatu::create($validatedData);

        return redirect()->route('pembelianBatu.index')->with('success','Data berhasil ditambah');
    }

    public function edit(PembelianBatu $pembelianBatu)
    {
        $this->authorize('update', $pembelianBatu);

        $sites = Site::all();

        return view('pembelianBatu.edit', compact('pembelianBatu', 'sites'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PembelianBatu $pembelianBatu)
    {
        $this->authorize('update', $pembelianBatu);

        $validatedData = $request->validate($this->rules);
        $validatedData['updated_by'] = auth()->user()->username;
        PembelianBatu::findOrFail($pembelianBatu->id)->update($validatedData);

        return redirect(route('pembelianBatu.index'))->with('success','Data berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PembelianBatu $pembelianBatu)
    {
        $this->authorize('delete', $pembelianBatu);

        PembelianBatu::destroy($pembelianBatu->id);

        return redirect(route('pembelianBatu.index'))->with('success','Data berhasil dihapus');
    }
    public function laporan(Request $request)
    {
        $dariTanggal = $request->dari_tanggal;
        $sampaiTanggal = $request->sampai_tanggal;
        $site_id = $request->site_id;
        if ($dariTanggal != null && $sampaiTanggal != null) {
            $query = PembelianBatu::where('tgl_pembelian', '>=', $dariTanggal)
                        ->where('tgl_pembelian', '<=', $sampaiTanggal);
            
        } else {
            $query = PembelianBatu::where('tgl_pembelian', '<=', '2000-01-01');
        }

        if ($site_id != 'all') {
            $query->where('site_id', '=', $site_id);
        }
        $pembelianBatus = $query->get();
        $sites = Site::all();
        return view('pembelianBatu.laporan', compact(
            'pembelianBatus', 
            'dariTanggal', 
            'sampaiTanggal', 
            'site_id',
            'sites'
        ));
    }

    public function penjualanSite(Request $request)
    {
        $dariTanggal = $request->dari_tanggal;
        $sampaiTanggal = $request->sampai_tanggal;
        $site_id = $request->site_id;
        if ($dariTanggal != null && $sampaiTanggal != null) {
            $query = PembelianBatu::where('tgl_pembelian', '>=', $dariTanggal)
                        ->where('tgl_pembelian', '<=', $sampaiTanggal);
            
        } else {
            $query = PembelianBatu::where('tgl_pembelian', '<=', '2000-01-01');
        }
        if (auth()->user()->level_id == 1) {
            if ($site_id != 'all') {
                $query->where('site_id', '=', $site_id);
            }
        } else {
            $query->where('site_id', '=', auth()->user()->site_id);
        }
        $pembelianBatus = $query->get();
        $sites = Site::all();
        return view('pembelianBatu.laporanPenjualanSite', compact(
            'pembelianBatus', 
            'dariTanggal', 
            'sampaiTanggal',
            'site_id',
            'sites'
        ));
    }

    public function getTotalRotasi(Request $request)
    {
        $tanggal = $request->tanggal;
        $tanggal = date_format(date_create($tanggal), 'Y-m-d');
        $query = RotasiUnit::where('tanggal', '=', $tanggal)->where('site_id', '=', $request->site_id);
        $totalRotasi = $query->count();
        if ($totalRotasi > 0) {
            $jumlahTonase = $query->sum('berat_bersih');
        } else {
            $jumlahTonase = 0;
        }
        $data = [
            'totalRotasi' => $totalRotasi,
            'jumlahTonase' => number_format($jumlahTonase,2),
        ];
        return json_encode($data);
    }

    public function cekTglRotasi(Request $request)
    {
        $tgl_rotasi = $request->tanggal;
        $cek = PembelianBatu::where('tgl_rotasi', 'like', '%'.$tgl_rotasi.'%')->count();
        if ($cek > 0) {
            $alert = 1;
        } else {
            $alert = 0;
        }
        return json_encode($alert);
    }
}

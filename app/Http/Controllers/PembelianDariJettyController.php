<?php

namespace App\Http\Controllers;

use App\Models\RotasiUnit;
use Illuminate\Http\Request;
use App\Models\PembelianDariJetty;
use Illuminate\Support\Facades\DB;

class PembelianDariJettyController extends Controller
{
    private $rules = [
        'kode_transaksi'=> 'required|max:255',
        'nama_jetty'=> 'required|max:255',
        'tgl_pembelian'=> 'required|date',
        'tgl_rotasi'=> 'required',
        'jumlah_tonase'=> 'required',
        'harga'=> 'required|max:255',
        'total_penjualan'=> 'required|max:255',
    ];
    public function index()
    {
        $this->authorize('viewAny', PembelianDariJetty::class);

        $pembelianDariJettys = PembelianDariJetty::all();
        return view('pembelianDariJetty.index', compact('pembelianDariJettys'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', PembelianDariJetty::class);

        $query = PembelianDariJetty::where(DB::raw('YEAR(created_at)'), '=', date('Y'));
        if ($query->count() == 0) {
            $lastId = 0;
        } else {
            $lastId = $query->orderBy('created_at', 'desc')->first()->id;
        }
        $nextId = $lastId + 1;
        $nextKode = str_pad($nextId,5,'0',STR_PAD_LEFT);
        $kode = 'PJ'.date('y').$nextKode;

        return view('pembelianDariJetty.create', compact('kode'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create', PembelianDariJetty::class);
        
        $validatedData = $request->validate($this->rules);
        $validatedData['created_by'] = auth()->user()->username;
        $validatedData['user_id'] = auth()->user()->id;
        $validatedData['status_pengapalan'] = "0";

        PembelianDariJetty::create($validatedData);

        return redirect()->route('pembelianDariJetty.index')->with('success','Data berhasil ditambah');
    }

    public function edit(PembelianDariJetty $pembelianDariJetty)
    {
        $this->authorize('update', $pembelianDariJetty);

        return view('pembelianDariJetty.edit', compact('pembelianDariJetty'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PembelianDariJetty $pembelianDariJetty)
    {
        $this->authorize('update', $pembelianDariJetty);

        $validatedData = $request->validate($this->rules);
        $validatedData['updated_by'] = auth()->user()->username;
        PembelianDariJetty::findOrFail($pembelianDariJetty->id)->update($validatedData);

        return redirect(route('pembelianDariJetty.index'))->with('success','Data berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PembelianDariJetty $pembelianDariJetty)
    {
        $this->authorize('delete', $pembelianDariJetty);

        PembelianDariJetty::destroy($pembelianDariJetty->id);

        return redirect(route('pembelianDariJetty.index'))->with('success','Data berhasil dihapus');
    }

    public function getTotalRotasi(Request $request)
    {
        $tanggal = $request->tanggal;
        $tanggal = date_format(date_create($tanggal), 'Y-m-d');
        $query = RotasiUnit::where('tanggal', '=', $tanggal);
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
        $cek = PembelianDariJetty::where('tgl_rotasi', 'like', '%'.$tgl_rotasi.'%')->count();
        if ($cek > 0) {
            $alert = 1;
        } else {
            $alert = 0;
        }
        return json_encode($alert);
    }

    public function getRotasiJetty()
    {
        $rotasiUnits = RotasiUnit::all();
        $tanggal = '';
        foreach ($rotasiUnits as $rotasiUnit) {
            $tanggal .= ','.$rotasiUnit->tanggal;
        }
        $data = [
            'tanggal' => $tanggal,
        ];
        return json_encode($data);
    }
}

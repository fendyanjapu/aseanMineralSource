<?php

namespace App\Http\Controllers;

use App\Models\HutangSite;
use App\Models\Site;
use App\Models\PengeluaranSite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class PengeluaranSiteController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', PengeluaranSite::class);

        $pengeluaranSites  = PengeluaranSite::all();
        
        return view('pengeluaranSite.index', compact('pengeluaranSites'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', PengeluaranSite::class);

        $query = PengeluaranSite::where(DB::raw('YEAR(created_at)'), '=', date('Y'));
        if ($query->count() == 0) {
            $lastId = 0;
        } else {
            $lastId = $query->orderBy('created_at', 'desc')->first()->id;
        }
        $nextId = $lastId + 1;
        $nextKode = str_pad($nextId,5,'0',STR_PAD_LEFT);
        $kode = 'PS'.date('y').$nextKode;

        $sites = Site::all();
        return view('pengeluaranSite.create', compact('sites', 'kode'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('viewAny', PengeluaranSite::class);
        
        $rules = [
            'kode_transaksi'=> 'required|max:255',
            'site_id'=> 'required',
            'jumlah'=> 'required|max:255',
            'sumber_dana'=> 'required|max:255',
            'metode_transaksi'=> 'required|max:255',
            'tanggal'=> 'required|date',
            'bukti_transaksi' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ];

        $gambar = $request->file('bukti_transaksi');
        $tujuan_upload = 'upload/pengeluaranSite';
        $nama_gbr = time()."_".$gambar->getClientOriginalName(); 

        $validatedData = $request->validate($rules);
        $validatedData['created_by'] = auth()->user()->username;
        $validatedData['user_id'] = auth()->user()->id;
        $validatedData['status_hutang'] = '1';
        $validatedData['bukti_transaksi'] = $nama_gbr;

        $store = PengeluaranSite::create($validatedData);

        $hutang = str_replace(',', '', $request->jumlah);
        $data = [
            'site_id' => $request->site_id,
            'pengeluaran_site_id' => $store->id,
            'hutang' => $hutang
        ];
        HutangSite::create($data);

        if ($store) { $gambar->move($tujuan_upload,$nama_gbr); }
        return redirect()->route('pengeluaranSite.index')->with('success','Data berhasil ditambah');
    }

    /**
     * Display the specified resource.
     */
    public function show(PengeluaranSite $pengeluaranSite)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PengeluaranSite $pengeluaranSite)
    {
        $this->authorize('update', $pengeluaranSite);

        $sites = Site::all();
        return view('pengeluaranSite.edit', compact('pengeluaranSite','sites'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PengeluaranSite $pengeluaranSite)
    {
        $this->authorize('update', $pengeluaranSite);
        
        $rules = [
            'kode_transaksi'=> 'required|max:255',
            'site_id'=> 'required',
            'jumlah'=> 'required|max:255',
            'sumber_dana'=> 'required|max:255',
            'metode_transaksi'=> 'required|max:255',
            'tanggal'=> 'required|date',
        ];

        $validatedData = $request->validate($rules);
        $validatedData['updated_by'] = auth()->user()->username;
        PengeluaranSite::findOrFail($pengeluaranSite->id)->update($validatedData);

        $hutang = str_replace(',', '', $request->jumlah);
        $data = [
            'site_id' => $request->site_id,
            'hutang' => $hutang
        ];
        HutangSite::where('pengeluaran_site_id', '=', $pengeluaranSite->id)->update($data);

        return redirect(route('pengeluaranSite.index'))->with('success','Data berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PengeluaranSite $pengeluaranSite)
    {
        $this->authorize('delete', $pengeluaranSite);

        $query = PengeluaranSite::findOrFail($pengeluaranSite->id);
        $file  = $query->bukti_transaksi;
        HutangSite::where('pengeluaran_site_id', '=', $pengeluaranSite->id)->delete();
        PengeluaranSite::destroy($pengeluaranSite->id);
        $file_path = public_path('upload/pengeluaranSite/'.$file);
        if (File::exists($file_path)) {
            File::delete($file_path);
        }

        return redirect(route('pengeluaranSite.index'))->with('success','Data berhasil dihapus');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\HutangSite;
use App\Models\Site;
use App\Models\Pemasukan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class PemasukanController extends Controller
{
    public function index()
    {
        $pemasukans  = Pemasukan::all();
        
        return view('pemasukan.index', compact('pemasukans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $query = Pemasukan::where(DB::raw('YEAR(created_at)'), '=', date('Y'));
        if ($query->count() == 0) {
            $lastId = 0;
        } else {
            $lastId = $query->orderBy('created_at', 'desc')->first()->id;
        }
        $nextId = $lastId + 1;
        $nextKode = str_pad($nextId,5,'0',STR_PAD_LEFT);
        $kode = 'PS'.date('y').$nextKode;

        $sites = Site::all();
        return view('pemasukan.create', compact('sites', 'kode'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'kode_transaksi'=> 'required|max:255',
            'site_id'=> 'required',
            'jumlah'=> 'required|max:255',
            'sumber_dana'=> 'required|max:255',
            'metode_transaksi'=> 'required|max:255',
            'tanggal'=> 'required|date',
            'bukti_transaksi' => 'required|file|mimes:jpg,jpeg,png,pdf|max:4096',
        ];

        $gambar = $request->file('bukti_transaksi');
        $tujuan_upload = 'upload/pemasukan';
        $nama_gbr = time()."_".$gambar->getClientOriginalName(); 

        $validatedData = $request->validate($rules);
        $validatedData['created_by'] = auth()->user()->name;
        $validatedData['user_id'] = auth()->user()->id;
        $validatedData['bukti_transaksi'] = $nama_gbr;

        $store = Pemasukan::create($validatedData);

        $hutang = str_replace(',', '', $request->jumlah);
        $data = [
            'site_id' => $request->site_id,
            'pemasukan_id' => $store->id,
            'hutang' => $hutang
        ];
        HutangSite::create($data);

        if ($store) { $gambar->move($tujuan_upload,$nama_gbr); }
        return redirect()->route('pemasukan.index')->with('success','Data berhasil ditambah');
    }

    /**
     * Display the specified resource.
     */
    public function show(Pemasukan $pemasukan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pemasukan $pemasukan)
    {
        $this->authorize('update', $pemasukan);

        $sites = Site::all();
        return view('pemasukan.edit', compact('pemasukan','sites'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pemasukan $pemasukan)
    {
        $this->authorize('update', $pemasukan);
        
        $rules = [
            'kode_transaksi'=> 'required|max:255',
            'site_id'=> 'required',
            'jumlah'=> 'required|max:255',
            'sumber_dana'=> 'required|max:255',
            'metode_transaksi'=> 'required|max:255',
            'tanggal'=> 'required|date',
        ];

        $validatedData = $request->validate($rules);
        $validatedData['updated_by'] = auth()->user()->name;
        Pemasukan::findOrFail($pemasukan->id)->update($validatedData);

        $hutang = str_replace(',', '', $request->jumlah);
        $data = [
            'site_id' => $request->site_id,
            'hutang' => $hutang
        ];
        HutangSite::where('pemasukan_id', '=', $pemasukan->id)->update($data);

        return redirect(route('pemasukan.index'))->with('success','Data berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pemasukan $pemasukan)
    {
        $this->authorize('delete', $pemasukan);

        $query = Pemasukan::findOrFail($pemasukan->id);
        $file  = $query->bukti_transaksi;

        Pemasukan::destroy($pemasukan->id);
        $file_path = public_path('upload/pemasukan/'.$file);
        if (File::exists($file_path)) {
            File::delete($file_path);
        }

        return redirect(route('pemasukan.index'))->with('success','Data berhasil dihapus');
    }
}

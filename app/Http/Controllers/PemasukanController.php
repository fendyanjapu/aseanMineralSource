<?php

namespace App\Http\Controllers;

use App\Models\Pemasukan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class PemasukanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny', Pemasukan::class);

        $pemasukans  = Pemasukan::all();
        
        return view('pemasukan.index', compact('pemasukans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Pemasukan::class);

        $query = Pemasukan::where(DB::raw('YEAR(created_at)'), '=', date('Y'));
        if ($query->count() == 0) {
            $lastId = 0;
        } else {
            $lastId = $query->orderBy('created_at', 'desc')->first()->id;
        }
        $nextId = $lastId + 1;
        $nextKode = str_pad($nextId,5,'0',STR_PAD_LEFT);
        $kode = 'PA'.date('y').$nextKode;

        return view('pemasukan.create', compact('kode'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('viewAny', Pemasukan::class);
        
        $rules = [
            'kode_transaksi'=> 'required|max:255',
            'jumlah'=> 'required|max:255',
            'sumber_dana'=> 'required|max:255',
            'metode_transaksi'=> 'required|max:255',
            'keterangan'=> 'required',
            'tanggal'=> 'required|date',
            'bukti_transaksi' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ];

        $gambar = $request->file('bukti_transaksi');
        $tujuan_upload = 'upload/pemasukan';
        $nama_gbr = time()."_".$gambar->getClientOriginalName(); 

        $jumlah = str_replace(',', '', $request->jumlah);
        $validatedData = $request->validate($rules);
        $validatedData['jumlah'] = $jumlah;
        $validatedData['created_by'] = auth()->user()->username;
        $validatedData['user_id'] = auth()->user()->id;
        $validatedData['bukti_transaksi'] = $nama_gbr;

        $store = Pemasukan::create($validatedData);

        if ($store) { $gambar->move($tujuan_upload,$nama_gbr); }
        return redirect()->route('pemasukan.index')->with('success','Data berhasil ditambah');
    }

    /**
     * Display the specified resource.
     */
    public function laporan(Request $request)
    {
        $dariTanggal = $request->dari_tanggal;
        $sampaiTanggal = $request->sampai_tanggal;
        if ($dariTanggal != null && $sampaiTanggal != null) {
            $query = Pemasukan::where('tanggal', '>=', $dariTanggal)
                        ->where('tanggal', '<=', $sampaiTanggal);
            
        } else {
            $query = Pemasukan::where('tanggal', '<=', '2000-01-01');
        }
        
        $pemasukans = $query->get();
        return view('pemasukan.laporan', compact(
            'pemasukans', 
            'dariTanggal', 
            'sampaiTanggal',
        ));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pemasukan $pemasukan)
    {
        $this->authorize('update', $pemasukan);

        return view('pemasukan.edit', compact('pemasukan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pemasukan $pemasukan)
    {
        $this->authorize('update', $pemasukan);
        
        $rules = [
            'kode_transaksi'=> 'required|max:255',
            'jumlah'=> 'required|max:255',
            'sumber_dana'=> 'required|max:255',
            'metode_transaksi'=> 'required|max:255',
            'keterangan'=> 'required',
            'tanggal'=> 'required|date',
        ];

        $jumlah = str_replace(',', '', $request->jumlah);
        $validatedData = $request->validate($rules);
        $validatedData['jumlah'] = $jumlah;
        $validatedData['updated_by'] = auth()->user()->username;
        Pemasukan::findOrFail($pemasukan->id)->update($validatedData);

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

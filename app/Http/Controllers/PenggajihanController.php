<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use App\Models\Penggajihan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class PenggajihanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $penggajihans  = Penggajihan::all();
        
        return view('penggajihan.index', compact('penggajihans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $karyawans = Karyawan::orderBy('nama')->get();
        return view('penggajihan.create', compact('karyawans'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'kode_transaksi'=> 'required|max:255',
            'karyawan_id'=> 'required',
            'periode_gajih'=> 'required|max:255',
            'total'=> 'required',
            'tanggal'=> 'required|date',
            'bukti_transaksi' => 'required|file|mimes:jpg,jpeg,png,pdf|max:4096',
        ];

        $gambar = $request->file('bukti_transaksi');
        $tujuan_upload = 'upload/penggajihan';
        $nama_gbr = time()."_".$gambar->getClientOriginalName(); 

        $validatedData = $request->validate($rules);
        // $validatedData = $request->all();
        $validatedData['created_by'] = auth()->user()->name;
        $validatedData['bukti_transaksi'] = $nama_gbr;

        $store = Penggajihan::create($validatedData);

        if ($store) { $gambar->move($tujuan_upload,$nama_gbr); }
        return redirect()->route('penggajihan.index')->with('success','Data berhasil ditambah');
    }

    /**
     * Display the specified resource.
     */
    public function show(Penggajihan $penggajihan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Penggajihan $penggajihan)
    {
        $this->authorize('update', $penggajihan);

        $karyawans = Karyawan::orderBy('nama')->get();

        return view('penggajihan.edit', compact('penggajihan', 'karyawans'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Penggajihan $penggajihan)
    {
        $this->authorize('update', $penggajihan);
        
        $rules = [
            'kode_transaksi'=> 'required|max:255',
            'karyawan_id'=> 'required',
            'periode_gajih'=> 'required|max:255',
            'total'=> 'required',
            'tanggal'=> 'required|date',
        ];

        $validatedData = $request->validate($rules);
        $validatedData['updated_by'] = auth()->user()->name;
        Penggajihan::findOrFail($penggajihan->id)->update($validatedData);

        return redirect(route('penggajihan.index'))->with('success','Data berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Penggajihan $penggajihan)
    {
        $this->authorize('delete', $penggajihan);

        $query = Penggajihan::findOrFail($penggajihan->id);
        $file  = $query->bukti_transaksi;

        penggajihan::destroy($penggajihan->id);
        $file_path = public_path('upload/penggajihan/'.$file);
        if (File::exists($file_path)) {
            File::delete($file_path);
        }

        return redirect(route('penggajihan.index'))->with('success','Data berhasil dihapus');
    }
}

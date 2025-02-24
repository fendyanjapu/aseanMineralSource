<?php

namespace App\Http\Controllers;

use App\Models\Pemasukan;
use Illuminate\Http\Request;
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
        return view('pemasukan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'kode_transaksi'=> 'required|max:255',
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
        $validatedData['bukti_transaksi'] = $nama_gbr;

        $store = Pemasukan::create($validatedData);

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
            'tanggal'=> 'required|date',
        ];

        $validatedData = $request->validate($rules);
        $validatedData['updated_by'] = auth()->user()->name;
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

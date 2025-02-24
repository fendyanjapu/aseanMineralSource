<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;
use App\Models\PembelianBarang;
use Illuminate\Support\Facades\File;

class PembelianBarangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pembelianBarangs  = PembelianBarang::all();
        
        return view('pembelianBarang.index', compact('pembelianBarangs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $barangs = Barang::orderBy('nama')->get();
        return view('pembelianBarang.create', compact('barangs'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'kode_transaksi'=> 'required|max:255',
            'barang_id'=> 'required',
            'jumlah'=> 'required',
            'harga_satuan'=> 'required',
            'total_harga'=> 'required',
            'tanggal'=> 'required|date',
            'bukti_transaksi' => 'required|file|mimes:jpg,jpeg,png,pdf|max:4096',
        ];

        $gambar = $request->file('bukti_transaksi');
        $tujuan_upload = 'upload/pembelianBarang';
        $nama_gbr = time()."_".$gambar->getClientOriginalName(); 

        $validatedData = $request->validate($rules);
        $validatedData['created_by'] = auth()->user()->name;
        $validatedData['bukti_transaksi'] = $nama_gbr;

        $store = PembelianBarang::create($validatedData);

        if ($store) { $gambar->move($tujuan_upload,$nama_gbr); }
        return redirect()->route('pembelianBarang.index')->with('success','Data berhasil ditambah');
    }

    /**
     * Display the specified resource.
     */
    public function show(PembelianBarang $pembelianBarang)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PembelianBarang $pembelianBarang)
    {
        $this->authorize('update', $pembelianBarang);

        $barangs = Barang::orderBy('nama')->get();

        return view('pembelianBarang.edit', compact('pembelianBarang', 'barangs'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PembelianBarang $pembelianBarang)
    {
        $this->authorize('update', $pembelianBarang);
        
        $rules = [
            'kode_transaksi'=> 'required|max:255',
            'barang_id'=> 'required',
            'jumlah'=> 'required',
            'harga_satuan'=> 'required',
            'total_harga'=> 'required',
            'tanggal'=> 'required|date',
        ];

        $validatedData = $request->validate($rules);
        $validatedData['updated_by'] = auth()->user()->name;
        PembelianBarang::findOrFail($pembelianBarang->id)->update($validatedData);

        return redirect(route('pembelianBarang.index'))->with('success','Data berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PembelianBarang $pembelianBarang)
    {
        $this->authorize('delete', $pembelianBarang);

        $query = PembelianBarang::findOrFail($pembelianBarang->id);
        $file  = $query->bukti_transaksi;

        pembelianBarang::destroy($pembelianBarang->id);
        $file_path = public_path('upload/pembelianBarang/'.$file);
        if (File::exists($file_path)) {
            File::delete($file_path);
        }

        return redirect(route('pembelianBarang.index'))->with('success','Data berhasil dihapus');
    }
}

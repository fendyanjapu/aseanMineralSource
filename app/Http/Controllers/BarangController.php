<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Barang;
use Illuminate\Http\Request;

class BarangController extends Controller
{
    private $rules = [
        'kode'=> 'required|max:255',
        'nama'=> 'required|max:255',
        'spesifikasi'=> 'required|max:255',
        'merk'=> 'required|max:255',
        'kisaran_harga'=> 'required|max:255',
    ];
    public function index()
    {
        $this->authorize('viewAny', User::class);
        
        $barangs  = Barang::all();
        
        return view('barang.index', compact('barangs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', User::class);

        $lastId = Barang::latest()->first()?->id;
        if ($lastId == null) { $lastId = 0; }
        $nextId = $lastId + 1;
        $nextKode = str_pad($nextId,5,'0',STR_PAD_LEFT);
        $kode = 'B'.$nextKode;
        return view('barang.create', compact('kode'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create', User::class);

        $validatedData = $request->validate($this->rules);
        $validatedData['created_by'] = auth()->user()->username;
        $validatedData['user_id'] = auth()->user()->id;
        Barang::create($validatedData);
        return redirect()->route('barang.index')->with('success','Data berhasil ditambah');
    }

    /**
     * Display the specified resource.
     */
    public function show(Barang $barang)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Barang $barang)
    {
        $this->authorize('update', $barang);

        return view('barang.edit', compact('barang'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Barang $barang)
    {
        $this->authorize('update', $barang);

        $validatedData = $request->validate($this->rules);
        $validatedData['updated_by'] = auth()->user()->username;
        Barang::findOrFail($barang->id)->update($validatedData);

        return redirect(route('barang.index'))->with('success','Data berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Barang $barang)
    {
        $this->authorize('delete', $barang);

        Barang::destroy($barang->id);
        return redirect(route('barang.index'))->with('success','Data berhasil dihapus');
    }
}

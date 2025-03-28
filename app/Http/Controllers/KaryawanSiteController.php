<?php

namespace App\Http\Controllers;

use App\Models\KaryawanSite;
use Illuminate\Http\Request;

class KaryawanSiteController extends Controller
{
    private $rules = [
        'nip'=> 'required|max:255',
        'nik'=> 'required|max:255',
        'nama'=> 'required|max:255',
        'tempat_lahir'=> 'required|max:255',
        'tanggal_lahir'=> 'required|date',
        'jenis_kelamin'=> 'required',
        'alamat'=> 'required',
        'tanggal_masuk'=> 'required|date',
        'jabatan'=> 'required|max:255',
        'status'=> 'required|max:255',
    ];
    public function index()
    {
        $this->authorize('viewAny', arguments: KaryawanSite::class);
        
        $karyawans  = KaryawanSite::all();
        
        return view('karyawanSite.index', compact('karyawans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', KaryawanSite::class);

        return view('karyawanSite.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create', KaryawanSite::class);

        $validatedData = $request->validate($this->rules);
        $validatedData['created_by'] = auth()->user()->username;
        KaryawanSite::create($validatedData);
        return redirect()->route('karyawanSite.index')->with('success','Data berhasil ditambah');
    }

    public function edit(KaryawanSite $karyawanSite)
    {
        $this->authorize('update', $karyawanSite);

        return view('karyawanSite.edit', compact('karyawanSite'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, KaryawanSite $karyawanSite)
    {
        $this->authorize('update', $karyawanSite);

        $validatedData = $request->validate($this->rules);
        $validatedData['updated_by'] = auth()->user()->username;
        KaryawanSite::findOrFail($karyawanSite->id)->update($validatedData);

        return redirect(route('karyawanSite.index'))->with('success','Data berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(KaryawanSite $karyawanSite)
    {
        $this->authorize('delete', $karyawanSite);

        KaryawanSite::destroy($karyawanSite->id);
        return redirect(route('karyawanSite.index'))->with('success','Data berhasil dihapus');
    }
}

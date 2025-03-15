<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Karyawan;
use Illuminate\Http\Request;

class KaryawanController extends Controller
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
        'level'=> 'required|max:255',
        'status'=> 'required|max:255',
    ];
    public function index()
    {
        $this->authorize('viewAny', User::class);
        
        $karyawans  = Karyawan::all();
        
        return view('karyawan.index', compact('karyawans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', User::class);

        return view('karyawan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create', User::class);

        $validatedData = $request->validate($this->rules);
        $validatedData['created_by'] = auth()->user()->username;
        Karyawan::create($validatedData);
        return redirect()->route('karyawan.index')->with('success','Data berhasil ditambah');
    }

    /**
     * Display the specified resource.
     */
    public function show(Karyawan $karyawan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Karyawan $karyawan)
    {
        $this->authorize('update', $karyawan);

        return view('karyawan.edit', compact('karyawan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Karyawan $karyawan)
    {
        $this->authorize('update', $karyawan);

        $validatedData = $request->validate($this->rules);
        $validatedData['updated_by'] = auth()->user()->username;
        Karyawan::findOrFail($karyawan->id)->update($validatedData);

        return redirect(route('karyawan.index'))->with('success','Data berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Karyawan $karyawan)
    {
        $this->authorize('delete', $karyawan);

        Karyawan::destroy($karyawan->id);
        return redirect(route('karyawan.index'))->with('success','Data berhasil dihapus');
    }
}

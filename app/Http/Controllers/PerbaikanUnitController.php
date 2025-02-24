<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use Illuminate\Http\Request;
use App\Models\PerbaikanUnit;
use Illuminate\Support\Facades\File;

class PerbaikanUnitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $perbaikanUnits  = PerbaikanUnit::all();
        
        return view('perbaikanUnit.index', compact('perbaikanUnits'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $units = Unit::all();
        return view('perbaikanUnit.create', compact('units'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'kode_transaksi'=> 'required|max:255',
            'unit_id'=> 'required',
            'detail_perbaikan'=> 'required',
            'total_harga'=> 'required',
            'tanggal'=> 'required|date',
            'bukti_transaksi' => 'required|file|mimes:jpg,jpeg,png,pdf|max:4096',
        ];

        $gambar = $request->file('bukti_transaksi');
        $tujuan_upload = 'upload/perbaikanUnit';
        $nama_gbr = time()."_".$gambar->getClientOriginalName(); 

        $validatedData = $request->validate($rules);
        $validatedData['created_by'] = auth()->user()->name;
        $validatedData['bukti_transaksi'] = $nama_gbr;

        $store = PerbaikanUnit::create($validatedData);

        if ($store) { $gambar->move($tujuan_upload,$nama_gbr); }
        return redirect()->route('perbaikanUnit.index')->with('success','Data berhasil ditambah');
    }

    /**
     * Display the specified resource.
     */
    public function show(PerbaikanUnit $perbaikanUnit)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PerbaikanUnit $perbaikanUnit)
    {
        $this->authorize('update', $perbaikanUnit);

        $units = Unit::all();

        return view('perbaikanUnit.edit', compact('perbaikanUnit', 'units'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PerbaikanUnit $perbaikanUnit)
    {
        $this->authorize('update', $perbaikanUnit);
        
        $rules = [
            'kode_transaksi'=> 'required|max:255',
            'unit_id'=> 'required',
            'detail_perbaikan'=> 'required',
            'total_harga'=> 'required',
            'tanggal'=> 'required|date',
        ];

        $validatedData = $request->validate($rules);
        $validatedData['updated_by'] = auth()->user()->name;
        PerbaikanUnit::findOrFail($perbaikanUnit->id)->update($validatedData);

        return redirect(route('perbaikanUnit.index'))->with('success','Data berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PerbaikanUnit $perbaikanUnit)
    {
        $this->authorize('delete', $perbaikanUnit);

        $query = perbaikanUnit::findOrFail($perbaikanUnit->id);
        $file  = $query->bukti_transaksi;

        PerbaikanUnit::destroy($perbaikanUnit->id);
        $file_path = public_path('upload/perbaikanUnit/'.$file);
        if (File::exists($file_path)) {
            File::delete($file_path);
        }

        return redirect(route('perbaikanUnit.index'))->with('success','Data berhasil dihapus');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use App\Models\User;
use Illuminate\Http\Request;

class UnitController extends Controller
{
    private $rules = [
        'kode'=> 'required|max:255',
        'no_identitas_unit'=> 'required|max:255',
        'spesifikasi'=> 'required|max:255',
        'merk'=> 'required|max:255',
        'tanggal_pembelian'=> 'required|date',
        'harga'=> 'required|max:255',
    ];
    public function index()
    {
        $this->authorize('viewAny', User::class);
        
        $units  = Unit::all();
       
        return view('unit.index', compact('units'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', User::class);

        $lastId = Unit::latest()->first()?->id;
        if ($lastId == null) { $lastId = 0; }
        $nextId = $lastId + 1;
        $nextKode = str_pad($nextId,5,'0',STR_PAD_LEFT);
        $kode = 'K'.$nextKode;
        return view('unit.create', compact('kode'));
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
        Unit::create($validatedData);
        return redirect()->route('unit.index')->with('success','Data berhasil ditambah');
    }

    /**
     * Display the specified resource.
     */
    public function show(Unit $unit)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Unit $unit)
    {
        $this->authorize('update', $unit);

        return view('unit.edit', compact('unit'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Unit $unit)
    {
        $this->authorize('update', $unit);

        $validatedData = $request->validate($this->rules);
        $validatedData['updated_by'] = auth()->user()->username;
        Unit::findOrFail($unit->id)->update($validatedData);

        return redirect(route('unit.index'))->with('success','Data berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Unit $unit)
    {
        $this->authorize('delete', $unit);

        Unit::destroy($unit->id);
        return redirect(route('unit.index'))->with('success','Data berhasil dihapus');
    }
}

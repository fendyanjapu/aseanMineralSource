<?php

namespace App\Http\Controllers;

use App\Models\Site;
use App\Models\RotasiUnit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RotasiUnitController extends Controller
{
    private $rules = [
        'kode_transaksi'=> 'required|max:255',
        'no_nota'=> 'required|max:255',
        'tanggal'=> 'required|date',
        'nopol'=> 'required|max:255',
        'supir'=> 'required|max:255',
        'jarak'=> 'required|max:255',
        'berat_kendaraan'=> 'required|max:255',
        'berat_kotor'=> 'required|max:255',
        'berat_bersih'=> 'required|max:255',
        'premi_tonase'=> 'required|max:255',
        'premi_per_rite'=> 'required|max:255',
        'total_biaya'=> 'required|max:255',
        'total_rotasi'=> 'required|max:255',
        'site_id'=> 'required',
    ];
    public function index()
    {
        $rotasiUnits = RotasiUnit::orderBy('tanggal', 'desc')->get();
        return view('rotasiUnit.index', compact('rotasiUnits'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $query = RotasiUnit::where(DB::raw('YEAR(created_at)'), '=', date('Y'));
        if ($query->count() == 0) {
            $lastId = 0;
        } else {
            $lastId = $query->orderBy('created_at', 'desc')->first()->id;
        }
        $nextId = $lastId + 1;
        $nextKode = str_pad($nextId,5,'0',STR_PAD_LEFT);
        $kode = 'R'.date('y').$nextKode;

        if (auth()->user()->site_id != null) {
            $sites = Site::where('id', '=', auth()->user()->site_id)->get();
        } else {
            $sites = Site::all();
        }
        return view('rotasiUnit.create', compact('sites', 'kode'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate($this->rules);
        $validatedData['created_by'] = auth()->user()->name;
        $validatedData['user_id'] = auth()->user()->id;

        RotasiUnit::create($validatedData);

        return redirect()->route('rotasiUnit.create')->with('success','Data berhasil ditambah');
    }

    /**
     * Display the specified resource.
     */
    public function show(RotasiUnit $rotasiUnit)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RotasiUnit $rotasiUnit)
    {
        $this->authorize('update', $rotasiUnit);

        $sites = Site::all();

        return view('rotasiUnit.edit', compact('rotasiUnit', 'sites'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, RotasiUnit $rotasiUnit)
    {
        $this->authorize('update', $rotasiUnit);

        $validatedData = $request->validate($this->rules);
        $validatedData['updated_by'] = auth()->user()->name;
        RotasiUnit::findOrFail($rotasiUnit->id)->update($validatedData);

        return redirect(route('rotasiUnit.index'))->with('success','Data berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RotasiUnit $rotasiUnit)
    {
        $this->authorize('delete', $rotasiUnit);

        RotasiUnit::destroy($rotasiUnit->id);

        return redirect(route('rotasiUnit.index'))->with('success','Data berhasil dihapus');
    }

    public function getTotalRotasi(Request $request)
    {
        $totalRotasi = RotasiUnit::where('tanggal', '=', $request->tanggal)->where('nopol', '=', $request->nopol)->count();
        $totalRotasi += 1;
        return json_encode($totalRotasi);
    }
}

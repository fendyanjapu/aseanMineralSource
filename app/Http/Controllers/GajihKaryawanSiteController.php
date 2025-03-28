<?php

namespace App\Http\Controllers;

use App\Models\KaryawanSite;
use Illuminate\Http\Request;
use App\Models\GajihKaryawanSite;
use Illuminate\Support\Facades\DB;

class GajihKaryawanSiteController extends Controller
{
    private $rules = [
        'kode_transaksi'=> 'required|max:255',
        'karyawan_site_id'=> 'required',
        'gajih_periode'=> 'required|max:255',
        'total'=> 'required|max:255',
    ];
    public function index()
    {
        $this->authorize('viewAny', GajihKaryawanSite::class);
        
        $gajihKaryawanSites  = GajihKaryawanSite::all();
        
        return view('gajihKaryawanSite.index', compact('gajihKaryawanSites'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', GajihKaryawanSite::class);

        $query = GajihKaryawanSite::where(DB::raw('YEAR(created_at)'), '=', date('Y'));
        if ($query->count() == 0) {
            $lastId = 0;
        } else {
            $lastId = $query->orderBy('created_at', 'desc')->first()->id;
        }
        $nextId = $lastId + 1;
        $nextKode = str_pad($nextId,5,'0',STR_PAD_LEFT);
        $kode = 'G'.date('y').$nextKode;

        $karyawanSites = KaryawanSite::all();

        return view('gajihKaryawanSite.create', compact('kode', 'karyawanSites'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create', GajihKaryawanSite::class);

        $validatedData = $request->validate($this->rules);
        $validatedData['created_by'] = auth()->user()->username;
        $validatedData['user_id'] = auth()->user()->id;
        GajihKaryawanSite::create($validatedData);
        return redirect()->route('gajihKaryawanSite.index')->with('success','Data berhasil ditambah');
    }

    public function edit(GajihKaryawanSite $gajihKaryawanSite)
    {
        $this->authorize('update', $gajihKaryawanSite);

        $karyawanSites = KaryawanSite::all();

        return view('gajihKaryawanSite.edit', compact('gajihKaryawanSite', 'karyawanSites'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, GajihKaryawanSite $gajihKaryawanSite)
    {
        $this->authorize('update', $gajihKaryawanSite);

        $validatedData = $request->validate($this->rules);
        $validatedData['updated_by'] = auth()->user()->username;
        GajihKaryawanSite::findOrFail($gajihKaryawanSite->id)->update($validatedData);

        return redirect(route('gajihKaryawanSite.index'))->with('success','Data berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(GajihKaryawanSite $gajihKaryawanSite)
    {
        $this->authorize('delete', $gajihKaryawanSite);

        GajihKaryawanSite::destroy($gajihKaryawanSite->id);
        return redirect(route('gajihKaryawanSite.index'))->with('success','Data berhasil dihapus');
    }
}

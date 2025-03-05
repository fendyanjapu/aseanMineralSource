<?php

namespace App\Http\Controllers;

use App\Models\PembelianBatu;
use App\Models\Site;
use App\Models\Pengapalan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PengapalanController extends Controller
{
    private $rules = [
        'kode_transaksi'=> 'required|max:255',
        'tanggal_pengapalan'=> 'required|date',
        'nama_tongkang'=> 'required|max:255',
        'site_id'=> 'required',
        'pembelian_batu_id'=> 'required',
    ];
    public function index()
    {
        $pengapalans = Pengapalan::all();
        return view('pengapalan.index', compact('pengapalans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $query = Pengapalan::where(DB::raw('YEAR(created_at)'), '=', date('Y'));
        if ($query->count() == 0) {
            $lastId = 0;
        } else {
            $lastId = $query->orderBy('created_at', 'desc')->first()->id;
        }
        $nextId = $lastId + 1;
        $nextKode = str_pad($nextId,5,'0',STR_PAD_LEFT);
        $kode = 'L'.date('y').$nextKode;

        $sites = Site::all();
        return view('pengapalan.create', compact('sites', 'kode'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate($this->rules);
        $validatedData['created_by'] = auth()->user()->name;
        $validatedData['user_id'] = auth()->user()->id;

        Pengapalan::create($validatedData);

        return redirect()->route('pengapalan.index')->with('success','Data berhasil ditambah');
    }

    /**
     * Display the specified resource.
     */
    public function show(Pengapalan $pengapalan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pengapalan $pengapalan)
    {
        $this->authorize('update', $pengapalan);

        $sites = Site::all();

        return view('pengapalan.edit', compact('pengapalan', 'sites'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pengapalan $pengapalan)
    {
        $this->authorize('update', $pengapalan);

        $validatedData = $request->validate($this->rules);
        $validatedData['updated_by'] = auth()->user()->name;
        Pengapalan::findOrFail($pengapalan->id)->update($validatedData);

        return redirect(route('pengapalan.index'))->with('success','Data berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pengapalan $pengapalan)
    {
        $this->authorize('delete', $pengapalan);

        Pengapalan::destroy($pengapalan->id);

        return redirect(route('pengapalan.index'))->with('success','Data berhasil dihapus');
    }

    public function getPembelianBatu($site_id)
    {
        $pembelianBatu = PembelianBatu::where('site_id', '=', $site_id)->get();
        return response()->json($pembelianBatu);
    }
}

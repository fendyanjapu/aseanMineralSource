<?php

namespace App\Http\Controllers;

use App\Models\Site;
use App\Models\RotasiUnit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class RotasiUnitController extends Controller
{
    private $rules = [
        'kode_transaksi'=> 'required|max:255',
        'tanggal'=> 'required|date',
        'total_tonase'=> 'required',
        'jumlah_rotasi'=> 'required',
        'site_id'=> 'required',
    ];
    public function index()
    {
        $rotasiUnits = RotasiUnit::orderBy('tanggal', 'desc')->orderBy('created_at', 'desc')->get();
        return view('rotasiUnit.index', compact('rotasiUnits'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', RotasiUnit::class);

        $query = RotasiUnit::where(DB::raw('YEAR(created_at)'), '=', date('Y'));
        if ($query->count() == 0) {
            $lastId = 0;
        } else {
            $lastId = $query->orderBy('created_at', 'desc')->first()->id;
        }
        $nextId = $lastId + 1;
        $nextKode = str_pad($nextId,5,'0',STR_PAD_LEFT);
        $kode = 'R'.date('y').$nextKode;

        if (Session::get('site_id') != null) {
            $sites = Site::where('id', '=', Session::get('site_id'))->get();
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
        $this->authorize('create', RotasiUnit::class);
        
        $total_tonase = str_replace(',', '', $request->total_tonase);
        $jumlah_rotasi = str_replace(',', '', $request->jumlah_rotasi);

        $validatedData = $request->validate($this->rules);
        $validatedData['total_tonase'] = $total_tonase;
        $validatedData['jumlah_rotasi'] = $jumlah_rotasi;
        $validatedData['created_by'] = auth()->user()->username;
        $validatedData['user_id'] = auth()->user()->id;

        RotasiUnit::create($validatedData);

        return redirect()->route('rotasiUnit.index')->with('success','Data berhasil ditambah');
    }

    /**
     * Display the specified resource.
     */
    public function laporan(Request $request)
    {
        $dariTanggal = $request->dari_tanggal;
        $sampaiTanggal = $request->sampai_tanggal;
        $site_id = $request->site_id;
        if ($dariTanggal != null && $sampaiTanggal != null) {
            $query = RotasiUnit::where('tanggal', '>=', $dariTanggal)
                        ->where('tanggal', '<=', $sampaiTanggal);
            
        } else {
            $query = RotasiUnit::where('tanggal', '<=', '2000-01-01');
        }
        if (auth()->user()->level_id == 1) {
            if ($site_id != 'all') {
                $query->where('site_id', '=', $site_id);
            }
        } else {
            $query->where('site_id', '=', Session::get('site_id'));
        }
        $rotasiUnits = $query->get();
        $sites = Site::all();
        return view('rotasiUnit.laporan', compact(
            'rotasiUnits', 
            'dariTanggal', 
            'sampaiTanggal',
            'site_id',
            'sites'
        ));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RotasiUnit $rotasiUnit)
    {
        $this->authorize('update', $rotasiUnit);

        if (Session::get('site_id') != null) {
            $sites = Site::where('id', '=', Session::get('site_id'))->get();
        } else {
            $sites = Site::all();
        }

        return view('rotasiUnit.edit', compact('rotasiUnit', 'sites'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, RotasiUnit $rotasiUnit)
    {
        $this->authorize('update', $rotasiUnit);

        $total_tonase = str_replace(',', '', $request->total_tonase);
        $jumlah_rotasi = str_replace(',', '', $request->jumlah_rotasi);

        $validatedData = $request->validate($this->rules);
        $validatedData['total_tonase'] = $total_tonase;
        $validatedData['jumlah_rotasi'] = $jumlah_rotasi;
        $validatedData['updated_by'] = auth()->user()->username;
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

    public function getRotasi(Request $request)
    {
        $site_id = $request->site_id;
        $rotasiUnits = RotasiUnit::where('site_id', '=', $site_id)->get();
        $tanggal = '';
        foreach ($rotasiUnits as $rotasiUnit) {
            $tanggal .= ','.$rotasiUnit->tanggal;
        }
        $data = [
            'tanggal' => $tanggal,
        ];
        return json_encode($data);
    }
}

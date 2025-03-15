<?php

namespace App\Http\Controllers;

use App\Models\Site;
use Illuminate\Http\Request;
use App\Models\OperasionalSite;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class OperasionalSiteController extends Controller
{
    public function index()
    {
        $operasionalSites  = OperasionalSite::all();
        
        return view('operasionalSite.index', compact('operasionalSites'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', OperasionalSite::class);
        
        $query = OperasionalSite::where(DB::raw('YEAR(created_at)'), '=', date('Y'));
        if ($query->count() == 0) {
            $lastId = 0;
        } else {
            $lastId = $query->orderBy('created_at', 'desc')->first()->id;
        }
        $nextId = $lastId + 1;
        $nextKode = str_pad($nextId,5,'0',STR_PAD_LEFT);
        $kode = 'K1'.date('y').$nextKode;

        if (auth()->user()->site_id != null) {
            $sites = Site::where('id', '=', auth()->user()->site_id)->get();
        } else {
            $sites = Site::all();
        }
        
        return view('operasionalSite.create', compact('sites', 'kode'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create', OperasionalSite::class);

        $rules = [
            'kode_transaksi'=> 'required|max:255',
            'tanggal'=> 'required|date',
            'nama_transaksi'=> 'required|max:255',
            'biaya'=> 'required|max:255',
            'bukti_transaksi' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'site_id'=> 'required',
            
        ];

        $gambar = $request->file('bukti_transaksi');
        $tujuan_upload = 'upload/operasionalSite';
        $nama_gbr = time()."_".$gambar->getClientOriginalName(); 

        $validatedData = $request->validate($rules);
        $validatedData['created_by'] = auth()->user()->username;
        $validatedData['user_id'] = auth()->user()->id;
        $validatedData['bukti_transaksi'] = $nama_gbr;

        $store = OperasionalSite::create($validatedData);

        if ($store) { $gambar->move($tujuan_upload,$nama_gbr); }
        return redirect()->route('operasionalSite.index')->with('success','Data berhasil ditambah');
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
            $query = OperasionalSite::where('tanggal', '>=', $dariTanggal)
                        ->where('tanggal', '<=', $sampaiTanggal);
            
        } else {
            $query = OperasionalSite::where('tanggal', '<=', '2000-01-01');
        }
        if (auth()->user()->level_id == 1) {
            if ($site_id != 'all') {
                $query->where('site_id', '=', $site_id);
            }
        } else {
            $query->where('site_id', '=', auth()->user()->site_id);
        }
        $operasionalSites = $query->get();
        $sites = Site::all();
        return view('operasionalSite.laporan', compact(
            'operasionalSites', 
            'dariTanggal', 
            'sampaiTanggal',
            'site_id',
            'sites'
        ));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(OperasionalSite $operasionalSite)
    {
        $this->authorize('delete', $operasionalSite);

        if (auth()->user()->site_id != null) {
            $sites = Site::where('id', '=', auth()->user()->site_id)->get();
        } else {
            $sites = Site::all();
        }

        return view('operasionalSite.edit', compact('operasionalSite', 'sites'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, OperasionalSite $operasionalSite)
    {
        $this->authorize('delete', $operasionalSite);

        $rules = [
            'kode_transaksi'=> 'required|max:255',
            'tanggal'=> 'required|date',
            'nama_transaksi'=> 'required|max:255',
            'biaya'=> 'required|max:255',
            'site_id'=> 'required',
        ];

        $validatedData = $request->validate($rules);
        $validatedData['updated_by'] = auth()->user()->username;
        OperasionalSite::findOrFail($operasionalSite->id)->update($validatedData);

        return redirect(route('operasionalSite.index'))->with('success','Data berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(OperasionalSite $operasionalSite)
    {
        $this->authorize('delete', $operasionalSite);
        
        $query = OperasionalSite::findOrFail($operasionalSite->id);
        $file  = $query->bukti_transaksi;

        OperasionalSite::destroy($operasionalSite->id);
        $file_path = public_path('upload/operasionalSite/'.$file);
        if (File::exists($file_path)) {
            File::delete($file_path);
        }

        return redirect(route('operasionalSite.index'))->with('success','Data berhasil dihapus');
    }
}

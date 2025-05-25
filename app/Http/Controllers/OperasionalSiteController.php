<?php

namespace App\Http\Controllers;

use App\Models\Site;
use Illuminate\Http\Request;
use App\Models\OperasionalSite;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;

class OperasionalSiteController extends Controller
{
    public function index()
    {
        if (Session::get('level') == 4) {
            $operasionalSites  = OperasionalSite::where('site_id', '=', Session::get('site_id'))->get();
        } else {
            $operasionalSites  = OperasionalSite::all();
        }
        
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
            'site_id'=> 'required',
            
        ];

        $biaya = str_replace(',', '', $request->biaya);

        $validatedData = $request->validate($rules);
        $validatedData['biaya'] = $biaya;
        $validatedData['created_by'] = auth()->user()->username;
        $validatedData['user_id'] = auth()->user()->id;

        $tujuan_upload = 'upload/operasionalSite';
        $bukti_transaksi = '';
        $jumlahFile = $request->jumlah_bukti_transaksi;
        if ($jumlahFile != '' && $jumlahFile != 0) {
            for ($i = 1; $i <= $jumlahFile; $i++) {
                $fileSize = $request->file('bukti_transaksi_'.$i)->getSize();
                if ($fileSize <= 4194304) { // 4 MB
                    $gambar = $request->file('bukti_transaksi_'.$i);
                    $nama_gbr = time().'-'.$gambar->getClientOriginalName();
                    $gambar->move($tujuan_upload,$nama_gbr);
                    $bukti_transaksi .= $nama_gbr.',';
                }
            }
        }
        $validatedData['bukti_transaksi'] = $bukti_transaksi;

        $store = OperasionalSite::create($validatedData);
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
        $this->authorize('update', $operasionalSite);

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
        $this->authorize('update', $operasionalSite);

        $rules = [
            'kode_transaksi'=> 'required|max:255',
            'tanggal'=> 'required|date',
            'nama_transaksi'=> 'required|max:255',
            'biaya'=> 'required|max:255',
            'site_id'=> 'required',
        ];

        $biaya = str_replace(',', '', $request->biaya);

        $tujuan_upload = 'upload/operasionalSite';
        $bukti_transaksi = '';
        $jumlahFile = $request->jumlah_bukti_transaksi;
        if ($jumlahFile != '' && $jumlahFile != 0) {
            for ($i = 1; $i <= $jumlahFile; $i++) {
                $fileSize = $request->file('bukti_transaksi_'.$i)->getSize();
                if ($fileSize <= 4194304) { // 4 MB
                    $gambar = $request->file('bukti_transaksi_'.$i);
                    $nama_gbr = time().'-'.$gambar->getClientOriginalName();
                    $gambar->move($tujuan_upload,$nama_gbr);
                    $bukti_transaksi .= $nama_gbr.',';
                }
            }
        }
        $bukti_transaksi_baru = $operasionalSite->bukti_transaksi.$bukti_transaksi;

        $validatedData = $request->validate($rules);
        $validatedData['bukti_transaksi'] = $bukti_transaksi_baru;
        $validatedData['biaya'] = $biaya;
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
        $files  = $query->bukti_transaksi;

        OperasionalSite::destroy($operasionalSite->id);

        $file = explode(",",$files);
        $jumlahFile = count($file) - 1;
        for ($i = 0; $i < $jumlahFile; $i++) {
            $file_path = public_path('upload/operasionalSite/'.$file[$i]);
            if (File::exists($file_path)) {
                File::delete($file_path);
            }
        }

        return redirect(route('operasionalSite.index'))->with('success','Data berhasil dihapus');
    }
}

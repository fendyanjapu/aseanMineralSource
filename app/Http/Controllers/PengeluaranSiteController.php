<?php

namespace App\Http\Controllers;

use App\Models\HutangSite;
use App\Models\Site;
use App\Models\PengeluaranSite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class PengeluaranSiteController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', PengeluaranSite::class);

        $pengeluaranSites  = PengeluaranSite::all();
        
        return view('pengeluaranSite.index', compact('pengeluaranSites'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', PengeluaranSite::class);

        $query = PengeluaranSite::where(DB::raw('YEAR(created_at)'), '=', date('Y'));
        if ($query->count() == 0) {
            $lastId = 0;
        } else {
            $lastId = $query->orderBy('created_at', 'desc')->first()->id;
        }
        $nextId = $lastId + 1;
        $nextKode = str_pad($nextId,5,'0',STR_PAD_LEFT);
        $kode = 'PS'.date('y').$nextKode;

        $sites = Site::all();
        return view('pengeluaranSite.create', compact('sites', 'kode'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('viewAny', PengeluaranSite::class);
        
        $rules = [
            'kode_transaksi'=> 'required|max:255',
            'site_id'=> 'required',
            'jumlah'=> 'required|max:255',
            'sumber_dana'=> 'required|max:255',
            'metode_transaksi'=> 'required|max:255',
            'tanggal'=> 'required|date',
        ];

        $jumlah = str_replace(',', '', $request->jumlah);
        
        $validatedData = $request->validate($rules);
        $validatedData['jumlah'] = $jumlah;
        $validatedData['created_by'] = auth()->user()->username;
        $validatedData['user_id'] = auth()->user()->id;
        $validatedData['status_hutang'] = '1';

        $tujuan_upload = 'upload/pengeluaranSite';
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

        $store = PengeluaranSite::create($validatedData);

        $hutang = str_replace(',', '', $request->jumlah);
        $data = [
            'site_id' => $request->site_id,
            'pengeluaran_site_id' => $store->id,
            'hutang' => $hutang
        ];
        HutangSite::create($data);

        return redirect()->route('pengeluaranSite.index')->with('success','Data berhasil ditambah');
    }

    public function edit(PengeluaranSite $pengeluaranSite)
    {
        $this->authorize('update', $pengeluaranSite);

        $sites = Site::all();
        return view('pengeluaranSite.edit', compact('pengeluaranSite','sites'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PengeluaranSite $pengeluaranSite)
    {
        $this->authorize('update', $pengeluaranSite);
        
        $rules = [
            'kode_transaksi'=> 'required|max:255',
            'site_id'=> 'required',
            'jumlah'=> 'required|max:255',
            'sumber_dana'=> 'required|max:255',
            'metode_transaksi'=> 'required|max:255',
            'tanggal'=> 'required|date',
        ];

        $tujuan_upload = 'upload/pengeluaranSite';
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
        $bukti_transaksi_baru = $pengeluaranSite->bukti_transaksi.$bukti_transaksi;

        $jumlah = str_replace(',', '', $request->jumlah);
        $validatedData = $request->validate($rules);
        $validatedData['bukti_transaksi'] = $bukti_transaksi_baru;
        $validatedData['jumlah'] = $jumlah;
        $validatedData['updated_by'] = auth()->user()->username;
        PengeluaranSite::findOrFail($pengeluaranSite->id)->update($validatedData);

        $hutang = str_replace(',', '', $request->jumlah);
        $data = [
            'site_id' => $request->site_id,
            'hutang' => $hutang
        ];
        HutangSite::where('pengeluaran_site_id', '=', $pengeluaranSite->id)->update($data);

        return redirect(route('pengeluaranSite.index'))->with('success','Data berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PengeluaranSite $pengeluaranSite)
    {
        $this->authorize('delete', $pengeluaranSite);

        $query = PengeluaranSite::findOrFail($pengeluaranSite->id);
        $files  = $query->bukti_transaksi;

        HutangSite::where('pengeluaran_site_id', '=', $pengeluaranSite->id)->delete();
        PengeluaranSite::destroy($pengeluaranSite->id);

        $file = explode(",",$files);
        $jumlahFile = count($file) - 1;
        for ($i = 0; $i < $jumlahFile; $i++) {
            $file_path = public_path('upload/pengeluaranSite/'.$file[$i]);
            if (File::exists($file_path)) {
                File::delete($file_path);
            }
        }

        return redirect(route('pengeluaranSite.index'))->with('success','Data berhasil dihapus');
    }

    public function laporan(Request $request)
    {
        $dariTanggal = $request->dari_tanggal;
        $sampaiTanggal = $request->sampai_tanggal;
        $site_id = $request->site_id;
        if ($dariTanggal != null && $sampaiTanggal != null) {
            $query = PengeluaranSite::where('tanggal', '>=', $dariTanggal)
                        ->where('tanggal', '<=', $sampaiTanggal);
            
        } else {
            $query = PengeluaranSite::where('tanggal', '<=', '2000-01-01');
        }

        if ($site_id != 'all') {
            $query->where('site_id', '=', $site_id);
        }
        $pengeluaranSites = $query->get();
        $sites = Site::all();
        return view('pengeluaranSite.laporan', compact(
            'pengeluaranSites', 
            'dariTanggal', 
            'sampaiTanggal', 
            'site_id',
            'sites'
        ));
    }
}

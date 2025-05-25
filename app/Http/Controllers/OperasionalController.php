<?php

namespace App\Http\Controllers;

use App\Models\Operasional;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class OperasionalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny', Operasional::class);

        $operasionals = Operasional::all();

        return view('operasional.index', compact('operasionals'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Operasional::class);
        
        $query = Operasional::where(DB::raw('YEAR(created_at)'), '=', date('Y'));
        if ($query->count() == 0) {
            $lastId = 0;
        } else {
            $lastId = $query->orderBy('created_at', 'desc')->first()->id;
        }
        $nextId = $lastId + 1;
        $nextKode = str_pad($nextId,5,'0',STR_PAD_LEFT);
        $kode = 'KA'.date('y').$nextKode;
        
        return view('operasional.create', compact('kode'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create', Operasional::class);

        $rules = [
            'kode_transaksi'=> 'required|max:255',
            'tanggal'=> 'required|date',
            'nama_transaksi'=> 'required|max:255',
            'biaya'=> 'required|max:255',
            
        ];

        $biaya = str_replace(',', '', $request->biaya);

        $validatedData = $request->validate($rules);
        $validatedData['biaya'] = $biaya;
        $validatedData['created_by'] = auth()->user()->username;
        $validatedData['user_id'] = auth()->user()->id;

        $tujuan_upload = 'upload/operasional';
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

        $store = Operasional::create($validatedData);
        return redirect()->route('operasional.index')->with('success','Data berhasil ditambah');
    }

    /**
     * Display the specified resource.
     */
    public function show(Operasional $operasional)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Operasional $operasional)
    {
        $this->authorize('update', $operasional);

        return view('operasional.edit', compact('operasional'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Operasional $operasional)
    {
        $this->authorize('update', $operasional);

        $rules = [
            'kode_transaksi'=> 'required|max:255',
            'tanggal'=> 'required|date',
            'nama_transaksi'=> 'required|max:255',
            'biaya'=> 'required|max:255',
        ];

        $tujuan_upload = 'upload/operasional';
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

        $bukti_transaksi_baru = $operasional->bukti_transaksi.$bukti_transaksi;

        $biaya = str_replace(',', '', $request->biaya);

        $validatedData = $request->validate($rules);
        $validatedData['bukti_transaksi'] = $bukti_transaksi_baru;
        $validatedData['biaya'] = $biaya;
        $validatedData['updated_by'] = auth()->user()->username;
        Operasional::findOrFail($operasional->id)->update($validatedData);

        return redirect(route('operasional.index'))->with('success','Data berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Operasional $operasional)
    {
        $this->authorize('delete', $operasional);
        
        $query = Operasional::findOrFail($operasional->id);
        $files  = $query->bukti_transaksi;

        Operasional::destroy($operasional->id);

        $file = explode(",",$files);
        $jumlahFile = count($file) - 1;
        for ($i = 0; $i < $jumlahFile; $i++) {
            $file_path = public_path('upload/operasional/'.$file[$i]);
            if (File::exists($file_path)) {
                File::delete($file_path);
            }
        }

        return redirect(route('operasional.index'))->with('success','Data berhasil dihapus');
    }
}

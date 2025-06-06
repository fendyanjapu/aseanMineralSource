<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use Illuminate\Http\Request;
use App\Models\PerbaikanUnit;
use Illuminate\Support\Facades\DB;
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
        $query = PerbaikanUnit::where(DB::raw('YEAR(created_at)'), '=', date('Y'));
        if ($query->count() == 0) {
            $lastId = 0;
        } else {
            $lastId = $query->orderBy('created_at', 'desc')->first()->id;
        }
        $nextId = $lastId + 1;
        $nextKode = str_pad($nextId,5,'0',STR_PAD_LEFT);
        $kode = 'PU'.date('y').$nextKode;

        $units = Unit::all();
        return view('perbaikanUnit.create', compact('units', 'kode'));
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
        ];

        $total_harga = str_replace(',', '', $request->total_harga);

        $validatedData = $request->validate($rules);
        $validatedData['total_harga'] = $total_harga;
        $validatedData['created_by'] = auth()->user()->username;
        $validatedData['user_id'] = auth()->user()->id;

        $tujuan_upload = 'upload/perbaikanUnit';
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

        PerbaikanUnit::create($validatedData);
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

        $tujuan_upload = 'upload/perbaikanUnit';
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

        $bukti_transaksi_baru = $perbaikanUnit->bukti_transaksi.$bukti_transaksi;

        $total_harga = str_replace(',', '', $request->total_harga);

        $validatedData = $request->validate($rules);
        $validatedData['bukti_transaksi'] = $bukti_transaksi_baru;
        $validatedData['total_harga'] = $total_harga;
        $validatedData['updated_by'] = auth()->user()->username;
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
        $files  = $query->bukti_transaksi;

        PerbaikanUnit::destroy($perbaikanUnit->id);

        $file = explode(",",$files);
        $jumlahFile = count($file) - 1;
        for ($i = 0; $i < $jumlahFile; $i++) {
            $file_path = public_path('upload/perbaikanUnit/'.$file[$i]);
            if (File::exists($file_path)) {
                File::delete($file_path);
            }
        }

        return redirect(route('perbaikanUnit.index'))->with('success','Data berhasil dihapus');
    }
}

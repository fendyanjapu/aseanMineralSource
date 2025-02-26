<?php

namespace App\Http\Controllers;

use App\Models\Site;
use App\Models\KondisiBatu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class KondisiBatuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kondisiBatus = KondisiBatu::all();
        return view('kondisiBatu.index', compact('kondisiBatus'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $sites = Site::all();
        return view('kondisiBatu.create', compact('sites'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'keterangan'=> 'required',
            'lokasi'=> 'required',
            'site_id'=> 'required',
            'tanggal'=> 'required|date',
            'bukti_pelaporan' => 'required|file|mimes:jpg,jpeg,png|max:2000',
        ];

        $gambar = $request->file('bukti_pelaporan');
        $tujuan_upload = 'upload/kondisiBatu';
        $nama_gbr = time()."_".$gambar->getClientOriginalName(); 

        $validatedData = $request->validate($rules);
        $validatedData['created_by'] = auth()->user()->name;
        $validatedData['user_id'] = auth()->user()->id;
        $validatedData['bukti_pelaporan'] = $nama_gbr;

        $store = KondisiBatu::create($validatedData);

        if ($store) { $gambar->move($tujuan_upload,$nama_gbr); }
        return redirect()->route('kondisiBatu.index')->with('success','Data berhasil ditambah');
    }

    /**
     * Display the specified resource.
     */
    public function show(KondisiBatu $kondisiBatu)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(KondisiBatu $kondisiBatu)
    {
        $this->authorize('update', $kondisiBatu);

        $sites = Site::all();

        return view('kondisiBatu.edit', compact('kondisiBatu', 'sites'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, KondisiBatu $kondisiBatu)
    {
        $this->authorize('update', $kondisiBatu);

        $rules = [
            'keterangan'=> 'required',
            'lokasi'=> 'required',
            'site_id'=> 'required',
            'tanggal'=> 'required|date',
        ];

        $validatedData = $request->validate($rules);
        $validatedData['updated_by'] = auth()->user()->name;
        KondisiBatu::findOrFail($kondisiBatu->id)->update($validatedData);

        return redirect(route('kondisiBatu.index'))->with('success','Data berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(KondisiBatu $kondisiBatu)
    {
        $this->authorize('delete', $kondisiBatu);

        $query = KondisiBatu::findOrFail($kondisiBatu->id);
        $file  = $query->bukti_pelaporan;

        KondisiBatu::destroy($kondisiBatu->id);
        $file_path = public_path('upload/kondisiBatu/'.$file);
        if (File::exists($file_path)) {
            File::delete($file_path);
        }

        return redirect(route('kondisiBatu.index'))->with('success','Data berhasil dihapus');
    }
}

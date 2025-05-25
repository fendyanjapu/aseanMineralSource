<?php

namespace App\Http\Controllers;

use App\Models\Site;
use Illuminate\Http\Request;
use App\Models\KondisiLapangan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;

class KondisiLapanganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Session::get('level') == 4) {
            $kondisiLapangans = KondisiLapangan::where('site_id', '=', Session::get('site_id'))->get();
        } else {
            $kondisiLapangans = KondisiLapangan::all();
        }
        return view('kondisiLapangan.index', compact('kondisiLapangans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', KondisiLapangan::class);

        if (Session::get('level') == 4) {
            $sites = Site::where('id', '=', Session::get('site_id'))->get();
        } else {
            $sites = Site::all();
        }

        return view('kondisiLapangan.create', compact('sites'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create', KondisiLapangan::class);

        $rules = [
            'keterangan'=> 'required',
            'lokasi'=> 'required',
            'nama_jetty'=> 'required',
            'site_id'=> 'required',
            'tanggal'=> 'required|date',
            'bukti_pelaporan' => 'required|file|mimes:jpg,jpeg,png|max:2048',
        ];

        $gambar = $request->file('bukti_pelaporan');
        $tujuan_upload = 'upload/kondisiLapangan';
        $nama_gbr = time()."_".$gambar->getClientOriginalName(); 

        $validatedData = $request->validate($rules);
        $validatedData['created_by'] = auth()->user()->username;
        $validatedData['user_id'] = auth()->user()->id;
        $validatedData['bukti_pelaporan'] = $nama_gbr;

        $store = KondisiLapangan::create($validatedData);

        if ($store) { $gambar->move($tujuan_upload,$nama_gbr); }
        return redirect()->route('kondisiLapangan.index')->with('success','Data berhasil ditambah');
    }

    /**
     * Display the specified resource.
     */
    public function show(KondisiLapangan $kondisiLapangan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(KondisiLapangan $kondisiLapangan)
    {
        $this->authorize('update', $kondisiLapangan);

        if (Session::get('level') == 4) {
            $sites = Site::where('id', '=', Session::get('site_id'))->get();
        } else {
            $sites = Site::all();
        }

        return view('kondisiLapangan.edit', compact('kondisiLapangan', 'sites'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, KondisiLapangan $kondisiLapangan)
    {
        $this->authorize('update', $kondisiLapangan);

        $rules = [
            'keterangan'=> 'required',
            'lokasi'=> 'required',
            'nama_jetty'=> 'required',
            'site_id'=> 'required',
            'tanggal'=> 'required|date',
        ];

        $validatedData = $request->validate($rules);
        $validatedData['updated_by'] = auth()->user()->username;
        KondisiLapangan::findOrFail($kondisiLapangan->id)->update($validatedData);

        return redirect(route('kondisiLapangan.index'))->with('success','Data berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(KondisiLapangan $kondisiLapangan)
    {
        $this->authorize('delete', $kondisiLapangan);

        $query = KondisiLapangan::findOrFail($kondisiLapangan->id);
        $file  = $query->bukti_pelaporan;

        KondisiLapangan::destroy($kondisiLapangan->id);
        $file_path = public_path('upload/kondisiLapangan/'.$file);
        if (File::exists($file_path)) {
            File::delete($file_path);
        }

        return redirect(route('kondisiLapangan.index'))->with('success','Data berhasil dihapus');
    }
}

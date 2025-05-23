<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Barang;
use Illuminate\Http\Request;
use App\Models\PerbaikanUnit;
use App\Models\PembelianBarang;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\Rules\Can;

class PembelianBarangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny', PembelianBarang::class);
        
        $pembelianBarangs  = PembelianBarang::all();
        
        return view('pembelianBarang.index', compact('pembelianBarangs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', PembelianBarang::class);

        $query = PembelianBarang::where(DB::raw('YEAR(created_at)'), '=', date('Y'));
        if ($query->count() == 0) {
            $lastId = 0;
        } else {
            $lastId = $query->orderBy('created_at', 'desc')->first()->id;
        }
        $nextId = $lastId + 1;
        $nextKode = str_pad($nextId,5,'0',STR_PAD_LEFT);
        $kode = 'PB'.date('y').$nextKode;

        $barangs = Barang::orderBy('nama')->get();
        return view('pembelianBarang.create', compact('barangs', 'kode'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create', PembelianBarang::class);

        $rules = [
            'kode_transaksi'=> 'required|max:255',
            'barang_id'=> 'required',
            'jumlah'=> 'required',
            'harga_satuan'=> 'required',
            'total_harga'=> 'required',
            'keterangan'=> 'required',
            'tanggal'=> 'required|date',
            'bukti_transaksi' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ];

        $gambar = $request->file('bukti_transaksi');
        $tujuan_upload = 'upload/pembelianBarang';
        $nama_gbr = time()."_".$gambar->getClientOriginalName(); 

        $validatedData = $request->validate($rules);
        $validatedData['created_by'] = auth()->user()->username;
        $validatedData['user_id'] = auth()->user()->id;
        $validatedData['bukti_transaksi'] = $nama_gbr;

        $store = PembelianBarang::create($validatedData);

        if ($store) { $gambar->move($tujuan_upload,$nama_gbr); }
        return redirect()->route('pembelianBarang.index')->with('success','Data berhasil ditambah');
    }

    /**
     * Display the specified resource.
     */
    public function laporan(Request $request)
    {
        $dariTanggal = $request->dari_tanggal;
        $sampaiTanggal = $request->sampai_tanggal;
        if ($dariTanggal != null && $sampaiTanggal != null) {
            $query = PembelianBarang::where('tanggal', '>=', $dariTanggal)
                        ->where('tanggal', '<=', $sampaiTanggal);
            $query2 = PerbaikanUnit::where('tanggal', '>=', $dariTanggal)
                        ->where('tanggal', '<=', $sampaiTanggal);
        } else {
            $query = PembelianBarang::where('tanggal', '<=', '2000-01-01');
            $query2 = PerbaikanUnit::where('tanggal', '<=', '2000-01-01');
        }

        $pembelianBarangs = $query->get();
        $perbaikanUnits = $query2->get();
        return view('pembelianBarang.laporan', compact(
            'pembelianBarangs',
            'perbaikanUnits',
            'dariTanggal', 
            'sampaiTanggal', 
        ));

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PembelianBarang $pembelianBarang)
    {
        $this->authorize('update', $pembelianBarang);

        $barangs = Barang::orderBy('nama')->get();

        return view('pembelianBarang.edit', compact('pembelianBarang', 'barangs'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PembelianBarang $pembelianBarang)
    {
        $this->authorize('update', $pembelianBarang);
        
        $rules = [
            'kode_transaksi'=> 'required|max:255',
            'barang_id'=> 'required',
            'jumlah'=> 'required',
            'harga_satuan'=> 'required',
            'total_harga'=> 'required',
            'keterangan'=> 'required',
            'tanggal'=> 'required|date',
        ];

        $validatedData = $request->validate($rules);
        $validatedData['updated_by'] = auth()->user()->username;
        PembelianBarang::findOrFail($pembelianBarang->id)->update($validatedData);

        return redirect(route('pembelianBarang.index'))->with('success','Data berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PembelianBarang $pembelianBarang)
    {
        $this->authorize('delete', $pembelianBarang);

        $query = PembelianBarang::findOrFail($pembelianBarang->id);
        $file  = $query->bukti_transaksi;

        pembelianBarang::destroy($pembelianBarang->id);
        $file_path = public_path('upload/pembelianBarang/'.$file);
        if (File::exists($file_path)) {
            File::delete($file_path);
        }

        return redirect(route('pembelianBarang.index'))->with('success','Data berhasil dihapus');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Operasional;
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
        ];

        $harga_satuan = str_replace(',', '', $request->harga_satuan);
        $total_harga = str_replace(',', '', $request->total_harga);

        $validatedData = $request->validate($rules);
        $validatedData['harga_satuan'] = $harga_satuan;
        $validatedData['total_harga'] = $total_harga;
        $validatedData['created_by'] = auth()->user()->username;
        $validatedData['user_id'] = auth()->user()->id;

        $tujuan_upload = 'upload/pembelianBarang';
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
        PembelianBarang::create($validatedData);

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
            $query3 = Operasional::where('tanggal', '>=', $dariTanggal)
                        ->where('tanggal', '<=', $sampaiTanggal);
        } else {
            $query = PembelianBarang::where('tanggal', '<=', '2000-01-01');
            $query2 = PerbaikanUnit::where('tanggal', '<=', '2000-01-01');
            $query3 = Operasional::where('tanggal', '<=', '2000-01-01');
        }

        $pembelianBarangs = $query->orderBy('tanggal')->get();
        $perbaikanUnits = $query2->orderBy('tanggal')->get();
        $operasionals = $query3->orderBy('tanggal')->get();
        return view('pembelianBarang.laporan', compact(
            'pembelianBarangs',
            'perbaikanUnits',
            'operasionals',
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

        $tujuan_upload = 'upload/pembelianBarang';
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

        $bukti_transaksi_baru = $pembelianBarang->bukti_transaksi.$bukti_transaksi;
        
        $harga_satuan = str_replace(',', '', $request->harga_satuan);
        $total_harga = str_replace(',', '', $request->total_harga);

        $validatedData = $request->validate($rules);
        $validatedData['bukti_transaksi'] = $bukti_transaksi_baru;
        $validatedData['harga_satuan'] = $harga_satuan;
        $validatedData['total_harga'] = $total_harga;
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
        $files  = $query->bukti_transaksi;

        pembelianBarang::destroy($pembelianBarang->id);

        $file = explode(",",$files);
        $jumlahFile = count($file) - 1;
        for ($i = 0; $i < $jumlahFile; $i++) {
            $file_path = public_path('upload/pembelianBarang/'.$file[$i]);
            if (File::exists($file_path)) {
                File::delete($file_path);
            }
        }

        return redirect(route('pembelianBarang.index'))->with('success','Data berhasil dihapus');
    }
}

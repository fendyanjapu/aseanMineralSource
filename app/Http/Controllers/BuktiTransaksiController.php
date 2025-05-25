<?php

namespace App\Http\Controllers;

use App\Models\Operasional;
use App\Models\OperasionalSite;
use App\Models\PembayaranPenjualan;
use App\Models\PengeluaranSite;
use App\Models\PerbaikanUnit;
use Illuminate\Http\Request;
use App\Models\PembelianBarang;
use Illuminate\Support\Facades\File;

class BuktiTransaksiController extends Controller
{
    public function add(Request $request)
    {
        $jumlah = $request->jumlah;
        for ($i = 1; $i <= $jumlah; $i++) {
            echo '<div class="card-body">
                    <label>Bukti Transaksi</label>
                    <input type="file" class="form-control" name="bukti_transaksi_'.$i.'" accept="image/*,application/pdf" required>
                    <small>*Maksimal 4 MB</small>
                </div>';
        }
    }

    public function delete(Request $request) {
        $bukti = $request->bukti_transaksi;
        $id = $request->id;
        $tabel = $request->tabel;

        switch ($tabel) {
            case 'pembelianBarang':
                $query = PembelianBarang::findOrFail($id);
                break;
            case 'pengeluaranSite':
                $query = PengeluaranSite::findOrFail($id);
                break;
            case 'perbaikanUnit':
                $query = PerbaikanUnit::findOrFail($id);
                break;
            case 'operasional':
                $query = Operasional::findOrFail($id);
                break;
            case 'operasionalSite':
                $query = OperasionalSite::findOrFail($id);
                break;
            case 'pembayaranPenjualan':
                $query = PembayaranPenjualan::findOrFail($id);
                break;
            default:
                # code...
                break;
        }
        $bukti_transaksis = $query->bukti_transaksi;
        $bukti_transaksi = str_replace($bukti.',', '', $bukti_transaksis);
        $data = ['bukti_transaksi' => $bukti_transaksi];
        $query->update($data);
        $file_path = public_path('upload/'.$tabel.'/'.$bukti);
        if (File::exists($file_path)) {
            File::delete($file_path);
        }
    }
}

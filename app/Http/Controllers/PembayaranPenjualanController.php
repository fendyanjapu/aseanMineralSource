<?php

namespace App\Http\Controllers;

use App\Models\Site;
use App\Models\HutangSite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\PembayaranPenjualan;

class PembayaranPenjualanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $pembayaranPenjualans  = PembayaranPenjualan::all();
        $sites = Site::all();
        return view('pembayaranPenjualan.index', compact('pembayaranPenjualans', 'sites'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $query = PembayaranPenjualan::where(DB::raw('YEAR(created_at)'), '=', date('Y'));
        if ($query->count() == 0) {
            $lastId = 0;
        } else {
            $lastId = $query->orderBy('created_at', 'desc')->first()->id;
        }
        $nextId = $lastId + 1;
        $nextKode = str_pad($nextId,7,'0',STR_PAD_LEFT);
        $kode = 'A'.date('y').$nextKode;

        $sites = Site::all();
        
        return view('pembayaranPenjualan.create', compact('sites', 'kode'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(PembayaranPenjualan $pembayaranPenjualan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PembayaranPenjualan $pembayaranPenjualan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PembayaranPenjualan $pembayaranPenjualan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PembayaranPenjualan $pembayaranPenjualan)
    {
        //
    }

    public function getTotalHutang(Request $request)
    {
        $site_id = $request->site_id;
        $totalHutang = HutangSite::where('site_id', '=', $site_id)->sum('hutang');
        return json_encode($totalHutang);
    }
}

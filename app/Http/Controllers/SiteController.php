<?php

namespace App\Http\Controllers;

use App\Models\Site;
use App\Models\User;
use Illuminate\Http\Request;

class SiteController extends Controller
{
    private $rules = [
        'nama_site'=> 'required|max:255',
        'lokasi'=> 'required|max:255',
        'penanggung_jawab'=> 'required|max:255',
    ];
    public function index()
    {
        $this->authorize('viewAny', User::class);
        
        $sites  = Site::all();
       
        return view('site.index', compact('sites'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', User::class);

        return view('site.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create', User::class);
        
        $validatedData = $request->validate($this->rules);
        
        $validatedData['created_by'] = auth()->user()->username;
        $validatedData['user_id'] = auth()->user()->id;
        Site::create($validatedData);
        return redirect()->route('site.index')->with('success','Data berhasil ditambah');
    }

    /**
     * Display the specified resource.
     */
    public function show(Site $site)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Site $site)
    {
        $this->authorize('update', $site);

        return view('site.edit', compact('site'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Site $site)
    {
        $this->authorize('update', $site);

        $validatedData = $request->validate($this->rules);
        $validatedData['updated_by'] = auth()->user()->username;
        Site::findOrFail($site->id)->update($validatedData);

        return redirect(route('site.index'))->with('success','Data berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Site $site)
    {
        $this->authorize('delete', $site);

        Site::destroy($site->id);
        return redirect(route('site.index'))->with('success','Data berhasil dihapus');
    }
}

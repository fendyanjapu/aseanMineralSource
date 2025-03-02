<?php

namespace App\Http\Controllers;

use App\Models\Site;
use App\Models\User;
use Illuminate\Http\Request;

class UserSiteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny', User::class);

        $users = User::where('jenis_user_id', '=', 2)->get();
        
        return view('userSite.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $sites = Site::all();
        return view('userSite.create', compact('sites'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'name'=> 'required|max:255',
            'username'=> 'required|max:255',
            'password'=> 'required|max:255',
            'level_id'=> 'required',
            'site_id'=> 'required',
        ];

        $validatedData = $request->validate($rules);
        $validatedData['jenis_user_id'] = 2;
        $validatedData['created_by'] = auth()->user()->name;
        User::create($validatedData);
        return redirect()->route('userSite.index')->with('success','Data berhasil ditambah');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $userSite)
    {
        $this->authorize('update', $userSite);

        return view('userSite.edit', compact('userSite'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $userSite)
    {
        $this->authorize('update', $userSite);

        $rules = [
            'name'=> 'required|max:255',
            'username'=> 'required|max:255',
            'site_id'=> 'required',
        ];

        $validatedData = $request->validate($rules);
        $validatedData['updated_by'] = auth()->user()->name;
        User::findOrFail($userSite->id)->update($validatedData);

        return redirect(route('userSite.index'))->with('success','Data berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $userSite)
    {
        $this->authorize('delete', $userSite);

        User::destroy($userSite->id);
        return redirect(route('userSite.index'))->with('success','Data berhasil dihapus');
    }
}

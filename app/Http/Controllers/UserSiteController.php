<?php

namespace App\Http\Controllers;

use App\Models\Site;
use App\Models\SiteUser;
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

        $site_user = [];
        foreach ($users as $user) {
            $site_user[$user->id] = SiteUser::where('user_id', '=', $user->id)->get();
        }
        
        return view('userSite.index', compact('users', 'site_user'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', User::class);

        $sites = Site::all();
        return view('userSite.create', compact('sites'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create', User::class);

        $rules = [
            'name'=> 'required|max:255',
            'username'=> 'required|max:255',
            'password' => [
                'required',
                'string',
                'min:8',              // must be at least 8 characters in length
                'regex:/[a-z]/',      // must contain at least one lowercase letter
                'regex:/[A-Z]/',      // must contain at least one uppercase letter
                'regex:/[0-9]/',      // must contain at least one digit
                'regex:/[@$!%*#?&]/', // must contain a special character
            ],
            'level_id'=> 'required',
            'is_checker'=> 'required',
        ];

        $validatedData = $request->validate($rules);
        $validatedData['jenis_user_id'] = 2;
        $validatedData['created_by'] = auth()->user()->username;
        $store = User::create($validatedData);

        $sites = $request->site;
        foreach ($sites as $site) {
            $data = [
                'user_id' => $store->id,
                'site_id' => $site
            ];
            SiteUser::create($data);
        }

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

        $sites = Site::all();
        $siteUser[] = '';

        foreach ($sites as $site) {
            $siteUsers = SiteUser::where('user_id', '=', $userSite->id)
                                    ->where('site_id', '=', $site->id)
                                    ->count();
            if ($siteUsers > 0) {
                $siteUser[$site->id] = 'checked';
            } else {
                $siteUser[$site->id] = '';
            }
        }

        return view('userSite.edit', compact('userSite', 'sites', 'siteUser'));
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
            'is_checker'=> 'required',
        ];

        $validatedData = $request->validate($rules);
        $validatedData['updated_by'] = auth()->user()->username;
        User::findOrFail($userSite->id)->update($validatedData);

        SiteUser::where('user_id', '=', $userSite->id)->delete();
        $sites = $request->site;
        foreach ($sites as $site) {
            $data = [
                'user_id' => $userSite->id,
                'site_id' => $site
            ];
            SiteUser::create($data);
        }

        return redirect(route('userSite.index'))->with('success','Data berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $userSite)
    {
        $this->authorize('delete', $userSite);

        User::destroy($userSite->id);

        SiteUser::where('user_id', '=', $userSite->id)->delete();
        
        return redirect(route('userSite.index'))->with('success','Data berhasil dihapus');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Level;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', User::class);

        $users = User::where('jenis_user_id', '=', 1)->get();
        
        return view('user.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $levels = Level::where('id', '<', 4)->get();
        return view('user.create', compact('levels'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
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
            'level_id'=> 'required|max:255',
        ];

        $validatedData = $request->validate($rules);
        $validatedData['jenis_user_id'] = 1;
        $validatedData['created_by'] = auth()->user()->name;
        User::create($validatedData);
        return redirect()->route('user.index')->with('success','Data berhasil ditambah');
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
    public function edit(User $user)
    {
        $this->authorize('update', $user);

        $levels = Level::where('id', '<', 4)->get();
        return view('user.edit', compact('user', 'levels'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $this->authorize('update', $user);

        $rules = [
            'name'=> 'required|max:255',
            'username'=> 'required|max:255',
            'level_id'=> 'required|max:255',
        ];

        $validatedData = $request->validate($rules);
        $validatedData['updated_by'] = auth()->user()->name;
        User::findOrFail($user->id)->update($validatedData);

        return redirect(route('user.index'))->with('success','Data berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $this->authorize('delete', $user);

        User::destroy($user->id);
        return redirect(route('user.index'))->with('success','Data berhasil dihapus');
    }
}

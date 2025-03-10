<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SettingsController extends Controller
{
    public function index()
    {
        return view('settings');
    }

    public function store(Request $request)
    {
        $user = User::findOrFail(auth()->user()->id);

        /*
        * Validate all input fields
        */
        $this->validate($request, [
            'password' => 'required',
            'new_password' => [
                'required',
                'string',
                'min:8',              // must be at least 8 characters in length
                'regex:/[a-z]/',      // must contain at least one lowercase letter
                'regex:/[A-Z]/',      // must contain at least one uppercase letter
                'regex:/[0-9]/',      // must contain at least one digit
                'regex:/[@$!%*#?&]/', // must contain a special character
            ],
            'confirm_password' => 'required|min:8|same:new_password',
        ]);

        if (Hash::check($request->password, $user->password)) { 
        $user->fill([
            'password' => Hash::make($request->new_password)
            ])->save();

            return redirect()->route('settings.index')->with('success','Password berhasil diubah!');

        } else {
            return redirect()->route('settings.index')->with('error','Password gagal diubah!');
        }
    }
}

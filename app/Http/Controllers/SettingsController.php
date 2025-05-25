<?php

namespace App\Http\Controllers;

use App\Models\Site;
use App\Models\User;
use App\Models\SiteUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

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

    public function changeSite()
    {
        $sites = SiteUser::where('user_id', '=', auth()->user()->id)->get();
        return view('changeSite', compact('sites'));
    }

    public function relogin(Request $request)
    {
        $site = Site::where('id', '=', $request->site_id)->first();
        Session::put('site_id', $request->site_id);
        Session::put('nama_site', $site->nama_site);
        Session::put('level', '4');
        return redirect()->route('dashboard');
    }

    public function switchChecker() {
        if (auth()->user()->level_id == 4 && auth()->user()->is_checker == 1) {
            Session::put('level', '3');
            return redirect()->route('dashboard');
        } else {
            return redirect()->route('dashboard');
        }
        
        
    }
}

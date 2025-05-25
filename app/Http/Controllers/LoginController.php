<?php

namespace App\Http\Controllers;

use App\Models\Site;
use App\Models\User;
use App\Models\SiteUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    public function index()
    {
        if (auth()->user()) {
            return redirect()->route('dashboard');
        } else {
            $sites = Site::all();
            return view("login", compact('sites'));
        }
    }

    public function signin(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $user = User::where('username', '=', $request->username)->first();
            $id_user = $user->id;
            $level = $user->level_id;

            // cek apakah user level adalah operator
            if ($level == 4) {
                $cekSite = SiteUser::where('user_id', '=', $id_user)
                                ->where('site_id', '=', $request->site_id)
                                ->count();
                if ($cekSite > 0) {
                    $request->session()->regenerate();
                    $site = Site::where('id', '=', $request->site_id)->first();
                    Session::put('site_id', $request->site_id);
                    Session::put('nama_site', $site->nama_site);
                    Session::put('level', auth()->user()->level_id);
                    return redirect()->intended(route('dashboard'));
                } else {
                    Auth::logout();
                    return back()->with('loginError', 'Login failed!');
                }   
            } else {
                $request->session()->regenerate();
                Session::put('level', auth()->user()->level_id);
                return redirect()->intended(route('dashboard'));
            }
            
        } else {
            return back()->with('loginError', 'Login failed!');
        }
        
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        return redirect()->route('login');
    }
}

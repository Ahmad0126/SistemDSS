<?php

namespace App\Http\Controllers;

use App\Models\PublicGrafik;
use App\Models\User;
use App\Models\UserTabel;
use App\Models\UserGrafik;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;

class Home extends Controller
{
    public function index(){
        $data['grafik'] = PublicGrafik::getAll();
        $data['title'] = 'Explore Charts | SistemDSS';
        return view('landing', $data);
    }
    public function home(){
        $data['published'] = PublicGrafik::getMine(4);
        $data['tabel'] = UserTabel::where('id_user', Auth::user()->id)->limit(5)->orderBy('created_at', 'desc')->get();
        $data['grafik'] = UserGrafik::where('id_user', Auth::user()->id)->limit(5)->orderBy('created_at', 'desc')->get();
        $data['title'] = 'Dashboard';
        return view('home', $data);
    }

    public function login(Request $req):RedirectResponse{
        $user = $req->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        if(Auth::attempt($user)){
            $req->session()->regenerate();
            return redirect()->intended();
        }

        return back()->withErrors([
            'email' => 'Login Failed!'
        ])->onlyInput('email');
    }
    public function daftar(Request $req){
        $req->validate([
            'nama' => 'required',
            'email' => 'required|unique:users,email',
            'password' => 'required',
        ]);
        
        if($req->password != $req->password_konfirmasi){
            return back()->withErrors('Konfirmasi kembali password anda')->withInput();
        }

        $user = new User();
        $user->nama = $req->nama;
        $user->email = $req->email;
        $user->level = 'User';
        $user->password = Hash::make($req->password);
        $user->save();

        Auth::login($user);
        $req->session()->regenerate();
        return redirect()->intended();
    }
    public function logout(Request $request): RedirectResponse{
        Auth::logout();
    
        $request->session()->invalidate();
    
        $request->session()->regenerateToken();
    
        return redirect('/login');
    }
    public function ganti_password(Request $req){
        $req->validate([
            'password_lama' => 'required',
            'password_baru' => 'required',
            'password_konfirmasi' => 'required',
        ]);

        if(!Hash::check($req->password_lama, Auth::user()->password)){
            return back()->withErrors('Password Lama Salah!')->withInput();
        }
        if($req->password_baru != $req->password_konfirmasi){
            return back()->withErrors('Konfirmasi Password Baru Kembali')->withInput();
        }

        $user = User::find(Auth::user()->id);
        $user->password = Hash::make($req->password_baru);
        $user->save();

        return redirect()->intended()->with('alert', 'Berhasil Mengubah Password');
    }
}

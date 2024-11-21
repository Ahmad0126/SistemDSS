<?php

namespace App\Http\Controllers;

use App\Models\Data;
use App\Models\User;
use App\Models\Baris;
use App\Models\Kolom;
use App\Models\Tabel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;

class Home extends Controller
{
    public function index(){
        $data['tabel'] = Tabel::all();
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
            return redirect(route('base'));
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
        return redirect(route('base'));
    }
    public function logout(Request $request): RedirectResponse{
        Auth::logout();
    
        $request->session()->invalidate();
    
        $request->session()->regenerateToken();
    
        return redirect('/login');
    }
    public function tabel($id){
        $tabel = new Tabel();
        $data['table'] = $tabel->getData($id);
        $data['title'] = 'Tabel '.$data['table']['tabel']->nama;
        return view('tabel', $data);
    }
    public function tambah(Request $req){
        $req->validate([
            'nama' => 'required'
        ]);

        $tabel = new Tabel();
        $tabel->nama = $req->nama;
        $tabel->tipe = 'bar';
        $tabel->orientasi = 'h';
        $tabel->save();

        return redirect()->back()->with('alert', 'Berhasil menambah tabel');
    }
    public function edit(Request $req){
        $req->validate([
            'nama' => 'required',
            'id' => 'required:tabel,id'
        ]);

        $tabel = Tabel::find($req->id);
        $tabel->nama = $req->nama;
        $tabel->save();

        return redirect()->back()->with('alert', 'Berhasil mengedit tabel');
    }
    public function hapus($id){
        $row = Baris::where('id_tabel', $id)->get();
        $col = Kolom::where('id_tabel', $id)->get();
        foreach($row as $baris){
            $data = Data::where('id_baris', $baris->id)->get();
            Data::destroy($data);
        }
        Baris::destroy($row);
        Kolom::destroy($col);
        Tabel::destroy($id);
        
        return redirect()->back()->with('alert', 'Berhasil menghapus tabel');
    }
}

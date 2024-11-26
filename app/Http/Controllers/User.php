<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User as ModelUser;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class User extends Controller
{
    public function index(){
        $data['user'] = ModelUser::all();
        $data['title'] = 'Daftar User';
        return view('user', $data);
    }
    public function tambah(Request $req){
        $req->validate([
            'nama' => 'required',
            'email' => 'required|unique:users,email',
            'password' => 'required',
            'level' => 'required',
        ]);

        $user = new ModelUser();
        $user->nama = $req->nama;
        $user->email = $req->email;
        $user->level = $req->level;
        $user->password = Hash::make($req->password);
        $user->save();

        return redirect()->back()->with('alert', 'Berhasil menambah user');
    }
    public function edit(Request $req){
        $req->validate([
            'nama' => 'required',
            'id' => 'required:users,id',
            'email' => 'required|unique:users,email,'.$req->id.',id',
            'level' => 'required',
        ]);

        $user = ModelUser::find($req->id);
        $user->nama = $req->nama;
        $user->email = $req->email;
        $user->level = $req->level;
        $user->save();

        return redirect()->back()->with('alert', 'Berhasil mengedit user');
    }
    public function hapus($id){
        if($id == Auth::user()->id){
            return redirect()->back()->withErrors('Dilarang BUNDIR di sini');
        }
        ModelUser::destroy($id);
        
        return redirect()->back()->with('alert', 'Berhasil menghapus user');
    }
}

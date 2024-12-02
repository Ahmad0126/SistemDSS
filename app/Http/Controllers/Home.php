<?php

namespace App\Http\Controllers;

use App\Models\Data;
use App\Models\User;
use App\Models\Baris;
use App\Models\Kolom;
use App\Models\Tabel;
use Illuminate\Http\Request;
use App\Services\QueryService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;

class Home extends Controller
{
    protected $queryService;

    public function __construct(QueryService $queryService){
        $this->queryService = $queryService;
    }

    public function index(){
        $data['tabel'] = Tabel::where('id_user', Auth::user()->id)->get();
        $data['title'] = 'Dashboard';
        return view('home', $data);
    }
    public function tes_query(Request $req){
        dd($this->queryService->modifyQuery($req->input('query'), auth()->id()));
    }
    public function executeRawQuery(Request $request){
        $request->validate([
            'query' => 'required|string',
        ]);

        try {
            $query = $request->input('query');
            if(preg_match('/create table/i', $query)){
                $nama_tabel = explode(" ", $query)[2];
                $tabel = new Tabel();
                $tabel->nama = $nama_tabel;
                $tabel->nama_asli = "user_".auth()->id()."_{$nama_tabel}";
                $tabel->id_user = Auth::user()->id;
                $tabel->tipe = 'bar';
                $tabel->orientasi = 'h';
                $tabel->mr = 10;
                $tabel->ml = 10;
                $tabel->mt = 6;
                $tabel->mb = 6;
                $tabel->save();
            }
            // Jalankan query
            DB::statement($this->queryService->modifyQuery($query, auth()->id()));

            return back()->with('alert', 'Query executed successfully!');
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
        }
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
        $tabel->id_user = Auth::user()->id;
        $tabel->tipe = 'bar';
        $tabel->orientasi = 'h';
        $tabel->mr = 10;
        $tabel->ml = 10;
        $tabel->mt = 6;
        $tabel->mb = 6;
        $tabel->save();

        return redirect()->back()->with('alert', 'Berhasil menambah project');
    }
    public function edit(Request $req){
        $req->validate([
            'nama' => 'required',
            'id' => 'required:tabel,id'
        ]);

        $tabel = Tabel::find($req->id);
        $tabel->nama = $req->nama;
        $tabel->save();

        return redirect()->back()->with('alert', 'Berhasil mengedit project');
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
        
        return redirect()->back()->with('alert', 'Berhasil menghapus project');
    }
}

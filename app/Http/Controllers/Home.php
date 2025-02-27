<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserTabel;
use App\Models\UserGrafik;
use App\Models\PublicGrafik;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;

class Home extends Controller
{
    public function index(){
        $query = [
            'publisher' => null,
            'tipe_grafik' => null,
            'order_by' => null,
            'urutan' => null,
            'key' => null,
        ];
        
        $data['old'] = $query;
        $data['grafik'] = PublicGrafik::getAll();
        $data['public'] = true;
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
    public function project($id){
        $grafik = PublicGrafik::getSingle($id)->first();
        if(!$grafik) abort(404);
        
        $graph = UserGrafik::find($grafik->id_grafik);
        $data['query_error'] = null;
        try {
            $result = [];
            if($graph->query){
                $result = DB::select(UserTabel::modifyQuery($graph->query, user_id: $graph->id_user));
                $result = json_decode(json_encode($result), true);
            }

            $data['kolom'] = empty($result) ? [] : array_keys($result[0]);
            $data['baris'] = $result;
        } catch (\Exception $e) {
            $data['query_error'] = $e->getMessage();
        }

        $data['grafik'] = $grafik;
        $data['title'] = $data['grafik']->judul.' | SistemDSS';
        return view('deskripsi_grafik', $data);
    }
    public function search(Request $req){
        $query = [
            'publisher' => $req->publisher,
            'tipe_grafik' => $req->tipe_grafik,
            'order_by' => $req->order_by,
            'urutan' => $req->urutan,
            'key' => $req->key,
        ];
        
        $data['old'] = $query;
        $data['grafik'] = PublicGrafik::search($req)->appends($query);
        $data['public'] = true;
        $data['title'] = 'Search '.$req->key.' | SistemDSS';
        return view('landing', $data);
    }
    public function search_mine(Request $req){
        $data['grafik'] = PublicGrafik::searchMine($req->key);
        $data['public'] = false;
        $data['title'] = 'Search '.$req->key.' | SistemDSS';
        return view('landing', $data);
    }

    public function login(Request $req):RedirectResponse{
        $user = $req->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        if(Auth::attempt($user)){
            $req->session()->regenerate();
            return redirect()->intended('/home');
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

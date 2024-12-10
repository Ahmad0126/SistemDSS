<?php

namespace App\Http\Controllers;

use App\Models\Data;
use App\Models\User;
use App\Models\Baris;
use App\Models\Kolom;
use App\Models\Tabel;
use App\Models\UserTabel;
use App\Models\UserGrafik;
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
        $data['tabel'] = UserTabel::where('id_user', Auth::user()->id)->limit(5)->orderBy('created_at', 'desc')->get();
        $data['grafik'] = UserGrafik::where('id_user', Auth::user()->id)->limit(5)->orderBy('created_at', 'desc')->get();
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
        $tabel = UserTabel::find($id);
        $tableData = DB::table($tabel->nama_asli)->paginate(25);
        $result = json_decode(json_encode($tableData->items()), true);

        $data['kolom'] = empty($result) ? [] : array_keys($result[0]);
        $data['baris'] = $result;
        $data['id'] = $id;
        $data['page'] = $tableData;
        $data['tabel'] = UserTabel::where('id_user', auth()->id())->get();
        $data['title'] = 'Tabel '.$tabel->nama;
        return view('tabel', $data);
    }
    public function tambah(Request $req){
        $req->validate([
            'nama' => 'required'
        ]);

        return UserTabel::buat_tabel($req->nama, true);
    }
    public function edit(Request $req){
        $req->validate([
            'nama' => 'required',
            'id' => 'required:tabel,id'
        ]);

        return UserTabel::rename_tabel($req->nama, $req->id, true);
    }
    public function hapus($id){
        return UserTabel::drop_tabel($id, true);
    }
}

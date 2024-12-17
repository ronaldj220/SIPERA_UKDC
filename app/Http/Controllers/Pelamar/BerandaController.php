<?php

namespace App\Http\Controllers\Pelamar;

use App\Http\Controllers\Controller;
use App\Models\Recruitmen;
use App\Models\User;
use App\Models\Admin\Lowongan;
use App\Models\Admin\Agama;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class BerandaController extends Controller
{
    public function index()
    {
        $title = 'Beranda';
        $karyawan = User::join('role_has_users', 'users.id', '=', 'role_has_users.fk_user')
            ->join('role', 'role_has_users.fk_role', '=', 'role.id')
            ->where('role_has_users.fk_role', 2)
            ->select('users.*', 'role.role as role_name', 'role_has_users.fk_role as role')
            ->first();
        // Cek apakah profil lengkap
        if(!$karyawan->profil_lengkap){
            return redirect()->route('pelamar.profile')->with('toast_error', 'Harap lengkapi profil Anda sebelum melanjutkan.');
        }
            
        $lowongan = Lowongan::select('id', 'name_lowongan', 'description', 'img_base_64', 'created_at', 'expired_at')->where('expired_at', '>=', now()->subDays(30))
                        ->orderBy('expired_at', 'desc')
                        ->get();

        return view('halaman_karyawan.beranda.index', [
            'title' => $title,
            'karyawan' => $karyawan,
            'lowongan_pelamar' => $lowongan,
        ]);
    }
    public function ubah_pwd()
    {
        $title = 'Ubah Kata Sandi';
        $karyawan = User::join('role_has_users', 'users.id', '=', 'role_has_users.fk_user')
            ->join('role', 'role_has_users.fk_role', '=', 'role.id')
            ->where('role_has_users.fk_role', 2)
            ->select('users.*', 'role.role as role_name', 'role_has_users.fk_role as role')
            ->first();

        return view('halaman_karyawan.beranda.profile.index', [
            'title' => $title,
            'karyawan' => $karyawan
        ]);
    }
    public function change_pwd(Request $request)
    {
        $request->validate([
            'new_password' => 'required|min:8',
            'confirm_password' => 'required|same:new_password',
        ]);
        DB::table('users')->where('id', Auth::user()->id)->update([
            'password' => Hash::make($request->new_password)
        ]);
    }
    
    public function profile(){
        $title = 'Profil';
        $karyawan = User::join('role_has_users', 'users.id', '=', 'role_has_users.fk_user')
            ->join('role', 'role_has_users.fk_role', '=', 'role.id')
            ->where('role_has_users.fk_role', 2)
            ->select('users.*', 'role.role as role_name', 'role_has_users.fk_role as role')
            ->first();
        $agama = Agama::all();
        
        $response = json_decode(file_get_contents(env('CITY_API_URL')), true);
        // Check if the response is successful and extract the result
        $cityList = [];
        $currentBirthPlaceId = Auth::user()->tempat_lahir; 
        if ($response['status'] === 200) {
            $cityList = $response['result']; // Assuming this is the array of cities
        }
        
        return view('halaman_karyawan.beranda.profile.profil', [
            'title' => $title,
            'karyawan' => $karyawan,
            'agama' => $agama,
            'cityList' => $cityList,
            'currentBirthPlaceId' => $currentBirthPlaceId
        ]);
    }
    
    public function update_profile($id, Request $request){
        $request->validate([
            'agama' => 'required',
            'alamat' => 'required',
            'phone_number' => 'required|numeric',
            'tempat_lahir' => 'required',
            'tgl_lahir' => 'required|date',
            'pendidikan' => 'required',
            'jurusan' => 'required',
            'universitas' => 'required'
        ], [
            'agama.required' => 'Kolom Agama Harap Diisi!',
            'alamat.required' => 'Kolom Alamat Harap Diisi!',
            'phone_number.required' => 'Kolom Nomor Telepon Harap Diisi!',
            'phone_number.numeric' => 'Kolom Nomor Telepon Harus Berupa Angka!',
            'pendidikan.required' => 'Pendidikan Terakhir Harap Diisi!',
            'jurusan.required' => 'Jurusan/Fakultas Harap Diisi!',
            'tempat_lahir.required' => 'Tempat Lahir Pelamar Harap Diisi!',
            'tgl_lahir.required' => 'Tanggal Lahir Pelamar Harap Diisi!' ,
            'jurusan.required' => 'Jurusan/Fakultas Pelamar Harap Diisi!',
            'universitas.required' => 'Universitas milik pelamar harap diisi!'
        ]);
        
        $agamaInput = $request->input('agama');
        $agama = Agama::find($agamaInput);
        if(!$agama){
            return redirect()->route('pelamar.profile')->with('toast_error', 'Data Agama tidak ditemukan');
        }
    
        $data = [
            'id_agama' => $agama->id,
            'alamat' => $request->input('alamat'),
            'phone_number' => $request->input('phone_number'),
            'universitas' => $request->input('universitas'),
            'pendidikan' => $request->input('pendidikan'),
            'tempat_lahir' => $request->input('tempat_lahir'),
            'tgl_lahir' => $request->input('tgl_lahir'),
            'jurusan' => $request->input('jurusan'),
            'profil_lengkap' => 1
        ];
        User::whereId($id)->update($data);
        // dd($request->all());
        return redirect()->route('karyawan.beranda')->with('success', 'Profil Pelamar Berhasil Diperbarui!');
    }
}

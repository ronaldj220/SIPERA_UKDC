<?php

namespace App\Http\Controllers\Pelamar;

use App\Http\Controllers\Controller;
use App\Models\Recruitmen;
use App\Models\User;
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

        return view('halaman_karyawan.beranda.index', [
            'title' => $title,
            'karyawan' => $karyawan,
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
}

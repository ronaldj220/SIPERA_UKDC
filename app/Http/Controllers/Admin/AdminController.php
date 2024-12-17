<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role_Has_User;
use App\Models\User;
use App\Models\Admin\Agama;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function index()
    {
        $title = 'Admin';
        $admin = User::join('role_has_users', 'users.id', '=', 'role_has_users.fk_user')
            ->where('role_has_users.fk_role', 1)
            ->orderBy('nama', 'asc')
            ->paginate(10);
        $admin_data = User::join('role_has_users', 'users.id', '=', 'role_has_users.fk_user')
            ->join('role', 'role_has_users.fk_role', '=', 'role.id')
            ->where('role_has_users.fk_role', 1)
            ->select('users.*', 'role.role as role_name')
            ->first();
        return view('halaman_admin.admin.index', [
            'title' => $title,
            'admin_data' => $admin,
            'admin' => $admin_data
        ]);
    }
    public function add_admin()
    {
        $title = 'Tambah Admin';
        $admin = User::join('role_has_users', 'users.id', '=', 'role_has_users.fk_user')
            ->join('role', 'role_has_users.fk_role', '=', 'role.id')
            ->where('role_has_users.fk_role', 1)
            ->select('users.*', 'role.role as role_name')
            ->first();
        $agama = Agama::all();
        return view('halaman_admin.admin.add_admin', [
            'title' => $title,
            'admin' => $admin,
            'agama' => $agama
        ]);
    }
    public function save_admin(Request $request)
    {
        // return $request->all();
        $request->validate([
            'email' => 'required|unique:users,email',
            'gender' => 'required|in:P,W',
        ], [
            'email.required' => 'Email Wajib Diisi!',
            'email.unique' => 'Email Tidak Boleh Digunakan Kedua Kali!'
        ]);
        try {
            $data = [
                'email' => $request->input('email'),
                'nama' => $request->input('nama'),
                'password' => Hash::make($request->input('password')),
                'gender' => $request->input('gender'),
                'is_active' => 0,
                'tempat_lahir' => NULL,
                'tgl_lahir' => NULL,
                'pendidikan' => NULL,
                'alamat' => NULL,
                'phone_number' => NULL,
                'jurusan' => NULL,
                'id_agama' => NULL
            ];
            $admin = User::create($data);
            Role_Has_User::create([
                'fk_user' => $admin->id,
                'fk_role' => 1
            ]);
            return redirect()->route('admin.admin')->with('toast_success', 'Data Admin Berhasil Ditambahkan!');
        } catch (\Exception $e) {
            return redirect()->route('admin.admin')->with('toast_error', $e->getMessage());
        }
    }
    public function hapus_admin($id)
    {
        try {
            $admin = User::find($id);
            if ($admin) {
                $role_has_user = Role_Has_User::where('fk_user', $id);
                $role_has_user->delete();
                $admin->delete();
                return redirect()->route('admin.admin')->with('toast_success', 'Data Admin Berhasil Dihapus!');
            }
        } catch (\Exception $e) {
            return redirect()->route('admin.admin')->with('toast_error', $e->getMessage());
        }
    }
    public function ubah_pwd()
    {
        $title = 'Ubah Kata Sandi';
        $admin = User::join('role_has_users', 'users.id', '=', 'role_has_users.fk_user')
            ->join('role', 'role_has_users.fk_role', '=', 'role.id')
            ->where('role_has_users.fk_role', 1)
            ->select('users.*', 'role.role as role_name')
            ->first();
        return view('halaman_admin.beranda.profile.inidex', [
            'title' => $title,
            'admin' => $admin
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
        return redirect()->route('admin.beranda')->with('toast_success', 'Kata Sandi Berhasil Diperbarui');
    }
}

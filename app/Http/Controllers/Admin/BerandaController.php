<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Recruitmen;
use App\Models\User;
use Illuminate\Http\Request;

class BerandaController extends Controller
{
    public function index()
    {
        $title = 'Beranda';
        $admin = User::join('role_has_users', 'users.id', '=', 'role_has_users.fk_user')
            ->join('role', 'role_has_users.fk_role', '=', 'role.id')
            ->where('role_has_users.fk_role', 1)
            ->select('users.*', 'role.role as role_name')
            ->first();
        $count_pelamar = User::join('role_has_users', 'users.id', '=', 'role_has_users.fk_user')
            ->join('role', 'role_has_users.fk_role', '=', 'role.id')
            ->where('role_has_users.fk_role', 2)
            ->select('users.*', 'role.role as role_name')
            ->count();
        $recruitmen = Recruitmen::where('status_approval', 'submitted')->count();
        return view('halaman_admin.beranda.index', [
            'title' => $title,
            'admin' => $admin,
            'count_pelamar' => $count_pelamar,
            'count_recruitmen' => $recruitmen
        ]);
    }
    public function profile()
    {
        $title = 'Profil';
        $admin = User::join('role_has_users', 'users.id', '=', 'role_has_users.fk_user')
            ->join('role', 'role_has_users.fk_role', '=', 'role.id')
            ->where('role_has_users.fk_role', 1)
            ->select('users.*', 'role.role as role_name')
            ->first();

        return view('halaman_admin.beranda.profile.profil', [
            'title' => $title,
            'admin' => $admin,
        ]);
    }
    public function update_profile($id, Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'NIP' => 'required',
        ]);
        try {
            $data = [
                'nama' => $request->input('nama'),
                'NIP' => $request->input('NIP')
            ];
            User::whereId($id)->update($data);
            return redirect()->route('admin.beranda')->with('toast_success', 'Profil Berhasil Diperbarui!');
        } catch (\Exception $e) {
            return redirect()->back()->with('toast_error', $e->getMessage());
        }
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Recruitmen;
use App\Models\User;
use App\Models\Admin\Agama;
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
       // Ambil notifikasi yang belum dibaca
        $recruitmen = Recruitmen::where('status_approval', 'submitted')->count();
        // Retrieve unread notifications only if there are recruitments with 'submitted' status
    $notifications = $recruitmen > 0 ? $admin->unreadNotifications : collect();
        // dd($notifications);
        $count_pelamar = User::join('role_has_users', 'users.id', '=', 'role_has_users.fk_user')
            ->join('role', 'role_has_users.fk_role', '=', 'role.id')
            ->where('role_has_users.fk_role', 2)
            ->select('users.*', 'role.role as role_name')
            ->count();
        return view('halaman_admin.beranda.index', [
            'title' => $title,
            'admin' => $admin,
            'count_pelamar' => $count_pelamar,
            'count_recruitmen' => $recruitmen,
            'notifications' => $notifications
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
    $agama = Agama::all();
        return view('halaman_admin.beranda.profile.profil', [
            'title' => $title,
            'admin' => $admin,
            'agama' => $agama
        ]);
    }
    public function update_profile($id, Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'NIP' => 'required|unique:users,NIP',
            'email' => 'required',
            'agama' => 'required',
        ], [
            'nama.required' => 'Kolom Nama Harap Diisi!',
            'agama.required' => 'Kolom agama harap diisi!',
            'NIP.unique' => 'NIP sudah digunakan oleh orang lain!',
            'email.required' => 'Kolom email harap diisi!',
            'NIP.required' => 'Kolom NIP harap diisi!'
        ]);
        try {
            $agamaInput = $request->input('agama');
            $agama = Agama::find($agamaInput);
            if(!$agama){
                return redirect()->route('admin.profile')->with('toast_error', 'Data Agama tidak ditemukan');
            }
            $data = [
                'nama' => $request->input('nama'),
                'NIP' => $request->input('NIP'),
                'email' => $request->input('email'),
                'tempat_lahir' => NULL,
                'tgl_lahir' => NULL,
                'pendidikan' => NULL,
                'universitas' => NULL,
                'alamat' => NULL,
                'phone_number' => NULL,
                'jurusan' => NULL,
                'id_agama' => $agama->id,
            ];
            User::whereId($id)->update($data);
            return redirect()->route('admin.beranda')->with('success', 'Profil Berhasil Diperbarui!');
        } catch (\Exception $e) {
            return redirect()->back()->with('toast_error', $e->getMessage());
        }
    }
}

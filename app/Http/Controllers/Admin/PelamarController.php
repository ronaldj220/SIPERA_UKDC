<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class PelamarController extends Controller
{
    public function index()
    {
        $title = 'Pelamar';
        $pelamar = User::join('role_has_users', 'users.id', '=', 'role_has_users.fk_user')
            ->where('role_has_users.fk_role', 2)
            ->orderBy('nama', 'asc')
            ->paginate(10);
        $admin = User::join('role_has_users', 'users.id', '=', 'role_has_users.fk_user')
            ->join('role', 'role_has_users.fk_role', '=', 'role.id')
            ->where('role_has_users.fk_role', 1)
            ->select('users.*', 'role.role as role_name')
            ->first();
        return view('halaman_admin.pelamar.index', [
            'title' => $title,
            'pelamar' => $pelamar,
            'admin' => $admin
        ]);
    }
}

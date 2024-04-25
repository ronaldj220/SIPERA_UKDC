<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Role;
use App\Models\User;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index()
    {
        $title = 'Role';
        $role = Role::paginate(20);
        $admin = User::join('role_has_users', 'users.id', '=', 'role_has_users.fk_user')
            ->join('role', 'role_has_users.fk_role', '=', 'role.id')
            ->where('role_has_users.fk_role', 1)
            ->select('users.*', 'role.role as role_name')
            ->first();
        return view('halaman_admin.role.index', [
            'title' => $title,
            'role' => $role,
            'admin' => $admin
        ]);
    }
    public function add_role()
    {
        $title = 'Tambah Role';
        $admin = User::join('role_has_users', 'users.id', '=', 'role_has_users.fk_user')
            ->join('role', 'role_has_users.fk_role', '=', 'role.id')
            ->where('role_has_users.fk_role', 1)
            ->select('users.*', 'role.role as role_name')
            ->first();
        return view('halaman_admin.role.add_role', [
            'title' => $title,
            'admin' => $admin

        ]);
    }
    public function save_role(Request $request)
    {
        $request->validate([
            'role' => 'required|unique:role,role'
        ], [
            'role.required' => 'Role wajib diisi!',
            'role.unique' => 'Role Tidak Boleh Diisi dengan role sebelumnya'
        ]);
        try {
            $data = [
                'role' => $request->input('role')
            ];
            Role::create($data);
            return redirect()->route('admin.role')->with('toast_success', 'Role Berhasil Ditambahkan!');
        } catch (\Exception $e) {
            return redirect()->route('admin.role')->with('toast_error', $e->getMessage());
        }
    }
}

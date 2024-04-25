<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Departemen;
use App\Models\User;
// use Carbon\Carbon;
use Illuminate\Http\Request;

class DepartemenController extends Controller
{
    public function index()
    {
        $title = 'Departemen';
        $departemen = Departemen::paginate(20);
        $admin = User::join('role_has_users', 'users.id', '=', 'role_has_users.fk_user')
            ->join('role', 'role_has_users.fk_role', '=', 'role.id')
            ->where('role_has_users.fk_role', 1)
            ->select('users.*', 'role.role as role_name')
            ->first();
        return view('halaman_admin.departemen.index', [
            'title' => $title,
            'departemen' => $departemen,
            'admin' => $admin
        ]);
    }
    public function add_departemen()
    {

        $title = 'Tambah Departemen';
        $admin = User::join('role_has_users', 'users.id', '=', 'role_has_users.fk_user')
            ->join('role', 'role_has_users.fk_role', '=', 'role.id')
            ->where('role_has_users.fk_role', 1)
            ->select('users.*', 'role.role as role_name')
            ->first();
        return view('halaman_admin.departemen.add_departemen', [
            'title' => $title,
            'admin' => $admin
        ]);
    }
    public function save_departemen(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'departemen' => 'required|unique:departemen,departemen'
        ], [
            'departemen.required' => 'Departemen Wajib Diisi!'
        ]);
        try {
            $data = [
                'departemen' => $request->input('departemen'),
                'PIC' => $request->input('pic')
            ];
            Departemen::create($data);
            return redirect()->route('admin.departemen')->with('toast_success', 'Departemen Berhasil Ditambahkan!');
        } catch (\Exception $e) {
            return redirect()->route('admin.departemen')->with('toast_error', $e->getMessage());
        }
    }
    public function hapus_departemen($id)
    {
        try {
            $departemen = Departemen::find($id);
            if ($departemen) {
                $departemen->delete();
                return redirect()->route('admin.departemen')->with('toast_success', 'Departemen Berhasil Dihapus!');
            }
        } catch (\Exception $e) {
            return redirect()->route('admin.departemen')->with('toast_error', $e->getMessage());
        }
    }
}

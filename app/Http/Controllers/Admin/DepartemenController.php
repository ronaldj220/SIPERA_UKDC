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
        $departemen = Departemen::sortable()->paginate(5);
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
    public function search(Request $request){
         // Get the search query from the 'q' parameter
        $query = $request->input('q');
        
        // Retrieve lowongan based on the search query
        $departemen = Departemen::where('departemen', 'like', '%' . $query . '%')->paginate(5);
        
        // Return the results as JSON
        return response()->json([
            'data' => $departemen->items(),
            'current_page' => $departemen->currentPage(),
            'per_page' => $departemen->perPage(),
            'total' => $departemen->total(),
            'from' => $departemen->firstItem(),
            'to' => $departemen->lastItem(),
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
            'departemen.required' => 'Departemen Wajib Diisi!',
            'departemen.unique' => 'Departemen Sebelum Telah Diisi! Harap Mengisi Departemen yang Berbeda!'
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
    public function deleteDepartemen($id)
    {
        try {
            $departemen = Departemen::find($id);
            if (!$departemen) {
                return response()->json(['message' => 'Departemen tidak ditemukan'], 404);
            }
            $departemen->delete();
            return response()->json(['message' => 'Departemen berhasil dihapus'], 200);
        } catch (\Exception $e) {
            return redirect()->route('admin.departemen')->with('toast_error', $e->getMessage());
        }
    }
    
    public function edit_departemen($id)
    {
        try{
            $departemen = Departemen::find($id);
            $title = 'Edit Departemen';
            $admin = User::join('role_has_users', 'users.id', '=', 'role_has_users.fk_user')
                ->join('role', 'role_has_users.fk_role', '=', 'role.id')
                ->where('role_has_users.fk_role', 1)
                ->select('users.*', 'role.role as role_name')
                ->first();
                
            return view('halaman_admin.departemen.edit_departemen', [
                'title' => $title,
                'admin' => $admin,
                'departemen' => $departemen
            ]);
        } catch (\Exception $e) {
            return redirect()->route('admin.departemen')->with('toast_error', $e->getMessage());
        }
    }
    
    public function update_departemen(Request $request, $id)
    {
        try{
            $departemen = $request->input('departemen');
            $pic = $request->input('pic');
            
            $departemenFindById = Departemen::findOrFail($id);
            
            if (!$departemenFindById) {
                return redirect()->back()->with('toast_error', 'Departemen tidak ditemukan.');
            }
            
            $departemenFindById->update([
                'departemen' => $departemen,
                'PIC' => $pic
            ]);
            
            return redirect()->route('admin.departemen')->with('toast_success', 'Departemen Berhasil Diperbarui!');
        } catch (\Exception $e) {
            return redirect()->route('admin.departemen')->with('toast_error', $e->getMessage());
        }
    }
}

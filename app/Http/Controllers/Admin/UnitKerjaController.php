<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Admin\UnitKerja;
use App\Models\Admin\Departemen;
use Illuminate\Support\Facades\Schema;


class UnitKerjaController extends Controller
{
    public function index(){
        $title = 'Unit Kerja';
        $admin = User::join('role_has_users', 'users.id', '=', 'role_has_users.fk_user')
            ->join('role', 'role_has_users.fk_role', '=', 'role.id')
            ->where('role_has_users.fk_role', 1)
            ->select('users.*', 'role.role as role_name')
            ->first();
        $unitKerja = UnitKerja::sortable()->paginate(5);
        return view('halaman_admin.master_unitKerja.index', [
            'title' => $title,
            'admin' => $admin,
            'unitKerja' => $unitKerja
        ]);
    }
    
    public function search(Request $request){
        // Get the search query from the 'q' parameter
        $query = $request->input('q');
        
        // Retrieve lowongan based on the search query
        $lowongan = UnitKerja::where('nama_unit_kerja', 'like', '%' . $query . '%')->paginate(10);
        
        // Return the results as JSON
        return response()->json($lowongan);
    }
    
    public function addUnitKerja(){
        $title = 'Tambah Unit Kerja';
        $admin = User::join('role_has_users', 'users.id', '=', 'role_has_users.fk_user')
            ->join('role', 'role_has_users.fk_role', '=', 'role.id')
            ->where('role_has_users.fk_role', 1)
            ->select('users.*', 'role.role as role_name')
            ->first();
        $departemen = Departemen::all();
        return view('halaman_admin.master_unitKerja.add_unitKerja', [
            'title' => $title,
            'admin' => $admin,
            'departemen' => $departemen
        ]);
    }
    
    public function saveUnitKerja(Request $request){
        
        $request->validate([
            'nama_unit_kerja' => 'required|unique:unit_kerja,nama_unit_kerja',
            'kode_unit' => 'required|unique:unit_kerja,kode_unit',
            'departemen' => 'required|exists:departemen,id'
        ], [
            // Custom error messages
            'nama_unit_kerja.required' => 'Unit kerja harus diisi.',
            'nama_unit_kerja.unique' => 'Unit kerja sudah ada, gunakan nama lain.',
            'kode_unit.required' => 'Kode unit harus diisi.',
            'kode_unit.unique' => 'Kode unit sudah ada, gunakan kode lain.',
            'departemen.required' => 'Pilih salah satu departemen.',
            'departemen.exists' => 'Departemen yang dipilih tidak valid.'
        ]);
        try{
        
            $idDepartemen = $request->input('departemen');
            $departemenFindById = Departemen::find($idDepartemen);
            if(!$departemenFindById){
                return redirect()->back()->with('toast_error', 'Departemen tidak ditemukan');
            }
        
            UnitKerja::create([
                'nama_unit_kerja' => $request->input('nama_unit_kerja'),    
                'kode_unit' => $request->input('kode_unit'),    
                'id_departemen' => $departemenFindById->id,    
            ]);
            
            return redirect()->route('admin.unitKerja')->with('toast_success', 'Unit Kerja berhasil ditambahkan.');
        } catch(\Exception $e){
            return redirect()->route('admin.unitKerja')->with('toast_error', 'Unit Kerja gagal ditambahkan.');
        }
    }
    
    public function editUnitKerja($id){
        $title = 'Edit Unit Kerja';
        $admin = User::join('role_has_users', 'users.id', '=', 'role_has_users.fk_user')
            ->join('role', 'role_has_users.fk_role', '=', 'role.id')
            ->where('role_has_users.fk_role', 1)
            ->select('users.*', 'role.role as role_name')
            ->first();
        $unitKerja = UnitKerja::find($id);
        $departemen = Departemen::all();

        return view('halaman_admin.master_unitKerja.edit_unitKerja', [
            'title' => $title,
            'admin' => $admin,
            'unitKerja' => $unitKerja,
            'departemen' => $departemen
        ]);
    }
    
    public function updateUnitKerja(Request $request, $id){
        try{
            $idDepartemen = $request->input('departemen');
            $departemenFindById = Departemen::find($idDepartemen);
            if(!$departemenFindById){
                return redirect()->back()->with('toast_error', 'Departemen tidak ditemukan');
            }
            
            $unitKerja = UnitKerja::findOrFail($id);
            
            $unitKerja->update([
                'nama_unit_kerja' => $request->input('nama_unit_kerja'),    
                'kode_unit' => $request->input('kode_unit'),    
                'id_departemen' => $departemenFindById->id,    
            ]);
            
            return redirect()->route('admin.unitKerja')->with('toast_success', 'Unit Kerja Berhasil Diperbarui!');
        } catch(\Exception $e){
            return redirect()->route('admin.unitKerja')->with('toast_error', 'Unit Kerja gagal ditambahkan.');
        }
    }
    
    public function deleteUnitKerja($id){
        try {
            $lowongan = UnitKerja::find($id); // Cari data berdasarkan ID
            if (!$lowongan) {
                return response()->json(['message' => 'Data tidak ditemukan'], 404);
            }
            $lowongan->delete();
            return response()->json(['message' => 'Unit Kerja berhasil dihapus'], 200);
        } catch (\Exception $e) {
            return redirect()->route('admin.unitKerja')->with('error', 'Gagal menghapus lowongan: ' . $e->getMessage());
        }
    }
}

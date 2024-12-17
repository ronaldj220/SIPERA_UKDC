<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Admin\Kegiatan;


class KegiatanController extends Controller
{
    public function index(){
        $title = 'Kegiatan';
        $kegiatan = Kegiatan::sortable()->paginate(5);
        $admin = User::join('role_has_users', 'users.id', '=', 'role_has_users.fk_user')
            ->join('role', 'role_has_users.fk_role', '=', 'role.id')
            ->where('role_has_users.fk_role', 1)
            ->select('users.*', 'role.role as role_name')
            ->first();
        return view('halaman_admin.master_kegiatan.index', [
            'title' => $title,
            'admin' => $admin,
            'kegiatan' => $kegiatan
        ]);
    }
    
    public function search(Request $request){
        // Get the search query from the 'q' parameter
        $query = $request->input('q');
        
        // Retrieve lowongan based on the search query
        $lowongan = Kegiatan::where('kegiatan', 'like', '%' . $query . '%')->paginate(5);
        
        // Return the results as JSON
        return response()->json($lowongan);
    }
    
    public function add_kegiatan(){
        $title = 'Tambah Kegiatan';
        $admin = User::join('role_has_users', 'users.id', '=', 'role_has_users.fk_user')
            ->join('role', 'role_has_users.fk_role', '=', 'role.id')
            ->where('role_has_users.fk_role', 1)
            ->select('users.*', 'role.role as role_name')
            ->first();
        
        return view('halaman_admin.master_kegiatan.add_kegiatan', [
            'title' => $title,
            'admin' => $admin
        ]);
    }
    
    public function save_kegiatan(Request $request){
        $request->validate([
            'kegiatan' => 'required|unique:master_kegiatan,kegiatan',    
        ], [
            'kegiatan.required' => 'Kegiatan untuk pemanggilan tes harap diisi!',
            'kegiatan.unique' => 'Kegiatan sudah dipakai! Silahkan ajukan kegiatan yang berbeda!'
        ]);
        
        $inputKegiatan = $request->input('kegiatan');
        
        Kegiatan::create([
            'kegiatan' => $inputKegiatan    
        ]);
        
        return redirect()->route('admin.kegiatan')->with('toast_success', 'Kegiatan Berhasil Ditambahkan!');
    }
    
    public function edit_kegiatan($id){
        $title = 'Edit Lowongan';
        $admin = User::join('role_has_users', 'users.id', '=', 'role_has_users.fk_user')
            ->join('role', 'role_has_users.fk_role', '=', 'role.id')
            ->where('role_has_users.fk_role', 1)
            ->select('users.*', 'role.role as role_name')
            ->first();
        $lowongan = Kegiatan::find($id);
        
        return view('halaman_admin.master_kegiatan.edit_kegiatan', [
            'title' => $title,
            'admin' => $admin,
            'kegiatan' => $lowongan
        ]);
    }
    
    public function update_kegiatan(Request $request, $id){
        try{
            $kegiatanInput = $request->input('kegiatan');
            
            $kegiatanFindById = Kegiatan::findOrFail($id);
            
            if (!$kegiatanFindById) {
                return redirect()->back()->with('toast_error', 'Kegiatan tidak ditemukan.');
            }
            
            $kegiatanFindById->update([
                'kegiatan' => $kegiatanInput,
            ]);
            
            return redirect()->route('admin.kegiatan')->with('toast_success', 'Kegiatan Berhasil Diperbarui!');
        } catch (\Exception $e) {
            return redirect()->route('admin.kegiatan')->with('toast_error', $e->getMessage());
        }
    }
}

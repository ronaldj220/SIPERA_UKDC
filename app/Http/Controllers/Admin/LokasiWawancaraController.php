<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Admin\LokasiWawancara;

class LokasiWawancaraController extends Controller
{
    public function index(){
        $title = 'Lokasi Wawancara';
        $admin = User::join('role_has_users', 'users.id', '=', 'role_has_users.fk_user')
            ->join('role', 'role_has_users.fk_role', '=', 'role.id')
            ->where('role_has_users.fk_role', 1)
            ->select('users.*', 'role.role as role_name')
            ->first();
        $lokasiWawancara = LokasiWawancara::sortable()->paginate(5);
        
        return view('halaman_admin.lokasi_wawancara.index', [
            'title' => $title,
            'admin' => $admin,
            'lokasiWawancara' => $lokasiWawancara
        ]);
    }
    
    public function add_lokasi_wawancara(){
        $title = 'Tambah Lokasi Wawancara';
        $admin = User::join('role_has_users', 'users.id', '=', 'role_has_users.fk_user')
            ->join('role', 'role_has_users.fk_role', '=', 'role.id')
            ->where('role_has_users.fk_role', 1)
            ->select('users.*', 'role.role as role_name')
            ->first();
        
        return view('halaman_admin.lokasi_wawancara.add_lokasi_wawancara', [
            'title' => $title,
            'admin' => $admin,
        ]);
    }
    
    public function save_lokasi_wawancara(Request $request){
        $request->validate([
            'ruangan_wawancara' => 'required',    
            'lokasi_wawancara' => 'required', 
        ], [
            'ruangan_wawancara.required' => 'Ruangan Wawancara Harap Diisi!',
            'lokasi_wawancara.required' => 'Lokasi Wawancara Harap Diisi!'
        ]);
        
        try{
            LokasiWawancara::create([
                'ruangan' => $request->input('ruangan_wawancara'),
                'lokasi' => $request->input('lokasi_wawancara')
            ]);
            return redirect()->route('admin.lokasiWawancara')->with('toast_success', 'Lokasi Wawancara Berhasil Ditambahkan!');
        } catch (\Exception $e) {
            return redirect()->route('admin.lokasiWawancara')->with('toast_error', $e->getMessage());
        }
    }
    
    public function edit_lokasi_wawancara($id){
        $title = 'Edit Lokasi Wawancara';
        $admin = User::join('role_has_users', 'users.id', '=', 'role_has_users.fk_user')
            ->join('role', 'role_has_users.fk_role', '=', 'role.id')
            ->where('role_has_users.fk_role', 1)
            ->select('users.*', 'role.role as role_name')
            ->first();
        $lokasiWawancara = LokasiWawancara::find($id);
        
        return view('halaman_admin.lokasi_wawancara.edit_lokasi_wawancara', [
            'title' => $title,
            'admin' => $admin,
            'lokasiWawancara' => $lokasiWawancara
        ]);
    }
    
    public function update_lokasi_wawancara($id, Request $request){
        try{
            $lokasiWawancara = LokasiWawancara::findOrFail($id);
            
            if(!$lokasiWawancara){
                return redirect()->back()->with('toast_error', 'Lokasi Wawancara tidak ditemukan.');
            }
            
            $lokasiWawancara->update([
                'ruangan' => $request->input('ruangan_wawancara'),
                'lokasi' => $request->input('lokasi_wawancara'),
            ]);
            
            return redirect()->route('admin.lokasiWawancara')->with('toast_success', 'Lokasi Wawancara Berhasil Diperbarui!');
        } catch (\Exception $e) {
            return redirect()->route('admin.lokasiWawancara')->with('toast_error', $e->getMessage());
        }
    }
}

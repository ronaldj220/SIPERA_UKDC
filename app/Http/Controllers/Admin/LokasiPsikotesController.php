<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Admin\LokasiPsikotes;

class LokasiPsikotesController extends Controller
{
    public function index()
    {
        $admin = User::join('role_has_users', 'users.id', '=', 'role_has_users.fk_user')
            ->join('role', 'role_has_users.fk_role', '=', 'role.id')
            ->where('role_has_users.fk_role', 1)
            ->select('users.*', 'role.role as role_name')
            ->first();
        $title = 'Lokasi Psikotes';
        $locPsikotes = LokasiPsikotes::all();
        
        return view('halaman_admin.lokasi_psikotes.index', [
            'title' => $title,
            'admin' => $admin,
            'locPsikotes' => $locPsikotes
        ]);
    }
    
    public function add_lokasi_psikotes()
    {
        $title = 'Tambah Lokasi Psikotes';
        $admin = User::join('role_has_users', 'users.id', '=', 'role_has_users.fk_user')
            ->join('role', 'role_has_users.fk_role', '=', 'role.id')
            ->where('role_has_users.fk_role', 1)
            ->select('users.*', 'role.role as role_name')
            ->first();
        
        return view('halaman_admin.lokasi_psikotes.add_lokasi_psikotes', [
            'title' => $title,
            'admin' => $admin
        ]);
    }
    
    public function save_lokasi_psikotes(Request $request)
    {
        $request->validate([
            'lokasi_psikotes' => 'required',    
            'ruangan_psikotes' => 'required', 
            'alamat_psikotes' => 'required'    
        ]);
        
        LokasiPsikotes::create([
            'lokasi_psikotes' => $request->input('lokasi_psikotes'),    
            'ruangan_psikotes' => $request->input('ruangan_psikotes'),    
            'alamat_psikotes' => $request->input('alamat_psikotes'),    
        ]);
        return redirect()->route('admin.lokasi_psikotes')->with('toast_success', 'Lokasi Psikotes Berhasil Ditambahkan!');
    }
    
    public function edit_lokasi_psikotes($id)
    {
        $title = 'Edit Lokasi Psikotes';
        $admin = User::join('role_has_users', 'users.id', '=', 'role_has_users.fk_user')
            ->join('role', 'role_has_users.fk_role', '=', 'role.id')
            ->where('role_has_users.fk_role', 1)
            ->select('users.*', 'role.role as role_name')
            ->first();
        $lokasiPsikotes = LokasiPsikotes::find($id);
        
        return view('halaman_admin.lokasi_psikotes.edit_lokasi_psikotes', [
            'title' => $title,
            'admin' => $admin,
            'lokasiPsikotes' => $lokasiPsikotes
        ]);
    }
    
    public function update_lokasi_psikotes(Request $request, $id)
    {
        $lokasiPsikotes = LokasiPsikotes::findOrFail($id);
        
        if (!$lowongan) {
            return redirect()->back()->with('error', 'Lokasi Psikotes tidak ditemukan.');
        }
        
        $lokasiPsikotes->update([
            'lokasi_psikotes' => $request->input('lokasi_psikotes'),    
            'ruangan_psikotes' => $request->input('ruangan_psikotes'),    
            'alamat_psikotes' => $request->input('alamat_psikotes'),    
        ]);
        
        return redirect()->route('admin.lokasi_psikotes')->with('toast_success', 'Lokasi Psikotes Berhasil Diperbarui!');
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Admin\StatusPegawai;
use App\Rules\Admin\UniqueStatusPegawai;


class StatusPegawaiController extends Controller
{
    public function index(){
        $title = 'Status Pegawai';
        $admin = User::join('role_has_users', 'users.id', '=', 'role_has_users.fk_user')
            ->join('role', 'role_has_users.fk_role', '=', 'role.id')
            ->where('role_has_users.fk_role', 1)
            ->select('users.*', 'role.role as role_name')
            ->first();
        $statusPegawai = StatusPegawai::sortable()->paginate(5);
        
        return view('halaman_admin.master_statusPegawai.index', [
            'title' => $title,
            'admin' => $admin,
            'statusPegawai' => $statusPegawai
        ]);
    }
    
    public function addStatusPegawai(){
        $title = 'Tambah Status Pegawai';
        $admin = User::join('role_has_users', 'users.id', '=', 'role_has_users.fk_user')
            ->join('role', 'role_has_users.fk_role', '=', 'role.id')
            ->where('role_has_users.fk_role', 1)
            ->select('users.*', 'role.role as role_name')
            ->first();
            
        return view('halaman_admin.master_statusPegawai.add_statusPegawai', [
            'title' => $title,
            'admin' => $admin
        ]);
    }
    
    public function saveStatusPegawai(Request $request){
        $request->validate([
            'status_pegawai' => [
                'required',
                'string',
                'min:5',
                'max:100',
                'regex:/^[A-Z][a-zA-Z\s]*$/',
                new UniqueStatusPegawai($request->input('status_pegawai'))
            ]    
        ], [
            // Custom error messages
            'status_pegawai.required' => 'Status pegawai wajib diisi.',
            'status_pegawai.string' => 'Status pegawai harus berupa teks.',
            'status_pegawai.max' => 'Status pegawai tidak boleh lebih dari 100 karakter.',
            'status_pegawai.min' => 'Status pegawai harus minimal 5 karakter.',
            'status_pegawai.regex' => 'Status pegawai harus dimulai dengan huruf kapital dan hanya boleh berisi huruf serta spasi.'
        ]);
        
        try{
            StatusPegawai::create([
                'nama_status' => $request->input('status_pegawai')    
            ]);
            
            return redirect()->route('admin.statusPegawai')->with('toast_success', 'Status Pegawai berhasil ditambahkan.');
        } catch(\Exception $e){
            return redirect()->route('admin.statusPegawai')->with('toast_error', 'Status Pegawai gagal ditambahkan.');
        }
    }
    
    public function editStatusPegawai($id){
        $title = 'Status Pegawai';
        $admin = User::join('role_has_users', 'users.id', '=', 'role_has_users.fk_user')
            ->join('role', 'role_has_users.fk_role', '=', 'role.id')
            ->where('role_has_users.fk_role', 1)
            ->select('users.*', 'role.role as role_name')
            ->first();
            
        $statusPegawai = StatusPegawai::find($id);
        
        return view('halaman_admin.master_statusPegawai.edit_statusPegawai', [
            'title' => $title,
            'admin' => $admin,
            'statusPegawai' => $statusPegawai
        ]);
    }
    
    public function updateStatusPegawai(Request $request, $id){
        try{
            $statusPegawai = StatusPegawai::findOrFail($id);
            
            $statusPegawai->update([
                'nama_status' => $request->input('status_pegawai')
            ]);
            
            return redirect()->route('admin.statusPegawai')->with('toast_success', 'Status Pegawai berhasil diperbarui.');
        } catch(\Exception $e){
            return redirect()->route('admin.statusPegawai')->with('toast_error', 'Status Pegawai gagal ditambahkan.');
        }
    }
}

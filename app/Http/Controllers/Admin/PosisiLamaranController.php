<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\PosisiLamaran;
use App\Models\Admin\UnitKerja;
use App\Models\Admin\StatusPegawai;
use App\Models\User;

class PosisiLamaranController extends Controller
{
    public function index(){
        $title = 'Posisi Lamaran';
        $posisiLamaran = PosisiLamaran::sortable()->paginate(5);
        $admin = User::join('role_has_users', 'users.id', '=', 'role_has_users.fk_user')
            ->join('role', 'role_has_users.fk_role', '=', 'role.id')
            ->where('role_has_users.fk_role', 1)
            ->select('users.*', 'role.role as role_name')
            ->first();
        
        return view('halaman_admin.posisi_lamaran.index', [
            'title' => $title,
            'pos_lamaran' => $posisiLamaran,
            'admin' => $admin
        ]);
    }
    
    public function add_pos_lamaran()
    {
        $title = 'Tambah Posisi Lamaran';
        $admin = User::join('role_has_users', 'users.id', '=', 'role_has_users.fk_user')
            ->join('role', 'role_has_users.fk_role', '=', 'role.id')
            ->where('role_has_users.fk_role', 1)
            ->select('users.*', 'role.role as role_name')
            ->first();
        return view('halaman_admin.posisi_lamaran.add_posisi_lamaran', [
            'title' => $title,
            'admin' => $admin
        ]);
        
    }
    
    public function save_pos_lamaran(Request $request)
    {
        $request->validate([
            'pos_lamaran' => 'required|min:3|max:100|unique:posisi_lamaran,id',
            'tanggal_awal' => 'required|date',
            'tanggal_akhir' => 'required|date',
        ]);
        
         // Validasi tambahan untuk memastikan tanggal_akhir lebih besar dari tanggal_awal
        if (strtotime($request->input('tanggal_akhir')) <= strtotime($request->input('tanggal_awal'))) {
            return redirect()->back()->withErrors(['tanggal_akhir' => 'Tanggal Akhir harus lebih besar dari Tanggal Awal.'])->withInput();
        }
        
        $tanggalAwal = $request->input('tanggal_awal');
        $tanggalAkhir = $request->input('tanggal_akhir');
        
        // Hitung selisih dalam bulan
        $datetimeAwal = new \DateTime($tanggalAwal);
        $datetimeAkhir = new \DateTime($tanggalAkhir);
        $interval = $datetimeAwal->diff($datetimeAkhir);
        
        // Hitung total bulan dari selisih
        $lamaMasaPercobaan = ($interval->y * 12) + $interval->m;
        
        PosisiLamaran::create([
            'posisi' => $request->input('pos_lamaran'),    
            'unit_kerja' => $request->input('unit_kerja'),
            'status_pegawai' => $request->input('status_pegawai'),
            'masa_percobaan_awal' => $request->input('tanggal_awal'),    
            'masa_percobaan_akhir' => $request->input('tanggal_akhir'),
            'lama_masa_percobaan' => $lamaMasaPercobaan,
        ]);
         return redirect()->route('admin.pos_lamaran')->with('toast_success', 'Posisi Lamaran Berhasil Ditambahkan!');
    }
    
    public function edit_pos_lamaran($id)
    {
        $title = 'Edit Posisi Lamaran';
        $admin = User::join('role_has_users', 'users.id', '=', 'role_has_users.fk_user')
            ->join('role', 'role_has_users.fk_role', '=', 'role.id')
            ->where('role_has_users.fk_role', 1)
            ->select('users.*', 'role.role as role_name')
            ->first();
        $posisiLamaran = PosisiLamaran::find($id);
        $unitKerja = UnitKerja::all();
        $statusPegawai = StatusPegawai::all();
        
        return view('halaman_admin.posisi_lamaran.edit_posisi_lamaran', [
            'title' => $title,
            'admin' => $admin,
            'posisiLamaran' => $posisiLamaran,
            'unitKerja' => $unitKerja,
            'statusPegawai' => $statusPegawai
        ]);
    }
    
    public function update_posisi_lamaran(Request $request, $id)
    {
        // Cari posisi lamaran berdasarkan ID
        $posisiLamaran = PosisiLamaran::findOrFail($id);
        if (!$posisiLamaran) {
            return redirect()->back()->with('error', 'Posisi Lamaran tidak ditemukan.');
        }
        
        $tanggalAwal = $request->input('tanggal_awal');
        $tanggalAkhir = $request->input('tanggal_akhir');
        
        // Hitung selisih dalam bulan
        $datetimeAwal = new \DateTime($tanggalAwal);
        $datetimeAkhir = new \DateTime($tanggalAkhir);
        $interval = $datetimeAwal->diff($datetimeAkhir);
        
        // Hitung total bulan dari selisih
        $lamaMasaPercobaan = ($interval->y * 12) + $interval->m;
        
        // Update
        $posisiLamaran->update([
            'posisi' => $request->input('pos_lamaran'),    
            'unit_kerja' => $request->input('unit_kerja'),    
            'status_pegawai' => $request->input('status_pegawai'),    
            'masa_percobaan_awal' => $request->input('tanggal_awal'),    
            'masa_percobaan_akhir' => $request->input('tanggal_akhir'),    
            'lama_masa_percobaan' => $lamaMasaPercobaan,    
        ]);
        
        return redirect()->route('admin.pos_lamaran')->with('toast_success', 'Posisi Lamaran Berhasil Diperbarui!');
    }
}

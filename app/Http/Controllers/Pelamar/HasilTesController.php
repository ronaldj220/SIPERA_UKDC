<?php

namespace App\Http\Controllers\Pelamar;

use App\Http\Controllers\Controller;
use App\Models\Admin\Surat_Penerimaan;
use App\Models\Recruitmen;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use SebastianBergmann\CodeUnit\FunctionUnit;

class HasilTesController extends Controller
{
    public function index()
    {
        $title = 'Surat Penerimaan';
        $karyawanLogin = Auth::user()->nama;
        $karyawan = User::join('role_has_users', 'users.id', '=', 'role_has_users.fk_user')
            ->join('role', 'role_has_users.fk_role', '=', 'role.id')
            ->where('role_has_users.fk_role', 2)
            ->select('users.*', 'role.role as role_name', 'role_has_users.fk_role as role')
            ->first();
        $rekrutmen = Recruitmen::where('pemohon', $karyawanLogin)->first();
        // dd($rekrutmen);
        if ($rekrutmen) {
            if ($rekrutmen->status_approval == 'submitted') {
                return redirect()->back()->with('error', 'Mohon menunggu persetujuan!');
            } elseif ($rekrutmen->status_approval == 'rejected') {
                return redirect()->back()->with('error', 'Maaf, pengajuan Anda ditolak. Silakan periksa dan perbaiki informasinya jika perlu!');
            } elseif ($rekrutmen->status_approval == 'pending') {
                return redirect()->back()->with('warning', 'Pengajuan sedang dalam proses peninjauan!');
            }
        } else {
            return redirect()->back()->with('warning', 'Silahkan Isi Pengajuan Lamaran!');
        }
        $hasil_tes = Surat_Penerimaan::whereHas('rekrutmen', function ($query) use ($karyawanLogin) {
            $query->where('pemohon', $karyawanLogin);
        })->get();
        return view('halaman_karyawan.hasil_tes.index', [
            'title' => $title,
            'karyawan' => $karyawan,
            'hasil_tes' => $hasil_tes
        ]);
    }
    public function view_surat_penerimaan($id)
    {
        $title  = 'Lihat Surat Penerimaan';
        $admin = User::join('role_has_users', 'users.id', '=', 'role_has_users.fk_user')
            ->join('role', 'role_has_users.fk_role', '=', 'role.id')
            ->where('role_has_users.fk_role', 1)
            ->select('users.*', 'role.role as role_name')
            ->first();
        $karyawan = User::join('role_has_users', 'users.id', '=', 'role_has_users.fk_user')
            ->join('role', 'role_has_users.fk_role', '=', 'role.id')
            ->where('role_has_users.fk_role', 2)
            ->select('users.*', 'role.role as role_name', 'role_has_users.fk_role as role')
            ->first();
        $karyawanLogin = Auth::user()->nama;
        $hasil_tes = Surat_Penerimaan::whereHas('rekrutmen', function ($query) use ($karyawanLogin) {
            $query->where('pemohon', $karyawanLogin);
        })->find($id);
        $tgl_pengajuan = Carbon::createFromFormat('Y-m-d', $hasil_tes->tgl_pengajuan)->locale('id');
        $formattedDate = $tgl_pengajuan->isoFormat('DD MMMM YYYY');
        $tgl_hadir = Carbon::createFromFormat('Y-m-d', $hasil_tes->tgl_kerja)->locale('id');
        $formattedDate_hadir = $tgl_hadir->isoFormat('DD MMMM YYYY');
        $tgl_lahir = Carbon::createFromFormat('Y-m-d', $hasil_tes->tgl_lahir)->locale('id');
        $formattedDate_lahir = $tgl_lahir->isoFormat('DD MMMM YYYY');
        $tgl_kerja = Carbon::createFromFormat('Y-m-d', $hasil_tes->tgl_kerja)->locale('id');
        $formattedDate_kerja = $tgl_kerja->isoFormat('DD MMMM YYYY');

        return view('halaman_karyawan.hasil_tes.view_surat_penerimaan', [
            'title' => $title,
            'karyawan' => $karyawan,
            'admin' => $admin,
            'hasil_tes' => $hasil_tes,
            'tgl_pengajuan' => $formattedDate,
            'tgl_hadir' => $formattedDate_hadir,
            'tgl_lahir' => $formattedDate_lahir,
            'tgl_kerja' => $formattedDate_kerja,
        ]);
    }
}

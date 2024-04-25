<?php

namespace App\Http\Controllers\Pelamar;

use App\Http\Controllers\Controller;
use App\Models\Admin\Psikotes;
use App\Models\Recruitmen;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PsikotesController extends Controller
{
    public function index()
    {
        $title = 'Psikotes';
        $karyawan = User::join('role_has_users', 'users.id', '=', 'role_has_users.fk_user')
            ->join('role', 'role_has_users.fk_role', '=', 'role.id')
            ->where('role_has_users.fk_role', 2)
            ->select('users.*', 'role.role as role_name', 'role_has_users.fk_role as role')
            ->first();
        $karyawanLogin = Auth::user()->nama;
        $rekrutmen = Recruitmen::where('pemohon', $karyawanLogin)->first();
        // dd($rekrutmen);
        if ($rekrutmen) {
            if ($rekrutmen->status_approval == 'submitted') {
                return redirect()->back()->with('error', 'Mohon menunggu persetujuan!');
            } elseif ($rekrutmen->status_approval == 'rejected') {
                return redirect()->back()->with('error', 'Maaf, pengajuan Anda ditolak. Silakan periksa email Anda!');
            } elseif ($rekrutmen->status_approval == 'pending') {
                return redirect()->back()->with('warning', 'Pengajuan sedang dalam proses peninjauan!');
            }
        } else {
            return redirect()->back()->with('warning', 'Silahkan Isi Pengajuan Lamaran!');
        }

        $psikotes = Psikotes::whereHas('rekrutmen', function ($query) use ($karyawanLogin) {
            $query->where('pemohon', $karyawanLogin);
        })->get();
        return view('halaman_karyawan.psikotes.index', [
            'title' => $title,
            'karyawan' => $karyawan,
            'psikotes' => $psikotes
        ]);
    }
    public function view_psikotes($id)
    {
        $title = 'Lihat Dokumen Psikotes';
        $karyawan = User::join('role_has_users', 'users.id', '=', 'role_has_users.fk_user')
            ->join('role', 'role_has_users.fk_role', '=', 'role.id')
            ->where('role_has_users.fk_role', 2)
            ->select('users.*', 'role.role as role_name', 'role_has_users.fk_role as role')
            ->first();
        $admin = User::join('role_has_users', 'users.id', '=', 'role_has_users.fk_user')
            ->join('role', 'role_has_users.fk_role', '=', 'role.id')
            ->where('role_has_users.fk_role', 1)
            ->select('users.*', 'role.role as role_name')
            ->first();
        $karyawanLogin = Auth::user()->nama;
        $psikotes = Psikotes::whereHas('rekrutmen', function ($query) use ($karyawanLogin) {
            $query->where('pemohon', $karyawanLogin);
        })->find($id);

        $tgl_pengajuan = Carbon::createFromFormat('Y-m-d', $psikotes->tgl_pengajuan)->locale('id');
        $formattedDate = $tgl_pengajuan->isoFormat('DD MMMM YYYY');

        $tgl_hadir = Carbon::createFromFormat('Y-m-d', $psikotes->tgl_hadir)->locale('id');
        $formattedDate_hadir = $tgl_hadir->isoFormat('DD MMMM YYYY');

        return view('halaman_karyawan.psikotes.view_psikotes', [
            'title' => $title,
            'karyawan' => $karyawan,
            'admin' => $admin,
            'psikotes' => $psikotes,
            'tgl_pengajuan' => $formattedDate,
            'tgl_hadir' => $formattedDate_hadir
        ]);
    }
}

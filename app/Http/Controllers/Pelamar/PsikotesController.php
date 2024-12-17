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

    // Ambil data rekrutmen berdasarkan pengguna yang login
    $rekrutmen = Recruitmen::whereHas('user', function ($query) use ($karyawanLogin) {
        $query->where('nama', $karyawanLogin);
    })->first();

    if (!$rekrutmen) {
        return redirect()->back()->with('warning', 'Silahkan Isi Pengajuan Lamaran!');
    }

    // Cek status approval
    if ($rekrutmen->status_approval == 'submitted') {
        return redirect()->back()->with('error', 'Mohon menunggu persetujuan!');
    } elseif ($rekrutmen->status_approval == 'rejected') {
        return redirect()->back()->with('error', 'Maaf, pengajuan Anda ditolak. Silakan periksa email Anda!');
    } elseif ($rekrutmen->status_approval == 'pending') {
        return redirect()->back()->with('warning', 'Pengajuan sedang dalam proses peninjauan!');
    }

    // Ambil data psikotes berdasarkan rekrutmen karyawan yang login
    $psikotes = Psikotes::where('id_rekrutmen', $rekrutmen->id)->get();

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
        $karyawanLogin = Auth::user()->id;
        $psikotes = Psikotes::with(['rekrutmen.user', 'lokasiPsikotes'])
        ->whereHas('rekrutmen', function ($query) use ($karyawanLogin) {
            $query->where('id_users', $karyawanLogin);
        })
        ->find($id);

        // Pastikan $psikotes tidak null
        if (!$psikotes) {
            return redirect()->back()->with('toast_error', 'Dokumen Psikotes tidak ditemukan.');
        }

        $tgl_pengajuan = Carbon::createFromFormat('Y-m-d', $psikotes->tgl_pengajuan)->locale('id');
        $formattedDate = $tgl_pengajuan->isoFormat('DD MMMM YYYY');

        $tgl_hadir = Carbon::createFromFormat('Y-m-d', $psikotes->tgl_hadir)->locale('id');
        $formattedDate_hadir = $tgl_hadir->isoFormat('DD MMMM YYYY');
        
        $formattedDatePsikotes = Carbon::createFromFormat('Y-m-d', $psikotes->tgl_hadir)->locale('id');
        $formatDateHadir = $formattedDatePsikotes->isoFormat('dddd');

        $pemohon = $psikotes->rekrutmen->user->nama;
        
        $jamHadir = Carbon::createFromFormat('H:i:s', $psikotes->jam_hadir)->format('H:i') . ' WIB';
        
        $lokasiPsikotes = $psikotes->lokasiPsikotes->lokasi_psikotes;
        $alamatPsikotes = $psikotes->lokasiPsikotes->alamat_psikotes;
        $ruanganPsikotes = $psikotes->lokasiPsikotes->ruangan_psikotes;
        
        // mPdf
        
        $mpdf = new \Mpdf\Mpdf();
        $mpdf->SetHeader('<img src="'. public_path('Header 2.png') .'"/>');
        $mpdf->WriteHTML(view('halaman_karyawan.psikotes.view_psikotes', [
            'title' => $title,
            'karyawan' => $karyawan,
            'admin' => $admin,
            'psikotes' => $psikotes,
            'tgl_pengajuan' => $formattedDate,
            'hari_hadir' => $formatDateHadir,
            'tgl_hadir' => $formattedDate_hadir,
            'jam_hadir' => $jamHadir,
            'lokasi_psikotes' => $lokasiPsikotes,
            'alamat_psikotes' => $alamatPsikotes,
            'ruangan_psikotes' => $ruanganPsikotes,
            'pemohon' => $pemohon
        ]));
        $mpdf->Output();
    }
}

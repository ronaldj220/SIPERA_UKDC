<?php

namespace App\Http\Controllers\Pelamar;

use App\Http\Controllers\Controller;
use App\Models\Admin\Surat_Penerimaan;
use App\Models\Admin\PosisiLamaran;
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
        // dd($rekrutmen);
        if ($rekrutmen) {
            if ($rekrutmen->status_approval == 'submitted') {
                return redirect()->back()->with('error', 'Mohon menunggu persetujuan!');
            } elseif ($rekrutmen->status_approval == 'rejected') {
                return redirect()->back()->with('error', 'Maaf, pengajuan Anda ditolak!');
            } elseif ($rekrutmen->status_approval == 'pending') {
                return redirect()->back()->with('warning', 'Pengajuan sedang dalam proses peninjauan!');
            }
        } else {
            return redirect()->back()->with('warning', 'Silahkan Isi Pengajuan Lamaran!');
        }
        $karyawanLoginId = Auth::user()->id;
        $hasil_tes = Surat_Penerimaan::where('rekrutmen_id', $rekrutmen->id)->get();
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
        $karyawanLoginId = Auth::user()->id;
        
        // Ambil data surat penerimaan yang terkait dengan pelamar yang login
        $hasilTes = Surat_Penerimaan::whereHas('rekrutmen', function ($query) use ($karyawanLoginId) {
            $query->where('id_users', $karyawanLoginId); // Sesuaikan dengan kolom user_id di rekrutmen
        })->where('id', $id)->find($id);
        
        // Pemohon
        $pemohon = $hasilTes->rekrutmen->user->nama;
        
        // Tempat Lahir
        $tempatLahir = $hasilTes->rekrutmen->user->tempat_lahir;
        $tempatLahir = preg_replace('/^(Kota|Kabupaten)\s+/', '', $tempatLahir);
        
        // Tanggal Lahir
        $tanggalLahir = $hasilTes->rekrutmen->user->tgl_lahir;
        $dateLahir = Carbon::createFromFormat('Y-m-d', $tanggalLahir)->locale('id');
        $formattedDateLahir = $dateLahir->isoFormat('DD MMMM YYYY');
        
        // Tanggal Pengajuan
        $datePengajuan = Carbon::createFromFormat('Y-m-d', $hasilTes->tgl_pengajuan)->locale('id');
        $formattedDatePengajuan = $datePengajuan->isoFormat('DD MMMM YYYY');
        
        // Unit Kerja
        $unitKerja = $hasilTes->PosisiLamaran->unit_kerja;
        
        // Lowongan yang diajukan
        $lowongan = $hasilTes->rekrutmen->lowongan->name_lowongan;
        
        // Status Pegawai
        $statusPegawai = strtolower($hasilTes->PosisiLamaran->status_pegawai);
        
        // Masa Percobaan Awal
        $masaPercobaanAwal = $hasilTes->PosisiLamaran->masa_percobaan_awal;
        $dateMasaPercobaanAwal = Carbon::createFromFormat('Y-m-d', $masaPercobaanAwal)->locale('id');
        $formattedMasaPercobaanAwal = $dateMasaPercobaanAwal->isoFormat('DD MMMM YYYY');
        
        // Masa Percobaan Akhir
        $masaPercobaanAkhir = $hasilTes->PosisiLamaran->masa_percobaan_akhir;
        $dateMasaPercobaanAkhir = Carbon::createFromFormat('Y-m-d', $masaPercobaanAkhir)->locale('id');
        $formattedMasaPercobaanAkhir = $dateMasaPercobaanAkhir->isoFormat('DD MMMM YYYY');
        
        // Hitung selisih bulan
        $diffInMonths = $dateMasaPercobaanAwal->diffInMonths($dateMasaPercobaanAkhir);
        
        // Tambahkan informasi jika kurang dari 12 bulan
        $lamaPosisiLamaran = $diffInMonths < 12 ? "{$diffInMonths} bulan" : "lebih dari 12 bulan";
        
        $mpdf= new \Mpdf\Mpdf();
        $mpdf->SetHeader('<img src="'. public_path('Header 2.png') .'"/>');
        
        $mpdf->WriteHTML(view('halaman_karyawan.hasil_tes.view_surat_penerimaan', [
            'title' => $title,
            'admin' => $admin,
            'karyawan' => $karyawan,
            'hasil_tes' => $hasilTes,
            'tgl_pengajuan' => $formattedDatePengajuan,
            'tgl_lahir' => $formattedDateLahir,
            'tgl_kerja' => $formattedMasaPercobaanAwal,
            'unitKerja' => $unitKerja,
            'statusPegawai' => $statusPegawai,
            'lamaPosisiLamaran' => $lamaPosisiLamaran,
            'pemohon' => $pemohon,
            'tempat_lahir' => $tempatLahir,
            'lowongan' => $lowongan
        ]));
        
        $mpdf->Output();
    }
}

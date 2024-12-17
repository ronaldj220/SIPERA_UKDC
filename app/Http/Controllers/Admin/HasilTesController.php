<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Psikotes;
use App\Models\Admin\PosisiLamaran;
use App\Models\Admin\Surat_Penerimaan;
use App\Models\Recruitmen;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\Admin\ExportHasilTes as ExportHasilTes;

class HasilTesController extends Controller
{
    public function index()
    {
        $title = 'Hasil Tes';
        $admin = User::join('role_has_users', 'users.id', '=', 'role_has_users.fk_user')
            ->join('role', 'role_has_users.fk_role', '=', 'role.id')
            ->where('role_has_users.fk_role', 1)
            ->select('users.*', 'role.role as role_name')
            ->first();
        $hasil_tes = Surat_Penerimaan::with(['rekrutmen.user'])
            ->sortable()
            ->orderByRaw("FIELD(status_approval, 'pending') DESC") // Prioritaskan yang 'submitted'
            ->orderByRaw("FIELD(status_approval, 'approved') DESC") // Urutkan yang 'approved' setelah 'submitted'
            ->paginate(5);
        return view('halaman_admin.hasil_tes.index', [
            'title' => $title,
            'admin' => $admin,
            'hasil_tes' => $hasil_tes,
        ]);
    }
    public function export_hasil_tes(){
        return Excel::download(new ExportHasilTes, 'hasil_tes.xlsx');
    }
    
    public function add_surat_penerimaan()
    {
        $title = 'Tambah Hasil Tes';
        $admin = User::join('role_has_users', 'users.id', '=', 'role_has_users.fk_user')
            ->join('role', 'role_has_users.fk_role', '=', 'role.id')
            ->where('role_has_users.fk_role', 1)
            ->select('users.*', 'role.role as role_name')
            ->first();
        $pemohon = Recruitmen::with('user')->get();
        $no_doku = $this->new_no_doku();
        $posisiLamaran = PosisiLamaran::all();
        return view('halaman_admin.hasil_tes.add_surat_penerimaan', [
            'title' => $title,
            'admin' => $admin,
            'pemohon' => $pemohon,
            'posisi_lamaran' => $posisiLamaran,
            'no_doku' => $no_doku
        ]);
    }
    public function new_no_doku()
    {
        $AWAL = 'UKDC';
        $AWAL_2 = 'BAU.01';
        $bulanRomawi = array("", "I", "II", "III", "IV", "V", "VI", "VII", "VIII", "IX", "X", "XI", "XII");
        $noUrutAkhir = DB::table('surat_penerimaan')->whereMonth('tgl_pengajuan', '=', date('m'))->count();
        $currentMonth = date('n');
        $no_dokumen = null;
        $no = 1;
        if (date('j') == 1) { // Cek jika tanggal saat ini adalah tanggal 1
            if ($noUrutAkhir) {
                $no_dokumen = sprintf("%03s", abs($noUrutAkhir + 1)) . '/' . $AWAL . '/' . $AWAL_2 . '/' . $bulanRomawi[$currentMonth] . '/' . date('Y');
            } else {
                $no_dokumen = sprintf("%03s", abs($no)) . '/' . $AWAL . '/' . $AWAL_2 . '/' . $bulanRomawi[$currentMonth] . '/' . date('Y');
            }
        } else {
            if ($noUrutAkhir) {
                $no_dokumen = sprintf("%03s", abs($noUrutAkhir + 1)) .  '/' . $AWAL . '/' . $AWAL_2 . '/' . $bulanRomawi[$currentMonth] . '/' . date('Y');
            } else {
                $no_dokumen = sprintf("%03s", abs($no)) . '/' . $AWAL . '/' . $AWAL_2 . '/' . $bulanRomawi[$currentMonth] . '/' . date('Y');
            }
        }
        return $no_dokumen;
    }
    public function save_surat_penerimaan(Request $request)
    {
        try {
            // Get the approved rekrutmen entry without using first()
            $rekrutmen = Recruitmen::where('status_approval', 'approved')->orderBy('created_at', 'desc')->limit(1)->get();
            if ($rekrutmen->isEmpty()) {
                return redirect()->back()->with('toast_error', 'Rekrutmen dengan status disetujui tidak ditemukan.');
            }
        
            $rekrutmenId = $rekrutmen->first()->id;
            
            $dataPenerimaan = [
                'no_doku' => $request->input('no_doku'),
                'tgl_pengajuan' => $request->input('tgl_ajukan'),
                'tgl_kerja' => NULL,
                'rekrutmen_id' => $rekrutmenId,
                'id_posisi_lamaran' => $request->input('id_posisi_lamaran'),
                'status_approval' => 'pending',
                'tgl_kirim' => NULL,
                'jumlah_kirim' => 0
            ];
            Surat_Penerimaan::create($dataPenerimaan);
            return redirect()->route('admin.hasil_tes')->with('toast_success', 'Surat Penerimaan Berhasil Ditambahkan!');
        } catch (\Exception $e) {
            return redirect()->route('admin.hasil_tes')->with('toast_error', $e->getMessage());
        }
    }
    
    public function view_surat_penerimaan($id)
    {
        $title = 'Lihat Surat Penerimaan';
        $admin = User::join('role_has_users', 'users.id', '=', 'role_has_users.fk_user')
            ->join('role', 'role_has_users.fk_role', '=', 'role.id')
            ->where('role_has_users.fk_role', 1)
            ->select('users.*', 'role.role as role_name')
            ->first();
        
        $hasilTes = Surat_Penerimaan::find($id);
        
        $user = $hasilTes->rekrutmen->user;
        
        // Cek kelengkapan data profil pelamar
        if (empty($user->nama) || empty($user->tgl_lahir) || empty($user->tempat_lahir)) {
            return redirect()->back()->with('toast_error', 'Profil pelamar belum lengkap. Mohon lengkapi data profil untuk melanjutkan.');
        }
        
        // Tanggal Pengajuan
        $datePengajuan = Carbon::createFromFormat('Y-m-d', $hasilTes->tgl_pengajuan)->locale('id');
        $formattedDatePengajuan = $datePengajuan->isoFormat('DD MMMM YYYY');
        
        // Tempat Lahir
        $tempatLahir = $hasilTes->rekrutmen->user->tempat_lahir;
        $tempatLahir = preg_replace('/^(Kota|Kabupaten)\s+/', '', $tempatLahir);
        
        // Pemohon
        $pemohon = $hasilTes->rekrutmen->user->nama;
        
        // Tanggal Lahir
        $tanggalLahir = $hasilTes->rekrutmen->user->tgl_lahir;
        $dateLahir = Carbon::createFromFormat('Y-m-d', $tanggalLahir)->locale('id');
        $formattedDateLahir = $dateLahir->isoFormat('DD MMMM YYYY');
        
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
        $mpdf->WriteHTML(view('halaman_admin.hasil_tes.view_surat_penerimaan', [
            'title' => $title,
            'admin' => $admin,
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
    public function acc_surat_penerimaan($id)
    {
        try {
            $data = DB::table('surat_penerimaan')->where('id', $id)->first();
            DB::table('surat_penerimaan')->where('id', $id)->update([
                'status_approval' => 'approved',
            ]);
            $no_doku = $data->no_doku;
            return redirect()->route('admin.hasil_tes')->with('toast_success', 'Data dengan no dokumen ' . $no_doku . ' berhasil disetujui!');
        } catch (\Exception $e) {
            return redirect()->route('admin.hasil_tes')->with('toast_error', $e->getMessage());
        }
    }
    public function tolak_surat_penerimaan($id)
    {
        try {
            $data = DB::table('surat_penerimaan')->where('id', $id)->first();
            DB::table('surat_penerimaan')->where('id', $id)->update([
                'status_approval' => 'rejected',
            ]);
            $no_doku = $data->no_doku;
            return redirect()->route('admin.hasil_tes')->with('toast_error', 'Data dengan no dokumen ' . $no_doku . ' ditolak!');
        } catch (\Exception $e) {
            return redirect()->route('admin.hasil_tes')->with('toast_error', $e->getMessage());
        }
    }
    public function kirim_surat_penerimaan($id)
    {
        try {
            $hasilTes = Surat_Penerimaan::with(['rekrutmen.user', 'PosisiLamaran', 'rekrutmen.lowongan'])->find($id);
            if (!$hasilTes) {
                return redirect()->route('admin.hasil_tes')->with('toast_error', 'Data Surat Penerimaan tidak ditemukan!');
            }
            if($hasilTes->jumlah_kirim >= 3){
                return redirect()->route('admin.hasil_tes')->with('toast_error', 'Email sudah dikirim lebih dari 3 kali. Pengiriman dibatasi.');
            }
            // Ganti 'email' dengan nama view email yang sesuai
            $view = 'halaman_admin/hasil_tes/email';
            // Ambil nama dan email pelamar
            $namaPelamar = $hasilTes->rekrutmen->user->nama;
            $emailPelamar = $hasilTes->rekrutmen->user->email;
            $statusPelamar = $hasilTes->status_approval;
            $unitKerja = strtolower($hasilTes->PosisiLamaran->status_pegawai);
            // dd($unitKerja);
            // Update DB mengenai Tanggal Kirim dan Jumlah Kirim
            $hasilTes->update([
                'jumlah_kirim' => $hasilTes->jumlah_kirim + 1,
                'tgl_kirim' => Carbon::now()
            ]);
            Mail::send($view, ['namaPelamar' => $namaPelamar, 'statusPelamar' => $statusPelamar, 'unitKerja' => $unitKerja], function ($message) use ($emailPelamar) {
                $message->to($emailPelamar);
                $message->subject("Pemberitahuan Hasil");
            });
            
            return redirect()->route('admin.hasil_tes')->with('toast_success', 'Pemberitahuan bahwa pelamar telah menerima email/undangan dari UKDC.');
        } catch (\Exception $e) {
            return redirect()->route('admin.hasil_tes')->with('toast_error', $e->getMessage());
        }
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Psikotes;
use App\Models\Admin\Surat_Penerimaan;
use App\Models\Recruitmen;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

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
        $hasil_tes = Surat_Penerimaan::all();
        return view('halaman_admin.hasil_tes.index', [
            'title' => $title,
            'admin' => $admin,
            'hasil_tes' => $hasil_tes,
        ]);
    }
    public function add_surat_penerimaan()
    {
        $title = 'Tambah Hasil Tes';
        $admin = User::join('role_has_users', 'users.id', '=', 'role_has_users.fk_user')
            ->join('role', 'role_has_users.fk_role', '=', 'role.id')
            ->where('role_has_users.fk_role', 1)
            ->select('users.*', 'role.role as role_name')
            ->first();
        $pemohon = Recruitmen::where('status_approval', 'approved')->get();
        $no_doku = $this->new_no_doku();
        return view('halaman_admin.hasil_tes.add_surat_penerimaan', [
            'title' => $title,
            'admin' => $admin,
            'pemohon' => $pemohon,
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
                $no_dokumen = sprintf("%03s", abs($noUrutAkhir + 1)) .  '/' . $AWAL . '/' . $AWAL_2 . '/' . '/' . $AWAL . '/' . $bulanRomawi[$currentMonth] . '/' . date('Y');
            } else {
                $no_dokumen = sprintf("%03s", abs($no)) . '/' . $AWAL . '/' . $AWAL_2 . '/' . $bulanRomawi[$currentMonth] . '/' . date('Y');
            }
        }
        return $no_dokumen;
    }
    public function save_surat_penerimaan(Request $request)
    {
        $request->validate([
            'tgl_kerja' => 'required'
        ], [
            'tgl_kerja.required' => 'Tanggal Kerja Harap Diisi!'
        ]);
        try {
            $rekrutmen = Recruitmen::where('status_approval', 'approved')->first();
            if ($rekrutmen) {
                $dataPenerimaan = [
                    'no_doku' => $request->input('no_doku'),
                    'tgl_pengajuan' => $request->input('tgl_ajukan'), // Sesuaikan dengan kebutuhan
                    'tempat_lahir' => $request->input('tempat_lahir'), // Sesuaikan dengan kebutuhan
                    'tgl_lahir' => $request->input('tgl_lahir'), // Sesuaikan dengan kebutuhan
                    'alamat' => $request->input('alamat'), // Sesuaikan dengan kebutuhan
                    'tgl_kerja' => $request->input('tgl_kerja'), // Sesuaikan dengan kebutuhan
                    'rekrutmen_id' => $rekrutmen->id, // Sesuaikan dengan kebutuhan
                    'status_approval' => 'pending'
                ];
                // Simpan Psikotes ke dalam database melalui relasi
                $psikotes = $rekrutmen->surat_penerimaan()->create($dataPenerimaan);
                return redirect()->route('admin.hasil_tes')->with('toast_success', 'Surat Penerimaan Berhasil Ditambahkan!');
            }
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
        $hasil_tes = Surat_Penerimaan::with('rekrutmen')->find($id);
        $tgl_pengajuan = Carbon::createFromFormat('Y-m-d', $hasil_tes->tgl_pengajuan)->locale('id');
        $formattedDate = $tgl_pengajuan->isoFormat('DD MMMM YYYY');
        $tgl_hadir = Carbon::createFromFormat('Y-m-d', $hasil_tes->tgl_kerja)->locale('id');
        $formattedDate_hadir = $tgl_hadir->isoFormat('DD MMMM YYYY');
        $tgl_lahir = Carbon::createFromFormat('Y-m-d', $hasil_tes->tgl_lahir)->locale('id');
        $formattedDate_lahir = $tgl_lahir->isoFormat('DD MMMM YYYY');
        $tgl_kerja = Carbon::createFromFormat('Y-m-d', $hasil_tes->tgl_kerja)->locale('id');
        $formattedDate_kerja = $tgl_kerja->isoFormat('DD MMMM YYYY');


        return view('halaman_admin.hasil_tes.view_surat_penerimaan', [
            'title' => $title,
            'admin' => $admin,
            'hasil_tes' => $hasil_tes,
            'tgl_pengajuan' => $formattedDate,
            'tgl_hadir' => $formattedDate_hadir,
            'tgl_lahir' => $formattedDate_lahir,
            'tgl_kerja' => $formattedDate_kerja,
        ]);
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
    public function kirim_surat_penerimaan($id)
    {
        try {
            $psikotes = Surat_Penerimaan::with('rekrutmen')->find($id);
            if (!$psikotes) {
                return redirect()->route('admin.hasil_tes')->with('toast_error', 'Data Surat Penerimaan tidak ditemukan!');
            }
            // Ganti 'email' dengan nama view email yang sesuai
            $view = 'halaman_admin/hasil_tes/email';
            // Ambil nama dan email pelamar
            $namaPelamar = $psikotes->rekrutmen->pemohon;
            $emailPelamar = $psikotes->rekrutmen->email_pemohon;
            $jabatanPelamar = $psikotes->rekrutmen->jabatan_pelamar;
            $statusPelamar = $psikotes->status_approval;
            Mail::send($view, ['namaPelamar' => $namaPelamar, 'statusPelamar' => $statusPelamar, 'jabatanPelamar' => $jabatanPelamar], function ($message) use ($emailPelamar) {
                $message->to($emailPelamar);
                $message->subject("Pemberitahuan Hasil");
            });
            return redirect()->route('admin.hasil_tes')->with('toast_success', 'Email berhasil dikirim.');
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
}

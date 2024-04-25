<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Psikotes;
use App\Models\Recruitmen;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class PsikotesController extends Controller
{
    public function index()
    {
        $title = 'Psikotes';
        $admin = User::join('role_has_users', 'users.id', '=', 'role_has_users.fk_user')
            ->join('role', 'role_has_users.fk_role', '=', 'role.id')
            ->where('role_has_users.fk_role', 1)
            ->select('users.*', 'role.role as role_name')
            ->first();
        $psikotes = Psikotes::all();

        return view('halaman_admin.psikotes.index', [
            'title' => $title,
            'admin' => $admin,
            'psikotes' => $psikotes
        ]);
    }
    public function tambah_psikotes()
    {
        $title = 'Tambah Data Psikotes';
        $admin = User::join('role_has_users', 'users.id', '=', 'role_has_users.fk_user')
            ->join('role', 'role_has_users.fk_role', '=', 'role.id')
            ->where('role_has_users.fk_role', 1)
            ->select('users.*', 'role.role as role_name')
            ->first();
        $no_doku = $this->new_no_doku();
        $pemohon = Recruitmen::all();
        return view('halaman_admin.psikotes.add_psikotes', [
            'title' => $title,
            'admin' => $admin,
            'no_doku' => $no_doku,
            'pemohon' => $pemohon
        ]);
    }
    public function new_no_doku()
    {
        $AWAL = 'UKDC';
        $AWAL_2 = 'BAU.01';
        $bulanRomawi = array("", "I", "II", "III", "IV", "V", "VI", "VII", "VIII", "IX", "X", "XI", "XII");
        $noUrutAkhir = DB::table('psikotes')->whereMonth('tgl_pengajuan', '=', date('m'))->count();
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
    public function save_psikotes(Request $request)
    {
        $request->validate([
            'lokasi_hadir' => 'required'
        ], [
            'lokasi_hadir.required' => 'Lokasi Psikotes Harap Diisi!'
        ]);
        try {
            $rekrutmen = Recruitmen::where('status_approval', 'approved')->first();
            if ($rekrutmen) {
                $dataPsikotes = [
                    'no_doku_psikotes' => $request->input('no_doku_psikotes'),
                    'no_doku_rektor' => $request->input('no_doku_rektor'),
                    'id_rekrutmen' => $rekrutmen->id,
                    'tempat_pengajuan' => 'Surabaya',
                    'tgl_pengajuan' => $request->input('tgl_ajukan'),
                    'tgl_hadir' => $request->input('tgl_hadir'),
                    'jam_hadir' => $request->input('jam_hadir'),
                    'lokasi_hadir' => $request->input('lokasi_hadir'),
                    'status_approval' => 'pending'
                ];
                $psikotes = $rekrutmen->psikotes()->create($dataPsikotes);
                return redirect()->route('admin.psikotes')->with('toast_success', 'Surat Psikotes Berhasil Ditambahkan!');
            }
        } catch (\Exception $e) {
            return redirect()->route('admin.psikotes')->with('toast_error', $e->getMessage());
        }
    }
    public function view_psikotes($id)
    {
        $title = 'Lihat Dokumen Psikotes';
        $admin = User::join('role_has_users', 'users.id', '=', 'role_has_users.fk_user')
            ->join('role', 'role_has_users.fk_role', '=', 'role.id')
            ->where('role_has_users.fk_role', 1)
            ->select('users.*', 'role.role as role_name')
            ->first();
        $psikotes = Psikotes::find($id);
        $tgl_pengajuan = Carbon::createFromFormat('Y-m-d', $psikotes->tgl_pengajuan)->locale('id');
        $formattedDate = $tgl_pengajuan->isoFormat('DD MMMM YYYY');

        $tgl_hadir = Carbon::createFromFormat('Y-m-d', $psikotes->tgl_hadir)->locale('id');
        $formattedDate_hadir = $tgl_hadir->isoFormat('DD MMMM YYYY');

        return view('halaman_admin.psikotes.view_psikotes', [
            'title' => $title,
            'admin' => $admin,
            'psikotes' => $psikotes,
            'tgl_pengajuan' => $formattedDate,
            'tgl_hadir' => $formattedDate_hadir,
        ]);
    }
    public function acc_psikotes($id)
    {
        try {
            $data = DB::table('psikotes')->where('id', $id)->first();
            DB::table('psikotes')->where('id', $id)->update([
                'status_approval' => 'approved',
            ]);
            $no_doku = $data->no_doku_psikotes;
            return redirect()->route('admin.psikotes')->with('toast_success', 'Data dengan no dokumen ' . $no_doku . ' berhasil disetujui!');
        } catch (\Exception $e) {
            return redirect()->route('admin.psikotes')->with('toast_error', $e->getMessage());
        }
    }
    public function send_psikotes($id)
    {
        try {
            $psikotes = Psikotes::find($id);
            if (!$psikotes) {
                return redirect()->route('admin.psikotes')->with('toast_error', 'Data Psikotes tidak ditemukan!');
            }
            // Ganti 'email' dengan nama view email yang sesuai
            $view = 'halaman_admin/psikotes/email';
            // Ambil nama dan email pelamar
            $namaPelamar = $psikotes->rekrutmen->pemohon;
            $emailPelamar = $psikotes->rekrutmen->email_pemohon;
            $statusPelamar = $psikotes->status_approval;
            Mail::send($view, ['namaPelamar' => $namaPelamar, 'statusPelamar' => $statusPelamar], function ($message) use ($emailPelamar) {
                $message->to($emailPelamar);
                $message->subject("Pemberitahuan Hasil Psikotes");
            });
            return redirect()->route('admin.psikotes')->with('toast_success', 'Email berhasil dikirim.');
        } catch (\Exception $e) {
            return redirect()->route('admin.psikotes')->with('toast_error', $e->getMessage());
        }
    }
}

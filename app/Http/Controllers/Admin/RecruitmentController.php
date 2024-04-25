<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Recruitmen;
use App\Models\User;

use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;

class RecruitmentController extends Controller
{
    public function index()
    {
        $title = 'Rekrutmen';
        $recruitmen = Recruitmen::all();
        $admin = User::join('role_has_users', 'users.id', '=', 'role_has_users.fk_user')
            ->join('role', 'role_has_users.fk_role', '=', 'role.id')
            ->where('role_has_users.fk_role', 1)
            ->select('users.*', 'role.role as role_name')
            ->first();
        return view('halaman_admin.recruitmen.index', [
            'title' => $title,
            'recruitmen' => $recruitmen,
            'admin' => $admin
        ]);
    }
    public function view_recruitmen($id)
    {
        $recruitmen = Recruitmen::first();
        if ($recruitmen->status_approval == 'submitted') {
            $recruitmentData = Recruitmen::first(); // Sesuaikan dengan kondisi query Anda
            if (!$recruitmentData) {
                // Handle jika data tidak ditemukan
                abort(404);
            }
            $cvFileName = $recruitmentData->CV;
            $cvFilePath = public_path('CV PDF/' . $cvFileName);
            return response()->file($cvFilePath);
        } elseif ($recruitmen->status_approval == 'pending') {
            if ($recruitmen->is_edited == 'true') {
                return redirect()->back()->with('toast_error', 'Silahkan Edit Tanggal Hadir dan Jam Hadir Terlebih Dahulu!');
            }
            $title = 'Lihat Dokumen';
            $admin = User::join('role_has_users', 'users.id', '=', 'role_has_users.fk_user')
                ->join('role', 'role_has_users.fk_role', '=', 'role.id')
                ->where('role_has_users.fk_role', 1)
                ->select('users.*', 'role.role as role_name')
                ->first();
            $recruitmen = Recruitmen::find($id);
            $data_rekrutmen = Recruitmen::where('id', $id)->get();
            $arrayData = json_decode($data_rekrutmen, true);

            // Ambil nilai "jam_hadir" dari setiap elemen
            $jamHadirArray = [];
            $jamSelesaiArray = [];
            $kegiatanArray = [];
            foreach ($arrayData as $data) {
                foreach ($data['jam_hadir'] as $jamHadir) {
                    $jamHadirArray[] = $jamHadir['jam_hadir'];
                }
                foreach ($data['jam_selesai'] as $jamHadir) {
                    $jamSelesaiArray[] = $jamHadir['jam_selesai'];
                }
                foreach ($data['kegiatan'] as $jamHadir) {
                    $kegiatanArray[] = $jamHadir['kegiatan'];
                }
            }

            $tgl_hadir = Carbon::createFromFormat('Y-m-d', $recruitmen->tgl_hadir)->locale('id');
            $formattedDate = $tgl_hadir->isoFormat('DD MMMM YYYY');

            // tanggal pengajuan
            $tgl_pengajuan = Carbon::createFromFormat('Y-m-d', $recruitmen->tgl_pengajuan)->locale('id');
            $formattedDate_ajuan = $tgl_pengajuan->isoFormat('DD MMMM YYYY');


            return view('halaman_admin.recruitmen.view_recruitmen', [
                'title' => $title,
                'admin' => $admin,
                'recruitmen' => $recruitmen,
                'jamHadirArray' => $jamHadirArray,
                'jamSelesaiArray' => $jamSelesaiArray,
                'kegiatanArray' => $kegiatanArray,
                'tgl_hadir' => $formattedDate,
                'tgl_pengajuan' => $formattedDate_ajuan,
            ]);
        } elseif ($recruitmen->status_approval == 'approved') {
            $title = 'Lihat Dokumen';
            $admin = User::join('role_has_users', 'users.id', '=', 'role_has_users.fk_user')
                ->join('role', 'role_has_users.fk_role', '=', 'role.id')
                ->where('role_has_users.fk_role', 1)
                ->select('users.*', 'role.role as role_name')
                ->first();
            $recruitmen = Recruitmen::find($id);
            $data_rekrutmen = Recruitmen::where('id', $id)->get();
            $arrayData = json_decode($data_rekrutmen, true);

            // Ambil nilai "jam_hadir" dari setiap elemen
            $jamHadirArray = [];
            $jamSelesaiArray = [];
            $kegiatanArray = [];
            foreach ($arrayData as $data) {
                foreach ($data['jam_hadir'] as $jamHadir) {
                    $jamHadirArray[] = $jamHadir['jam_hadir'];
                }
                foreach ($data['jam_selesai'] as $jamHadir) {
                    $jamSelesaiArray[] = $jamHadir['jam_selesai'];
                }
                foreach ($data['kegiatan'] as $jamHadir) {
                    $kegiatanArray[] = $jamHadir['kegiatan'];
                }
            }

            $tgl_hadir = Carbon::createFromFormat('Y-m-d', $recruitmen->tgl_hadir)->locale('id');
            $formattedDate = $tgl_hadir->isoFormat('DD MMMM YYYY');

            // tanggal pengajuan
            $tgl_pengajuan = Carbon::createFromFormat('Y-m-d', $recruitmen->tgl_pengajuan)->locale('id');
            $formattedDate_ajuan = $tgl_pengajuan->isoFormat('DD MMMM YYYY');

            return view('halaman_admin.recruitmen.view_recruitmen', [
                'title' => $title,
                'admin' => $admin,
                'recruitmen' => $recruitmen,
                'jamHadirArray' => $jamHadirArray,
                'jamSelesaiArray' => $jamSelesaiArray,
                'kegiatanArray' => $kegiatanArray,
                'tgl_hadir' => $formattedDate,
                'tgl_pengajuan' => $formattedDate_ajuan,
            ]);
        }
    }
    public function verify_doc($id)
    {
        try {
            $data = DB::table('recruitmen')->where('id', $id)->first();
            if ($data->status_approval == 'submitted') {
                DB::table('recruitmen')->where('id', $id)->update([
                    'status_approval' => 'pending',
                    'is_edited' => 'true'
                ]);
                $no_doku = $data->no_doku;
                return redirect()->route('admin.recruitmen')->with('toast_success', 'Data dengan no dokumen ' . $no_doku . ' berhasil diverifikasi!');
            } elseif ($data->status_approval == 'pending') {
                DB::table('recruitmen')->where('id', $id)->update([
                    'status_approval' => 'approved'
                ]);
                $no_doku = $data->no_doku;
                return redirect()->route('admin.recruitmen')->with('toast_success', 'Data dengan no dokumen ' . $no_doku . ' berhasil disetujui!');
            }
        } catch (\Exception $e) {
            return redirect()->route('admin.recruitmen')->with('toast_error', $e->getMessage());
        }
    }
    public function reject_doc($id)
    {
        try {
            $data = DB::table('recruitmen')->where('id', $id)->first();
            if ($data->status_approval == 'submitted') {
                DB::table('recruitmen')->where('id', $id)->update([
                    'status_approval' => 'rejected',
                ]);
                $no_doku = $data->no_doku;
                return redirect()->route('admin.recruitmen')->with('toast_success', 'Data dengan no dokumen ' . $no_doku . ' ditolak! Silahkan mengajukan lowongan lainnya!');
            }
        } catch (\Exception $e) {
            return redirect()->route('admin.recruitmen')->with('toast_error', $e->getMessage());
        }
    }
    public function edit_doc($id)
    {
        $title = 'Edit Dokumen Rekrutmen';
        $admin = User::join('role_has_users', 'users.id', '=', 'role_has_users.fk_user')
            ->join('role', 'role_has_users.fk_role', '=', 'role.id')
            ->where('role_has_users.fk_role', 1)
            ->select('users.*', 'role.role as role_name')
            ->first();
        $recruitmen = Recruitmen::find($id);

        return view('halaman_admin.recruitmen.edit_rekrutmen', [
            'title' => $title,
            'admin' => $admin,
            'recruitmen' => $recruitmen
        ]);
    }
    public function update_doc($id, Request $request)
    {
        try {
            $data_rekrutmen = DB::table('recruitmen')->where('id', $id)->first();
            // Ambil data dari request
            $jamHadirArray = $request->input('jam_hadir');
            $jamSelesaiArray = $request->input('jam_selesai');
            $kegiatanArray = $request->input('kegiatan');

            // Pastikan panjang array-nya sama
            if (count($jamHadirArray) === count($jamSelesaiArray) && count($jamSelesaiArray) === count($kegiatanArray)) {
                $data = [];

                // Loop untuk setiap entri
                for ($i = 0; $i < count($jamHadirArray); $i++) {
                    $data[] = [
                        'jam_hadir' => $jamHadirArray[$i],
                        'jam_selesai' => $jamSelesaiArray[$i],
                        'kegiatan' => $kegiatanArray[$i],
                    ];
                }

                // Ubah array menjadi JSON
                $jsonData = json_encode($data);

                Recruitmen::where('id', $id)->update([
                    'tgl_hadir' => $request->input('tgl_hadir'),
                    'jam_hadir' => $jsonData,
                    'jam_selesai' => $jsonData,
                    'kegiatan' => $jsonData,
                    'is_edited' => 'false'
                ]);
                $no_doku = $data_rekrutmen->no_doku;
                return redirect()->route('admin.recruitmen')->with('toast_success', 'Data dengan no dokumen ' . $no_doku . ' berhasil diperbarui!');
            } else {
                return redirect()->route('admin.recruitmen')->with('toast_error', 'Jumlah Data yang dimasukkan tidak sesuai!');
            }

            // dd($request->all());
        } catch (\Exception $e) {
            return redirect()->route('admin.recruitmen')->with('toast_error', $e->getMessage());
        }
    }
    public function send_doc($id)
    {
        try {
            // Ambil data rekrutmen berdasarkan ID
            $recruitmen = DB::table('recruitmen')->find($id);

            if (!$recruitmen) {
                return redirect()->route('admin.recruitmen')->with('toast_error', 'Data rekrutmen tidak ditemukan.');
            }

            // Ganti 'email' dengan nama view email yang sesuai
            $view = 'halaman_admin/email';

            // Ambil nama dan email pelamar
            $namaPelamar = $recruitmen->pemohon;
            $emailPelamar = $recruitmen->email_pemohon;
            $statusPelamar = $recruitmen->status_approval;

            // Kirim email
            Mail::send($view, ['namaPelamar' => $namaPelamar, 'statusPelamar' => $statusPelamar], function ($message) use ($emailPelamar) {
                $message->to($emailPelamar);
                $message->subject("Dokumen Penerimaan");
            });

            // Redirect dengan pesan sukses jika email berhasil dikirim
            return redirect()->route('admin.recruitmen')->with('toast_success', 'Email berhasil dikirim.');
        } catch (\Exception $e) {
            // Redirect dengan pesan error jika terjadi exception
            return redirect()->route('admin.recruitmen')->with('toast_error', $e->getMessage());
        }
    }
}

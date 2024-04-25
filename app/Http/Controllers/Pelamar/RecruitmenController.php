<?php

namespace App\Http\Controllers\Pelamar;

use App\Http\Controllers\Controller;
use App\Models\Admin\Departemen;
use App\Models\Recruitmen;
use App\Models\User;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RecruitmenController extends Controller
{
    public function index()
    {
        $title = 'Recruitmen';
        $karyawan = User::join('role_has_users', 'users.id', '=', 'role_has_users.fk_user')
            ->join('role', 'role_has_users.fk_role', '=', 'role.id')
            ->where('role_has_users.fk_role', 2)
            ->select('users.*', 'role.role as role_name', 'role_has_users.fk_role as role')
            ->first();
        $karyawanLogin = Auth::user()->nama;
        $recruitmen = Recruitmen::where('pemohon', $karyawanLogin)->get();

        return view('halaman_karyawan.recruitmen.index', [
            'title' => $title,
            'karyawan' => $karyawan,
            'recruitmen' => $recruitmen
        ]);
    }
    public function add_recruitmen()
    {
        $karyawanLogin = Auth::user()->nama;
        // $recruitmen = Recruitmen::where('pemohon', $karyawanLogin)->first();

        // if ($recruitmen->status_approval == 'rejected') {
        //     return redirect()->back()->with('toast_error', 'Tidak dapat menambahkan data pelamar karena status approval sudah ditolak!');
        // }

        $title = 'Tambah Data Recruitmen';
        $karyawan = User::join('role_has_users', 'users.id', '=', 'role_has_users.fk_user')
            ->join('role', 'role_has_users.fk_role', '=', 'role.id')
            ->where('role_has_users.fk_role', 2)
            ->select('users.*', 'role.role as role_name', 'role_has_users.fk_role as role')
            ->first();
        $no_doku = $this->new_no_doku();
        $departemen = Departemen::all();
        return view('halaman_karyawan.recruitmen.add_recruitmen', [
            'title' => $title,
            'karyawan' => $karyawan,
            'no_doku' => $no_doku,
            'departemen' => $departemen
        ]);
    }
    public function new_no_doku()
    {
        $AWAL = 'UKDC';
        $AWAL_2 = 'BAU.01';
        $bulanRomawi = array("", "I", "II", "III", "IV", "V", "VI", "VII", "VIII", "IX", "X", "XI", "XII");
        $noUrutAkhir = DB::table('recruitmen')->whereMonth('tgl_pengajuan', '=', date('m'))->count();
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
    public function getPiC(Request $request)
    {
        $departemen = $request->input('nama_departemen');
        $details = Departemen::all();
        if ($details->count() > 0) {

            foreach ($details as $detail) {
                $PIC[] = $detail->PIC;
            }

            $data = [
                'keterangan' => $PIC,
            ];

            // Mengirim data ke tampilan sebagai respons JSON
            return response()->json($data);
        } else {
            // Jika data tidak ditemukan, mengirim respons JSON dengan data kosong
            return response()->json([]);
        }
    }
    public function save_recruitmen(Request $request)
    {
        // Buat upload file PDF di sebuah folder yang bernama CV PDF
        if ($request->hasFile('file')) {
            $filenameWithExt = $request->file('file')->getClientOriginalName();

            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('file')->getClientOriginalExtension();

            $fileNameToStore = $filename . '-' . time() . '.' . $extension;

            $path = $request->file('file')->move(public_path('CV PDF'), $fileNameToStore);
        } else {
            $fileNameToStore = 'noimage.jpg';
        }
        $tanggal = DateTime::createFromFormat('d/m/Y', $request->tgl_ajukan);
        $tgl_diajukan = $tanggal->format('Y-m-d');
        $recruiter = new Recruitmen();
        $recruiter->no_doku = $request->input('no_doku');
        $recruiter->email_pemohon = $request->input('email_pemohon');
        $recruiter->tgl_pengajuan = $tgl_diajukan;
        $recruiter->pemohon = $request->input('pemohon');
        $recruiter->jabatan_pelamar = $request->input('nama_lamaran');
        $recruiter->departemen = $request->input('nama_departemen');
        $recruiter->PiC = $request->input('pic');
        $recruiter->CV = $fileNameToStore;

        $recruiter->save();
        return redirect()->route('karyawan.recruitmen')->with('toast_success', 'Data Pelamar Berhasil Ditambahkan');
    }
    public function view_doc($id)
    {
        try {
            $data = DB::table('recruitmen')->where('id', $id)->first();
            if ($data->status_approval == 'submitted') {
                $karyawanLogin = auth()->user()->nama; // Ganti dengan cara Anda mendapatkan data karyawan yang login

                $recruitmentData = Recruitmen::where('pemohon', $karyawanLogin)->first(); // Sesuaikan dengan kondisi query Anda
                if (!$recruitmentData) {
                    // Handle jika data tidak ditemukan
                    abort(404);
                }
                $cvFileName = $recruitmentData->CV;
                $cvFilePath = public_path('CV PDF/' . $cvFileName);
                return response()->file($cvFilePath);
            } elseif ($data->status_approval == 'approved') {
                $title = 'Lihat Dokumen';
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
                $recruitmen = Recruitmen::where('pemohon', $karyawanLogin)->find($id);
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
                return view('halaman_karyawan.recruitmen.view_recruitmen', [
                    'title' => $title,
                    'karyawan' => $karyawan,
                    'admin' => $admin,
                    'recruitmen' => $recruitmen,
                    'jamHadirArray' => $jamHadirArray,
                    'jamSelesaiArray' => $jamSelesaiArray,
                    'kegiatanArray' => $kegiatanArray,
                    'tgl_hadir' => $formattedDate,
                ]);
            }
        } catch (\Exception $e) {
            return redirect()->route('karyawan.recruitmen', 'toast_error', $e->getMessage());
        }
    }
}

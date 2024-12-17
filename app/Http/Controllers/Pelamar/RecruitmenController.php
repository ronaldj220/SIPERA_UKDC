<?php

namespace App\Http\Controllers\Pelamar;

use App\Http\Controllers\Controller;
use App\Models\Admin\Departemen;
use App\Models\Admin\Lowongan;
use App\Models\Recruitmen;
use App\Models\User;
use App\Notifications\DocumentSubmissionNotification;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;


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
        $karyawanLogin = Auth::user();
        // Mengambil recruitmen berdasarkan id_user yang login
        $recruitmen = Recruitmen::where('id_users', $karyawanLogin->id)->get();
        
        // dd(session('recruitment_data'));
        
        return view('halaman_karyawan.recruitmen.index', [
            'title' => $title,
            'karyawan' => $karyawan,
            'recruitmen' => $recruitmen
        ]);
    }
    public function add_recruitmen()
    {
        $karyawanLogin = Auth::user()->nama;

        $title = 'Tambah Data Recruitmen';
        $karyawan = User::join('role_has_users', 'users.id', '=', 'role_has_users.fk_user')
            ->join('role', 'role_has_users.fk_role', '=', 'role.id')
            ->where('role_has_users.fk_role', 2)
            ->select('users.*', 'role.role as role_name', 'role_has_users.fk_role as role')
            ->first();
        $no_doku = $this->new_no_doku();
        $departemen = Departemen::all();
        $lowongan = Lowongan::all();
        return view('halaman_karyawan.recruitmen.add_recruitmen', [
            'title' => $title,
            'karyawan' => $karyawan,
            'no_doku' => $no_doku,
            'lowongan' => $lowongan,
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
                $no_dokumen = sprintf("%03s", abs($noUrutAkhir + 1)) .  '/' . $AWAL . '/' . $AWAL_2 . '/' . $AWAL . '/' . $bulanRomawi[$currentMonth] . '/' . date('Y');
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
    
    public function view_doc($id)
    {
        try {
            $data = DB::table('recruitmen')->where('id', $id)->first();
            if ($data->status_approval == 'submitted') {
                $karyawanLogin = auth()->user()->nama; // Ganti dengan cara Anda mendapatkan data karyawan yang login

                $recruitmentData = Recruitmen::where('id_users', $karyawanLogin)->first(); // Sesuaikan dengan kondisi query Anda
                if (!$recruitmentData) {
                    // Handle jika data tidak ditemukan
                    abort(404);
                }
                $cvFileName = $recruitmentData->CV;
                $cvFilePath = public_path('CV PDF/' . $cvFileName);
                return response()->file($cvFilePath);
            } elseif ($data->status_approval == 'approved') {
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
                $jamHadirArray = $recruitmen->jam_hadir;
                $jamSelesaiArray = $recruitmen->jam_selesai;
                $kegiatanArray = $recruitmen->kegiatan;
    
                $tgl_hadir = Carbon::createFromFormat('Y-m-d', $recruitmen->tgl_hadir)->locale('id');
                $formattedDate = $tgl_hadir->isoFormat('DD MMMM YYYY');
    
                // tanggal pengajuan
                $tgl_pengajuan = Carbon::createFromFormat('Y-m-d', $recruitmen->tgl_pengajuan)->locale('id');
                $formattedDate_ajuan = $tgl_pengajuan->isoFormat('DD MMMM YYYY');
                
                $lokasiWawancara = $recruitmen->lokasiWawancara->lokasi;
                $ruanganWawancara = $recruitmen->lokasiWawancara->ruangan;
                
                $karyawan = User::join('role_has_users', 'users.id', '=', 'role_has_users.fk_user')
                    ->join('role', 'role_has_users.fk_role', '=', 'role.id')
                    ->where('role_has_users.fk_role', 2)
                    ->select('users.*', 'role.role as role_name', 'role_has_users.fk_role as role')
                    ->first();
                    
                // mPdf
                $mpdf = new \Mpdf\Mpdf([
                    'format' => 'A4',
                    'default_font' => 'Arial',
                ]);
                $mpdf->SetHeader('<img src="'. public_path('Header 2.png') .'"/>');
                $mpdf->SetFooter(''); // Menghilangkan footer
                
                $mpdf->WriteHTML(view('halaman_karyawan.recruitmen.view_recruitmen', [
                    'title' => $title,
                    'karyawan' => $karyawan,
                    'admin' => $admin,
                    'recruitmen' => $recruitmen,
                    'jamHadirArray' => $jamHadirArray,
                    'jamSelesaiArray' => $jamSelesaiArray,
                    'kegiatanArray' => $kegiatanArray,
                    'tgl_hadir' => $formattedDate,
                    'tgl_pengajuan' => $formattedDate_ajuan,
                    'lokasi' => $lokasiWawancara,
                'ruangan' => $ruanganWawancara,
                ]));
                $mpdf->Output();
            }
        } catch (\Exception $e) {
            return redirect()->route('karyawan.recruitmen')->with('toast_error', $e->getMessage());
        }
    }
    
    public function create_recruitment($id)
    {
        try{
            $lowongan = Lowongan::find($id);
            $departemen = Departemen::all();
            $title = 'Ajukan Lamaran';
            $karyawan = User::join('role_has_users', 'users.id', '=', 'role_has_users.fk_user')
                ->join('role', 'role_has_users.fk_role', '=', 'role.id')
                ->where('role_has_users.fk_role', 2)
                ->select('users.*', 'role.role as role_name', 'role_has_users.fk_role as role')
                ->first();
            $no_doku = $this->new_no_doku();
            return view('halaman_karyawan.recruitmen.create_recruitment', [
                'title' => $title,
                'karyawan' => $karyawan,
                'lowongan' => $lowongan,
                'no_doku' => $no_doku,
                'departemen' => $departemen
            ]);
        } catch (\Exception $e) {
            return redirect()->route('karyawan.recruitmen')->with('toast_error', $e->getMessage());
        }
    }
    
    public function store_recruitment(Request $request)
    {
        try{
            $request->validate([
                'file' => 'required|mimes:pdf,png,jpg,jpeg|max:2048' ,
                'transkrip' => 'required|mimes:pdf,png,jpg,jpeg|max:2048',
                'alasan' => 'required'
            ], [
                'file.required' => 'CV Wajib Diisi!',
                'file.max' => 'Ukuran CV Tidak Boleh Lebih dari 2MB!',
                'file.mimes' => 'Format file CV harus PDF, JPG, atau PNG.',
                'transkrip.max' => 'Ukuran Transkrip Tidak Boleh Lebih dari 2MB!',
                'transkrip.mimes' => 'Format file transkrip harus PDF, JPG, atau PNG.',
                'transkrip.required' => 'Transkrip Wajib Diisi!',
                'alasan.required' => 'Kolom alasan Wajib Diisi!',
            ]);
            
            $user = Auth::user();
            
            // Cek kelengkapan profil pengguna
            if(empty($user->nama) || empty($user->alamat) || empty($user->phone_number) || empty($user->tgl_lahir)){
                session()->put('alasan_penerimaan', $request->input('alasan'));
                return redirect()->back()->with('error', 'Lengkapi profil Anda terlebih dahulu sebelum mengajukan rekrutmen.');
            }
            
            $lowonganId = $request->input('id_lowongan');
            
            $userId = Auth::user()->id;
            
            // Cek apakah pelamar sudah mengajukan dokumen rekrutmen untuk lowongan yang sama
            $existingRecruitment = Recruitmen::where('id_users', $userId)
                ->where('lowongan_id', $lowonganId)
                ->first();
                
            if ($existingRecruitment) {
                return redirect()->back()->with('toast_error', 'Anda sudah mengajukan dokumen rekrutmen untuk lowongan ini.');
            }
            
            $lowongan = Lowongan::findOrFail($lowonganId);
            $formattedCreatedDate = Carbon::parse($lowongan->created_at)->format('d-m-Y');
            $formattedExpiredDate = Carbon::parse($lowongan->expired_at)->format('d-m-Y');
            
            $folderName = "{$lowongan->name_lowongan}(${formattedCreatedDate}-{$formattedExpiredDate})";
            
            $cvFolderName = public_path("uploads/lowongan/$folderName/CV(PDF)");
            $transkripFolderName = public_path("uploads/lowongan/$folderName/Transkrip(PDF)");
            
            if (!File::exists($cvFolderName)) {
                File::makeDirectory($cvFolderName, 0777, true);
            }
            if (!File::exists($transkripFolderName)) {
                File::makeDirectory($transkripFolderName, 0777, true);
            }
            
            $pemohon = Auth::user()->nama;
            
            // Simpan file di folder publik dan konversi ke base64
            $cvBase64 = null;
            $transkripBase64 = null;
            
            // Simpan file di folder publik
            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $mimeType = $file->getMimeType();
                
                if (in_array($mimeType, ['image/jpeg', 'image/png', 'image/jpg'])) {
                    // Jika file berupa gambar (JPG/PNG), simpan langsung dalam base64
                    $cvData = file_get_contents($file);
                    $cvBase64 = base64_encode($cvData);
                } else {
                    // Jika file berupa PDF, simpan di folder publik dan kemudian base64
                    $cvPath = $file->move($cvFolderName, 'cv_' . $pemohon . '.pdf');
                    $cvData = file_get_contents($cvPath);
                    $cvBase64 = base64_encode($cvData);
                }
            }
    
            if ($request->hasFile('transkrip')) {
                $fileTranskrip = $request->file('transkrip');
                $mimeType = $fileTranskrip->getMimeType();
                
                if (in_array($mimeType, ['image/jpeg', 'image/png', 'image/jpg'])) {
                    // Jika file berupa gambar (JPG/PNG), simpan di folder publik tanpa base64
                    $transkripPath = $fileTranskrip->move($transkripFolderName, 'transkrip_' . $pemohon . '.' . $fileTranskrip->getClientOriginalExtension());
                    $transkripBase64 = base64_encode(file_get_contents($transkripPath->getRealPath())); // Gambar tidak perlu base64
                    // dd($transkripPath->getRealPath());
                } else {
                    // Jika file berupa PDF, langsung simpan dalam base64
                    $transkripData = file_get_contents($fileTranskrip);
                    $transkripBase64 = base64_encode($transkripData);
                }
            }
            
            $tanggal = DateTime::createFromFormat('d/m/Y', $request->tgl_ajukan);
            $tgl_diajukan = $tanggal->format('Y-m-d');
            
            $dataRekrutmen = Recruitmen::create([
                'no_doku' => $request->input('no_doku'),
                'tgl_pengajuan' => $tgl_diajukan,
                'id_users' => Auth::user()->id,
                'alasan_penerimaan' => $request->input('alasan'),
                'CV_base_64' => $cvBase64,
                'transkrip_nilai_base_64' => $transkripBase64,
                'kenalan' =>  $request->input('kenalan_rekrutmen'),
                'kenalan_rekrutmen_lainnya'=> $request->input('kenalan_rekrutmen_lainnya'),
                'lowongan_id' => $lowongan->id
            ]);
            
            $adminUsers = User::whereHas('roles', function ($query) {
                $query->where('role', 'Admin'); // Pastikan nama kolom sesuai dengan kolom di tabel `role`
            })->get();
            
            foreach ($adminUsers as $admin) {
                $admin->notify(new DocumentSubmissionNotification($dataRekrutmen));
            }
            
            // Simpan data rekrutmen ke dalam session setelah berhasil disimpan
            return redirect()->route('karyawan.recruitmen')->with('success', 'Rekrutmen Pelamar Berhasil Ditambahkan');

        } catch (\Exception $e) {
            return redirect()->back()->with('toast_error', $e->getMessage());
        }
    }
}

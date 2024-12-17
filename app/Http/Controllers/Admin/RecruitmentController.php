<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Recruitmen;
use App\Models\User;
use App\Models\Admin\LokasiWawancara;
use App\Models\Admin\Kegiatan;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use DateTime;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\Admin\ExportRecruitment as ExportRecruitmen;

class RecruitmentController extends Controller
{
    public function index()
    {
        $title = 'Rekrutmen';
        $recruitmen = Recruitmen::with(['user', 'Lowongan'])
            ->orderByRaw("FIELD(status_approval, 'submitted') DESC") // Prioritaskan yang 'submitted'
            ->orderByRaw("FIELD(status_approval, 'approved') DESC") // Urutkan yang 'approved' setelah 'submitted'
            ->sortable()
            ->paginate(5);
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
    public function export_recruitment(){
        return Excel::download(new ExportRecruitmen, 'recruitment.xlsx');
    }
    
    public function search(Request $request){
        // Ambil query pencarian dari parameter input 'r'
        $query = $request->input('r');
    
        // Query untuk mencari Recruitmen berdasarkan nama user dan name_lowongan dari relasi Lowongan
        $recruitmen = Recruitmen::with(['user', 'Lowongan'])
            ->whereHas('user', function($q) use ($query) {
                $q->where('nama', 'like', '%' . $query . '%'); // Pencarian berdasarkan nama user
            })
            ->orWhereHas('Lowongan', function($q) use ($query) {
                $q->where('name_lowongan', 'like', '%' . $query . '%'); // Pencarian berdasarkan name_lowongan di relasi Lowongan
            })
            ->get(); // Mengambil semua hasil
    
        // Kembalikan data dalam format JSON
        return response()->json(['data' => $recruitmen]);
    }
    
    public function view_cv($id){
        $recruitmen = Recruitmen::find($id);
        $title = 'Lihat CV Pelamar';
            $admin = User::join('role_has_users', 'users.id', '=', 'role_has_users.fk_user')
                ->join('role', 'role_has_users.fk_role', '=', 'role.id')
                ->where('role_has_users.fk_role', 1)
                ->select('users.*', 'role.role as role_name')
                ->first();
            $recruitmentData = Recruitmen::find($id); // Sesuaikan dengan kondisi query Anda
            if (!$recruitmentData) {
                // Handle jika data tidak ditemukan
                abort(404, 'Data Rekrutmen Tidak Ditemukan');
            }
            $cvBase64 = $recruitmen->CV_base_64; // Asumsi CV sudah disimpan dalam bentuk base64 di database

            if (!$cvBase64) {
                return redirect()->back()->with('toast_error', 'File CV tidak ditemukan.');
            }
    
            // Mendekode base64 untuk mendapatkan file asli
            $decodedCV = base64_decode($cvBase64);
            
            // Cek tipe file berdasarkan MIME type
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mimeType = finfo_buffer($finfo, $decodedCV);
            finfo_close($finfo);
            
            // Tentukan URL berdasarkan MIME type
            if (strpos($mimeType, 'image') !== false) {
                // File adalah gambar
                $fileType = 'image';
                $cvDataUrl = 'data:' . $mimeType . ';base64,' . $cvBase64;
            } elseif ($mimeType === 'application/pdf') {
                // File adalah PDF
                $fileType = 'pdf';
                $cvDataUrl = 'data:' . $mimeType . ';base64,' . $cvBase64;
            } else {
                // Format tidak dikenali
                $fileType = 'unknown';
                $cvDataUrl = '';
            }
            
            // Menampilkan tampilan khusus untuk melihat PDF
            return view('halaman_admin.recruitmen.view_cv', [
                'cvDataUrl' => $cvDataUrl,
                'title' => $title,
                'admin' => $admin,
                'fileType' => $fileType
            ]);
    }
    public function view_recruitmen($id)
    {
        $recruitmen = Recruitmen::find($id);
        // dd($recruitmen);
        if ($recruitmen->status_approval == 'submitted') {
            $title = 'Lihat CV Pelamar';
            $admin = User::join('role_has_users', 'users.id', '=', 'role_has_users.fk_user')
                ->join('role', 'role_has_users.fk_role', '=', 'role.id')
                ->where('role_has_users.fk_role', 1)
                ->select('users.*', 'role.role as role_name')
                ->first();
            $recruitmentData = Recruitmen::find($id); // Sesuaikan dengan kondisi query Anda
            if (!$recruitmentData) {
                // Handle jika data tidak ditemukan
                abort(404, 'Data Rekrutmen Tidak Ditemukan');
            }
            $cvBase64 = $recruitmen->CV_base_64; // Asumsi CV sudah disimpan dalam bentuk base64 di database

            if (!$cvBase64) {
                return redirect()->back()->with('toast_error', 'File CV tidak ditemukan.');
            }
    
            // Buat link data base64
            $cvDataUrl = 'data:application/pdf;base64,'.$cvBase64;
            
            // Menampilkan tampilan khusus untuk melihat PDF
            return view('halaman_admin.recruitmen.view_cv', [
                'cvDataUrl' => $cvDataUrl,
                'title' => $title,
                'admin' => $admin
            ]);
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
            
            $user = $recruitmen->user;
            
            // Cek kelengkapan data profil pelamar
            if (empty($user->nama) || empty($user->tgl_lahir) || empty($user->tempat_lahir)) {
                return redirect()->back()->with('toast_error', 'Profil pelamar belum lengkap. Mohon lengkapi data profil untuk melanjutkan.');
            }
            $data_rekrutmen = Recruitmen::where('id', $id)->get();
            $arrayData = json_decode($data_rekrutmen, true);
            
            $lokasiWawancara = $recruitmen->lokasiWawancara->lokasi;
            $ruanganWawancara = $recruitmen->lokasiWawancara->ruangan;

            // Ambil nilai "jam_hadir" dari setiap elemen
            $jamHadirArray = $recruitmen->jam_hadir;
            $jamSelesaiArray = $recruitmen->jam_selesai;
            $kegiatanArray = $recruitmen->kegiatan;
            
            $tgl_hadir = Carbon::createFromFormat('Y-m-d', $recruitmen->tgl_hadir)->locale('id');
            $formattedDate = $tgl_hadir->isoFormat('DD MMMM YYYY');

            // tanggal pengajuan
            $tgl_pengajuan = Carbon::createFromFormat('Y-m-d', $recruitmen->tgl_pengajuan)->locale('id');
            $formattedDate_ajuan = $tgl_pengajuan->isoFormat('DD MMMM YYYY');

            // mPdf
            $mpdf = new \Mpdf\Mpdf([
                'format' => 'A4',
                'default_font' => 'Arial',
            ]);
            $mpdf->SetHeader('<img src="'. public_path('Header 2.png') .'"/>');
            $mpdf->SetFooter(''); // Menghilangkan footer
            $mpdf->WriteHTML(view('halaman_admin.recruitmen.view_recruitmen', [
                'title' => $title,
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
            
            
        } elseif ($recruitmen->status_approval == 'approved') {
            $title = 'Lihat Dokumen';
            $admin = User::join('role_has_users', 'users.id', '=', 'role_has_users.fk_user')
                ->join('role', 'role_has_users.fk_role', '=', 'role.id')
                ->where('role_has_users.fk_role', 1)
                ->select('users.*', 'role.role as role_name')
                ->first();
            $recruitmen = Recruitmen::find($id);
            
            $user = $recruitmen->user;
            
            // Cek kelengkapan data profil pelamar
            if (empty($user->nama) || empty($user->tgl_lahir) || empty($user->tempat_lahir)) {
                return redirect()->back()->with('error', 'Profil pelamar belum lengkap. Mohon lengkapi data profil untuk melanjutkan.');
            }
            
            $lokasiWawancara = $recruitmen->lokasiWawancara->lokasi;
            $ruanganWawancara = $recruitmen->lokasiWawancara->ruangan;
            $data_rekrutmen = Recruitmen::where('id', $id)->get();
            $arrayData = json_decode($data_rekrutmen, true);

            // Ambil nilai "jam_hadir", "jam_selesai", dan "kegiatan" dari elemen
            $jamHadirArray = $recruitmen->jam_hadir; // Make sure this is an array
            $jamSelesaiArray = $recruitmen->jam_selesai; // Make sure this is an array
            $kegiatanArray = $recruitmen->kegiatan; // Make sure this is an array



            // Ambil nilai pertama dari masing-masing array (jika ada)
            $jamHadir = isset($jamHadirArray[0]) ? $jamHadirArray[0] : ''; // Ambil jam hadir pertama
            $jamSelesai = isset($jamSelesaiArray[0]) ? $jamSelesaiArray[0] : ''; // Ambil jam selesai pertama
            $kegiatan = isset($kegiatanArray[0]) ? $kegiatanArray[0] : ''; // Ambil kegiatan pertama

            $tgl_hadir = Carbon::createFromFormat('Y-m-d', $recruitmen->tgl_hadir)->locale('id');
            $formattedDate = $tgl_hadir->isoFormat('DD MMMM YYYY');

            // tanggal pengajuan
            $tgl_pengajuan = Carbon::createFromFormat('Y-m-d', $recruitmen->tgl_pengajuan)->locale('id');
            $formattedDate_ajuan = $tgl_pengajuan->isoFormat('DD MMMM YYYY');
            
            // mPdf
            $mpdf = new \Mpdf\Mpdf([
                'format' => 'A4',
                'default_font' => 'Arial',
            ]);
            $mpdf->SetHeader('<img src="'. public_path('Header 2.png') .'"/>');
            $mpdf->SetFooter(''); // Menghilangkan footer
            $mpdf->WriteHTML(view('halaman_admin.recruitmen.view_recruitmen', [
                'title' => $title,
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
    }
    public function view_transkrip($id){
        $title = 'Lihat Transkrip dan Ijazah Pelamar';
        $admin = User::join('role_has_users', 'users.id', '=', 'role_has_users.fk_user')
            ->join('role', 'role_has_users.fk_role', '=', 'role.id')
            ->where('role_has_users.fk_role', 1)
            ->select('users.*', 'role.role as role_name')
            ->first();
        $recruitmentData = Recruitmen::find($id); // Sesuaikan dengan kondisi query Anda
        if (!$recruitmentData) {
            // Handle jika data tidak ditemukan
            abort(404, 'Data Rekrutmen Tidak Ditemukan');
        }
        
        // Ambil data base64 transkrip
        $transkripBase64 = $recruitmentData->transkrip_nilai_base_64;
        
        // Mendekode base64 untuk mendapatkan file asli
        $decodedTranskrip = base64_decode($transkripBase64);
        
        // Cek tipe file berdasarkan MIME type
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = finfo_buffer($finfo, $decodedTranskrip);
        finfo_close($finfo);
        
        // Tentukan URL berdasarkan MIME type
        if (strpos($mimeType, 'image') !== false) {
            // File adalah gambar
            $fileType = 'image';
            $transkripUrl = 'data:' . $mimeType . ';base64,' . $transkripBase64;
        } elseif ($mimeType === 'application/pdf') {
            // File adalah PDF
            $fileType = 'pdf';
            $transkripUrl = 'data:' . $mimeType . ';base64,' . $transkripBase64;
        } else {
            // Format tidak dikenali
            $fileType = 'unknown';
            $transkripUrl = '';
        }
    
        
        return view('halaman_admin.recruitmen.view_transkrip', [
            'title' => $title,
            'admin' => $admin,
            'transkripDataUrl' => $transkripUrl,
            'fileType' => $fileType,
            'fileExtension' => $mimeType,
            'decodedTranskrip' => $decodedTranskrip
        ]);
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
                // Hapus notifikasi terkait dokumen ini jika ada
                DB::table('notifications')
                    ->where('notifiable_id', Auth::user()->id)
                    ->where('notifiable_type', 'App\Models\Users') // Replace with the actual model namespace if different
                    ->delete();
                $no_doku = $data->no_doku;
                return redirect()->route('admin.recruitmen')->with('toast_success', 'Data dengan no dokumen ' . $no_doku . ' berhasil diverifikasi!');
            } elseif ($data->status_approval == 'pending') {
                DB::table('recruitmen')->where('id', $id)->update([
                    'status_approval' => 'approved',
                ]);
                // Hapus notifikasi terkait dokumen ini jika ada
                DB::table('notifications')
                    ->where('notifiable_id', Auth::user()->id)
                    ->where('notifiable_type', 'App\Models\Users') // Replace with the actual model namespace if different
                    ->delete();
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
                return redirect()->route('admin.recruitmen')->with('toast_error', 'Data dengan no dokumen ' . $no_doku . ' ditolak! Silahkan mengajukan lowongan lainnya!');
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
        
        $lokasiWawancara = LokasiWawancara::all();
        
        $kegiatan = Kegiatan::all();

        return view('halaman_admin.recruitmen.edit_rekrutmen', [
            'title' => $title,
            'admin' => $admin,
            'recruitmen' => $recruitmen,
            'lokasiWawancara' => $lokasiWawancara,
            'kegiatan' => $kegiatan
        ]);
    }
 public function update_doc($id, Request $request)
{
    try {
        $data_rekrutmen = DB::table('recruitmen')->where('id', $id)->first();

        // Validasi tanggal hadir dan lokasi wawancara
        $validator = Validator::make($request->all(), [
            'tgl_hadir' => [
                'required',
                'date',
                'after_or_equal:' . $data_rekrutmen->tgl_pengajuan, // Validasi agar tgl_hadir >= tgl_pengajuan
            ],
            'lokasi_wawancara' => 'required',
        ], [
            'tgl_hadir.required' => 'Tanggal hadir wajib diisi.',
            'tgl_hadir.date' => 'Format tanggal hadir tidak valid.',
            'tgl_hadir.after_or_equal' => 'Tanggal hadir tidak boleh kurang dari tanggal pengajuan.',
            'lokasi_wawancara.required' => 'Lokasi wawancara wajib dipilih.'
        ]);
        
        // Memeriksa apakah validasi gagal
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        
        $jamHadir = $request->input('jam_hadir', []);
        $jamSelesai = $request->input('jam_selesai', []);
        $kegiatan = $request->input('kegiatan', []);
        
        // Check if arrays are not empty and have the same length
        if (count($jamHadir) !== count($jamSelesai) || count($jamSelesai) !== count($kegiatan)) {
            return redirect()->back()->with('toast_error', 'Data jam hadir, jam selesai, dan kegiatan tidak konsisten.');
        }

        // Loop for validation
        for ($i = 0; $i < count($jamHadir); $i++) {
            if (!isset($jamHadir[$i]) || !isset($jamSelesai[$i]) || !isset($kegiatan[$i])) {
                return redirect()->back()->with('toast_error', 'Data pada index ke-' . ($i + 1) . ' tidak lengkap.');
            }
            
            // Check if the fields are filled
            $validate = $request->validate([
                'jam_hadir.' . $i => 'required',
                'jam_selesai.' . $i => 'required',
                'kegiatan.' . $i => 'required',
            ], [
                'jam_hadir.' . $i . '.required' => 'Jam Hadir ke-' . ($i + 1) . ' wajib diisi.',
                'jam_selesai.' . $i . '.required' => 'Jam Selesai ke-' . ($i + 1) . ' wajib diisi.',
                'kegiatan.' . $i . '.required' => 'Kegiatan ke-' . ($i + 1) . ' wajib diisi.',
            ]);
        }
        
        // Process update after validation
        $jamHadirArray = $request->input('jam_hadir');
        $jamSelesaiArray = $request->input('jam_selesai');
        $kegiatanArray = $request->input('kegiatan');
        
        // Ambil data dari lokasi_wawancara
        $idLokasiWawancara = $request->input('lokasi_wawancara');
        $lokasiWawancara = LokasiWawancara::find($idLokasiWawancara);
            
        if (!$lokasiWawancara) {
            return redirect()->back()->with('toast_error', 'Lokasi Wawancara tidak ditemukan');
        }
        
        // Ensure proper length and data consistency
        if (count($jamHadirArray) === count($jamSelesaiArray) && count($jamSelesaiArray) === count($kegiatanArray)) {
            $data = [];
            for ($i = 0; $i < count($jamHadirArray); $i++) {
                $data[] = [
                    'jam_hadir' => $jamHadirArray[$i],
                    'jam_selesai' => $jamSelesaiArray[$i],
                    'kegiatan' => json_encode([$kegiatanArray[$i]]), // Ensure kegiatan is JSON encoded
                ];
            }
            

            // Update recruitmen data
            Recruitmen::where('id', $id)->update([
                'tgl_hadir' => $request->input('tgl_hadir'),
                'id_lokasi_wawancara' => $lokasiWawancara->id,
                'jam_hadir' => json_encode(array_column($data, 'jam_hadir')),
                'jam_selesai' => json_encode(array_column($data, 'jam_selesai')),
                'kegiatan' => json_encode(array_column($data, 'kegiatan')),
                'is_edited' => 'false',
                'status_approval' => 'pending',
                'tgl_kirim' => null,
                'jumlah_kirim' => 0
            ]);
            
            $no_doku = $data_rekrutmen->no_doku;
            return redirect()->route('admin.recruitmen')->with('toast_success', 'Data dengan no dokumen ' . $no_doku . ' berhasil diperbarui!');
        }

    } catch (\Exception $e) {
        return redirect()->back()->with('error', $e->getMessage());
    }
}


    public function editQuickRecruitment($id){
        $title = 'Edit Dokumen Rekrutmen';
        $admin = User::join('role_has_users', 'users.id', '=', 'role_has_users.fk_user')
            ->join('role', 'role_has_users.fk_role', '=', 'role.id')
            ->where('role_has_users.fk_role', 1)
            ->select('users.*', 'role.role as role_name')
            ->first();
        $recruitmen = Recruitmen::find($id);
        
        $lokasiWawancara = LokasiWawancara::all();
        
        $kegiatan = Kegiatan::all();
        
        return view('halaman_admin.recruitmen.editQuickRecruitment', [
            'title' => $title,
            'admin' => $admin,
            'recruitmen' => $recruitmen,
            'lokasiWawancara' => $lokasiWawancara,
            'kegiatan' => $kegiatan
        ]);
    }
    
    public function updateQuickRecruitment(Request $request, $id){
        try {
            $data_rekrutmen = DB::table('recruitmen')->where('id', $id)->first();
    
            // Validasi tanggal hadir dan lokasi wawancara
            $validator = Validator::make($request->all(), [
                'tgl_hadir' => [
                    'required',
                    'date',
                    'after_or_equal:' . $data_rekrutmen->tgl_pengajuan, // Validasi agar tgl_hadir >= tgl_pengajuan
                ],
                'lokasi_wawancara' => 'required',
                'jam_hadir.*' => 'required|date_format:H:i', // Validasi untuk setiap elemen dalam jam_hadir
                'jam_selesai.*' => 'required|date_format:H:i|after:jam_hadir.*', // Validasi untuk setiap elemen dalam jam_selesai
                'kegiatan' => 'required|array|min:1',
                'kegiatan.*' => 'required|string', // Validasi untuk setiap elemen dalam kegiatan
            ], [
                'tgl_hadir.required' => 'Tanggal hadir wajib diisi.',
                'tgl_hadir.date' => 'Format tanggal hadir tidak valid.',
                'tgl_hadir.after_or_equal' => 'Tanggal hadir tidak boleh kurang dari tanggal pengajuan.',
                'lokasi_wawancara.required' => 'Lokasi wawancara wajib dipilih.',
                'jam_hadir.*.required' => 'Jam hadir wajib diisi untuk setiap kegiatan.',
                'jam_hadir.*.date_format' => 'Format jam hadir harus dalam format HH:MM.',
                'jam_selesai.*.required' => 'Jam selesai wajib diisi untuk setiap kegiatan.',
                'jam_selesai.*.date_format' => 'Format jam selesai harus dalam format HH:MM.',
                'jam_selesai.*.after' => 'Jam selesai harus setelah jam hadir.',
                'kegiatan.required' => 'Kegiatan wajib diisi.',
                'kegiatan.*.required' => 'Setiap kegiatan harus dipilih.',
            ]);
    
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
            
            // Ambil data dari request
            $jamHadirArray = $request->input('jam_hadir');
            $jamSelesaiArray = $request->input('jam_selesai');
            $kegiatanArray = $request->input('kegiatan'); // Asumsikan ini adalah array
    
            // Ambil data dari lokasi_wawancara
            $idLokasiWawancara = $request->input('lokasi_wawancara');
            $lokasiWawancara = LokasiWawancara::find($idLokasiWawancara);
            
            if (!$lokasiWawancara) {
                return redirect()->back()->with('toast_error', 'Lokasi Wawancara tidak ditemukan');
            }
    
            // Pastikan panjang array-nya sama
            if (count($jamHadirArray) === count($jamSelesaiArray) && count($jamSelesaiArray)) {
                $data = [];
    
                // Loop untuk setiap entri
                for ($i = 0; $i < count($jamHadirArray); $i++) {
                    // Validasi untuk memastikan kegiatan tidak kosong
                    if (empty($kegiatanArray[$i])) {
                        return redirect()->back()->with('toast_error', 'Kegiatan tidak boleh kosong.');
                    }
    
                    // Cek apakah kegiatan adalah array dan ambil lebih dari satu kegiatan
                    $kegiatanList = is_array($kegiatanArray[$i]) ? $kegiatanArray[$i] : [$kegiatanArray[$i]];
    
                    $data[] = [
                        'jam_hadir' => $jamHadirArray[$i],
                        'jam_selesai' => $jamSelesaiArray[$i],
                        'kegiatan' => json_encode($kegiatanList), // Menyimpan kegiatan sebagai JSON
                    ];
                }
    
                // Ubah array menjadi JSON
                $jsonDataJamHadir = json_encode(array_column($data, 'jam_hadir'));
                $jsonDataJamSelesai = json_encode(array_column($data, 'jam_selesai'));
                $jsonDataKegiatan = json_encode(array_column($data, 'kegiatan'));
    
                Recruitmen::where('id', $id)->update([
                    'tgl_hadir' => $request->input('tgl_hadir'),
                    'id_lokasi_wawancara' => $lokasiWawancara->id,
                    'jam_hadir' => $jsonDataJamHadir,
                    'jam_selesai' => $jsonDataJamSelesai,
                    'kegiatan' => $jsonDataKegiatan,
                    'is_edited' => 'false',
                    'status_approval' => 'approved',
                    'tgl_kirim' => $data_rekrutmen->tgl_kirim,
                    'jumlah_kirim' => $data_rekrutmen->jumlah_kirim
                ]);
                
                $no_doku = $data_rekrutmen->no_doku;
                return redirect()->route('admin.recruitmen')->with('toast_success', 'Data dengan no dokumen ' . $no_doku . ' berhasil diperbarui!');
            } 
                // dd(count($kegiatanArray));
        } catch (\Exception $e) {
            return redirect()->route('admin.recruitmen')->with('toast_error', $e->getMessage());
        }
    }

    public function send_doc($id)
    {
        try {
            // Ambil data rekrutmen berdasarkan ID
            $recruitmen = Recruitmen::with('user')->find($id);

            if (!$recruitmen) {
                return redirect()->route('admin.recruitmen')->with('toast_error', 'Data rekrutmen tidak ditemukan.');
            }
            
            // Cek jumlah pengiriman email
            if ($recruitmen->jumlah_kirim >= 3) { // Batas pengiriman, misalnya 3 kali
                return redirect()->route('admin.recruitmen')->with('toast_error', 'Batas pengiriman email telah tercapai.');
            }

            // Ganti 'email' dengan nama view email yang sesuai
            $view = 'halaman_admin/email';

            // Ambil nama dan email pelamar
            $namaPelamar = $recruitmen->user->nama; // Ambil nama dari model User
            $emailPelamar = $recruitmen->user->email; // Ambil email dari model User
            $statusPelamar = $recruitmen->status_approval;

            // Kirim email
            Mail::send($view, ['namaPelamar' => $namaPelamar, 'statusPelamar' => $statusPelamar], function ($message) use ($emailPelamar) {
                $message->to($emailPelamar);
                $message->subject("Dokumen Penerimaan");
            });

            // Update DB
            Recruitmen::where('id', $id)->update([
                'jumlah_kirim' => $recruitmen->jumlah_kirim + 1,
                'tgl_kirim' => Carbon::now(),
            ]);
            
            // Redirect dengan pesan sukses jika email berhasil dikirim
            return redirect()->route('admin.recruitmen')->with('toast_success', 'Pemberitahuan bahwa pelamar telah menerima email/undangan dari UKDC.');
        } catch (\Exception $e) {
            // Redirect dengan pesan error jika terjadi exception
            return redirect()->route('admin.recruitmen')->with('toast_error', $e->getMessage());
        }
    }
}

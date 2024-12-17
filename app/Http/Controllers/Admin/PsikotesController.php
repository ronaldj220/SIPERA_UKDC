<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Psikotes;
use App\Models\Recruitmen;
use App\Models\Admin\LokasiPsikotes;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\Admin\ExportPsikotes as ExportPsikotes;

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
        $psikotes = Psikotes::sortable()->with(['rekrutmen.user', 'rekrutmen.lowongan'])
            ->orderByRaw("FIELD(status_approval, 'pending') DESC") // Prioritaskan yang 'submitted'
            ->orderByRaw("FIELD(status_approval, 'approved') DESC") // Urutkan yang 'approved' setelah 'submitted'
            ->sortable()
            ->paginate(5);
        return view('halaman_admin.psikotes.index', [
            'title' => $title,
            'admin' => $admin,
            'psikotes' => $psikotes
        ]);
    }
    
    public function export_psikotes(){
        return Excel::download(new ExportPsikotes, 'psikotes.xlsx');
    }
    
    public function search(Request $request){
        $query = $request->input('q');
        
        $psikotes = Psikotes::whereHas('rekrutmen.user', function($q) use ($query) {
            $q->where('nama', 'like', "%{$query}%"); // Pencarian berdasarkan nama
        })->get();
        
        return response()->json(['data' => $psikotes]);
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
        $pemohon = Recruitmen::with('user')->where('status_approval', 'approved')->get();
        $lokasiPsikotes = LokasiPsikotes::all();
        return view('halaman_admin.psikotes.add_psikotes', [
            'title' => $title,
            'admin' => $admin,
            'no_doku' => $no_doku,
            'pemohon' => $pemohon,
            'lokasi_psikotes' => $lokasiPsikotes
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
                $no_dokumen = sprintf("%03s", abs($noUrutAkhir + 1)) .  '/' . $AWAL . '/' . $AWAL_2 . '/' . $bulanRomawi[$currentMonth] . '/' . date('Y');
            } else {
                $no_dokumen = sprintf("%03s", abs($no)) . '/' . $AWAL . '/' . $AWAL_2 . '/' . $bulanRomawi[$currentMonth] . '/' . date('Y');
            }
        }
        return $no_dokumen;
    }
    public function save_psikotes(Request $request)
    {
        $request->validate([
            'no_doku_psikotes' => 'required|string',
            'no_doku_rektor' => 'required|string',
            'tgl_hadir' => 'required|date',
            'jam_hadir' => 'required|string',
            'lokasi_hadir' => 'required|integer', // pastikan ini adalah integer
            'link_psikotes' => 'required',
            'tgl_ajukan' => [
                'required',
                'date'
            ]
        ], [
            'lokasi_hadir.required' => 'Lokasi Psikotes Harap Diisi!'
        ]);
        // Check if the pemohon exists in the users table
        $pemohonId = $request->input('pemohon');
        $usersId = User::find($pemohonId);
        if (!$usersId) {
            return redirect()->back()->with('error', 'Pemohon tidak ditemukan');
        }
        
        // Check if the lokasi_hadir exists in the LokasiPsikotes table
        $lokasiPsikotes = $request->input('lokasi_hadir');
        $lokasiPsikotesId = LokasiPsikotes::find($lokasiPsikotes);
        if (!$lokasiPsikotesId) {
            return redirect()->route('admin.psikotes')->with('error', 'Lokasi Psikotes tidak ditemukan');
        }
        
        // Get the approved rekrutmen entry without using first()
        $rekrutmen = Recruitmen::where('status_approval', 'approved')->orderBy('created_at', 'desc')->limit(1)->get();
        if ($rekrutmen->isEmpty()) {
            return redirect()->back()->with('error', 'Rekrutmen dengan status disetujui tidak ditemukan.');
        }
    
        $rekrutmenId = $rekrutmen->first()->id;
        // dd($rekrutmenId);
        
        
        // Check if the pemohon has already applied for a psikotes in the given rekrutmen
        $existingPsikotes = Psikotes::where('id_rekrutmen', $rekrutmen->first()->id)
                            ->where('pemohon_id', $pemohonId)
                            ->first();
        if ($existingPsikotes) {
            return redirect()->back()->with('error', 'Pemohon ini sudah mengajukan Psikotes untuk rekrutmen ini.');
        }
        
        // Create a new psikotes entry
        $psikotes = Psikotes::create([
            'no_doku_psikotes' => $request->input('no_doku_psikotes'),    
            'no_doku_rektor' => $request->input('no_doku_rektor'),    
            'id_rekrutmen' => $rekrutmenId,   
            'pemohon_id' => $pemohonId,
            'lokasi_psikotes_id' => $lokasiPsikotesId->id,   
            'tgl_pengajuan' => $request->input('tgl_ajukan'),    
            'tgl_hadir' => $request->input('tgl_hadir'),    
            'jam_hadir' => $request->input('jam_hadir'),    
            'link_psikotes' => $request->input('link_psikotes'),  
            'status_approval' => 'pending',
            'tgl_kirim' => NULL,
            'jumlah_kirim' => 0
        ]);
    
        return redirect()->route('admin.psikotes')->with('success', 'Data Psikotes Berhasil Ditambahkan!');
    }
    
    public function edit_psikotes($id){
        $title = 'Edit Psikotes';
        $admin = User::join('role_has_users', 'users.id', '=', 'role_has_users.fk_user')
            ->join('role', 'role_has_users.fk_role', '=', 'role.id')
            ->where('role_has_users.fk_role', 1)
            ->select('users.*', 'role.role as role_name')
            ->first();
        $psikotes = Psikotes::find($id);
        $no_doku = $this->new_no_doku();
        $pemohon = Recruitmen::with('user')->where('status_approval', 'approved')->get();
        $lokasiPsikotes = LokasiPsikotes::all();
        
        $namaPemohon = $psikotes->rekrutmen->user->nama;
        
        return view('halaman_admin.psikotes.edit_psikotes', [
            'title' => $title,
            'admin' => $admin,
            'no_doku' => $no_doku,
            'pemohon' => $pemohon,
            'lokasi_psikotes' => $lokasiPsikotes,
            'psikotes' => $psikotes,
            'namaPemohon' => $namaPemohon
        ]);
    }
    
    public function update_psikotes(Request $request, $id){
        $psikotes = Psikotes::findOrFail($id);
        
        $pemohonId = $request->input('pemohon');
        $usersId = User::find($pemohonId);
        if (!$usersId) {
            return redirect()->back()->with('error', 'Pemohon tidak ditemukan');
        }
        $lokasiPsikotes = $request->input('lokasi_hadir');
        $lokasiPsikotesId = LokasiPsikotes::find($lokasiPsikotes);
        if (!$lokasiPsikotesId) {
            return redirect()->route('admin.psikotes')->with('error', 'Lokasi Psikotes tidak ditemukan');
        }
        
        // Get the approved rekrutmen entry without using first()
        $rekrutmen = Recruitmen::where('status_approval', 'approved')->orderBy('created_at', 'desc')->limit(1)->get();
        if ($rekrutmen->isEmpty()) {
            return redirect()->back()->with('error', 'Rekrutmen dengan status disetujui tidak ditemukan.');
        }
    
        $rekrutmenId = $rekrutmen->first()->id;
        
        $psikotes->update([
            'tgl_pengajuan' => $request->input('tgl_ajukan'),
            'no_doku_psikotes' => $request->input('no_doku_psikotes'),    
            'no_doku_rektor' => $request->input('no_doku_rektor'),    
            'id_rekrutmen' => $rekrutmenId,   
            'lokasi_psikotes_id' => $lokasiPsikotesId->id,
            'tgl_hadir' => $request->input('tgl_hadir'),    
            'jam_hadir' => $request->input('jam_hadir'),    
            'link_psikotes' => $request->input('link_psikotes'),  
            'status_approval' => 'pending',
            'tgl_kirim' => NULL,
            'jumlah_kirim' => 0
        ]);
        
        return redirect()->route('admin.psikotes')->with('success', 'Data Psikotes Berhasil Diperbarui!');
    }
    
    public function editQuickPsikotes($id){
        $title = 'Edit Psikotes';
        $admin = User::join('role_has_users', 'users.id', '=', 'role_has_users.fk_user')
            ->join('role', 'role_has_users.fk_role', '=', 'role.id')
            ->where('role_has_users.fk_role', 1)
            ->select('users.*', 'role.role as role_name')
            ->first();
        $psikotes = Psikotes::find($id);
        $no_doku = $this->new_no_doku();
        $pemohon = Recruitmen::with('user')->where('status_approval', 'approved')->get();
        $lokasiPsikotes = LokasiPsikotes::all();
        
        $namaPemohon = $psikotes->rekrutmen->user->nama;
        
        return view('halaman_admin.psikotes.editQuickPsikotes', [
            'title' => $title,
            'admin' => $admin,
            'no_doku' => $no_doku,
            'pemohon' => $pemohon,
            'lokasi_psikotes' => $lokasiPsikotes,
            'psikotes' => $psikotes,
            'namaPemohon' => $namaPemohon
        ]);
    }
    
    public function updateQuickPsikotes(Request $request, $id){
        try{
            $psikotes = Psikotes::findOrFail($id);
        
        $pemohonId = $request->input('pemohon');
        $usersId = User::find($pemohonId);
        if (!$usersId) {
            return redirect()->back()->with('error', 'Pemohon tidak ditemukan');
        }
        $lokasiPsikotes = $request->input('lokasi_hadir');
        $lokasiPsikotesId = LokasiPsikotes::find($lokasiPsikotes);
        if (!$lokasiPsikotesId) {
            return redirect()->route('admin.psikotes')->with('error', 'Lokasi Psikotes tidak ditemukan');
        }
        
        // Get the approved rekrutmen entry without using first()
        $rekrutmen = Recruitmen::where('status_approval', 'approved')->orderBy('created_at', 'desc')->limit(1)->get();
        if ($rekrutmen->isEmpty()) {
            return redirect()->back()->with('error', 'Rekrutmen dengan status disetujui tidak ditemukan.');
        }
    
        $rekrutmenId = $rekrutmen->first()->id;
        
        $psikotes->update([
            'tgl_pengajuan' => $request->input('tgl_ajukan'),
            'no_doku_psikotes' => $request->input('no_doku_psikotes'),    
            'no_doku_rektor' => $request->input('no_doku_rektor'),    
            'id_rekrutmen' => $rekrutmenId,   
            'lokasi_psikotes_id' => $lokasiPsikotesId->id,
            'tgl_hadir' => $request->input('tgl_hadir'),    
            'jam_hadir' => $request->input('jam_hadir'),    
            'link_psikotes' => $request->input('link_psikotes'),  
            'status_approval' => 'approved',
            'tgl_kirim' => $psikotes->tgl_kirim,
            'jumlah_kirim' => $psikotes->jumlah_kirim
        ]);
        
        return redirect()->route('admin.psikotes')->with('success', 'Data Psikotes Berhasil Diperbarui!');
        } catch(\Exception $e){
            return redirect()->route('admin.psikotes')->with('error', 'Gagal Memperbarui Data!');
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
        // Dapatkan data psikotes berdasarkan ID yang diberikan
        $psikotes = Psikotes::with(['rekrutmen.user', 'lokasiPsikotes'])->find($id);
        
        $user = $psikotes->rekrutmen->user;
        
        // Cek kelengkapan data profil pelamar
        if (empty($user->nama) || empty($user->tgl_lahir) || empty($user->tempat_lahir)) {
            return redirect()->back()->with('error', 'Profil pelamar belum lengkap. Mohon lengkapi data profil untuk melanjutkan.');
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

        $mpdf->WriteHTML(view('halaman_admin.psikotes.view_psikotes', [
            'title' => $title,
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
    public function tolak_psikotes($id)
    {
        try {
            $data = DB::table('psikotes')->where('id', $id)->first();
            DB::table('psikotes')->where('id', $id)->update([
                'status_approval' => 'rejected',
            ]);
            $no_doku = $data->no_doku_psikotes;
            return redirect()->route('admin.psikotes')->with('toast-error', 'Data dengan no dokumen ' . $no_doku . ' ditolak!');
        } catch (\Exception $e) {
            return redirect()->route('admin.psikotes')->with('toast_error', $e->getMessage());
        }
    }
    public function send_psikotes($id)
    {
        try {
            $psikotes = Psikotes::with(['rekrutmen.user'])->find($id);
            if (!$psikotes) {
                return redirect()->route('admin.psikotes')->with('toast_error', 'Data Psikotes tidak ditemukan!');
            }
             // Periksa jika jumlah_kirim sudah lebih dari 3 kali
            if ($psikotes->jumlah_kirim >= 3) {
                return redirect()->route('admin.psikotes')->with('toast_error', 'Email sudah dikirim lebih dari 3 kali. Pengiriman dibatasi.');
            }
            // Ganti 'email' dengan nama view email yang sesuai
            $view = 'halaman_admin/psikotes/email';
            // Ambil nama dan email pelamar
            $namaPelamar = $psikotes->rekrutmen->user->nama;
            $emailPelamar = $psikotes->rekrutmen->user->email;
            $statusPelamar = $psikotes->status_approval;
            Mail::send($view, ['namaPelamar' => $namaPelamar, 'statusPelamar' => $statusPelamar], function ($message) use ($emailPelamar) {
                $message->to($emailPelamar);
                $message->subject("Pemberitahuan Hasil Psikotes");
            });
            
            $psikotes->update([
                'jumlah_kirim' => $psikotes->jumlah_kirim + 1,
                'tgl_kirim' => Carbon::now()
            ]);
            return redirect()->route('admin.psikotes')->with('toast_success', 'Pemberitahuan bahwa pelamar telah menerima email/undangan psikotes dari UKDC.');
        } catch (\Exception $e) {
            return redirect()->route('admin.psikotes')->with('toast_error', $e->getMessage());
        }
    }
}

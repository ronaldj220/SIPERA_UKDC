<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\BerandaController;
use App\Http\Controllers\Admin\DepartemenController;
use App\Http\Controllers\Admin\HasilTesController;
use App\Http\Controllers\Admin\PelamarController;
use App\Http\Controllers\Admin\PsikotesController;
use App\Http\Controllers\Admin\RecruitmentController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\LowonganController;
use App\Http\Controllers\Admin\PosisiLamaranController;
use App\Http\Controllers\Admin\LokasiPsikotesController;
use App\Http\Controllers\Admin\KegiatanController;
use App\Http\Controllers\Admin\LokasiWawancaraController;
use App\Http\Controllers\Admin\UnitKerjaController;
use App\Http\Controllers\Admin\StatusPegawaiController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ForgotPassController;
use App\Http\Controllers\Dosen\BerandaController as DosenBerandaController;
use App\Http\Controllers\Karyawan\BerandaController as KaryawanBerandaController;
use App\Http\Controllers\Pelamar\BerandaController as PelamarBerandaController;
use App\Http\Controllers\Pelamar\HasilTesController as PelamarHasilTesController;
use App\Http\Controllers\Pelamar\PsikotesController as PelamarPsikotesController;
use App\Http\Controllers\Pelamar\RecruitmenController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [HomeController::class, 'index'])->name('checkhome');
Route::get('/home', [LoginController::class, 'home'])->name('home');

// Route untuk halaman login
Route::middleware('guest')->group(function (){
    Route::get('login', [LoginController::class, 'index'])->name('login');
    Route::post('login', [LoginController::class, 'aksilogin'])->name('aksilogin');
    Route::get('forgot-password', [ForgotPassController::class, 'forgotPassword'])->name('forgot-password');
    Route::post('forgot-password', [ForgotPassController::class, 'forgotPasswordPost'])->name('aksilupapass');
    Route::get('reset-password/{token}', [ForgotPassController::class, 'resetPassword'])->name('reset-password');
    Route::get('reset-password-akun', [ForgotPassController::class, 'resetPassword'])->name('resetPassword');
    Route::post('reset-password', [ForgotPassController::class, 'resetPasswordPost'])->name('reset-password-post');
    
});
Route::get('logout', [LoginController::class, 'logout'])->name('logout');

// Route untuk sign up atau register
Route::get('sign_up', [LoginController::class, 'sign_up'])->name('sign_up');
Route::post('sign_up', [LoginController::class, 'proses_sign_up'])->name('aksi_sign_up');

Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
    // Route untuk ke halaman beranda
    Route::get('beranda', [BerandaController::class, 'index'])->name('admin.beranda');
    

    // Route untuk halaman profile admin
    Route::get('beranda/profile', [BerandaController::class, 'profile'])->name('admin.profile');
    Route::post('beranda/profile/update_profile/{id}', [BerandaController::class, 'update_profile'])->name('admin.profile.update_profile');

    // Route untuk halaman departemen
    Route::get('departemen', [DepartemenController::class, 'index'])->name('admin.departemen');
    Route::get('departemen/add_departemen', [DepartemenController::class, 'add_departemen'])->name('admin.departemen.add_departemen');
    Route::post('departemen/save_departemen', [DepartemenController::class, 'save_departemen'])->name('admin.departemen.save_departemen');
    Route::get('departemen/hapus_departemen/{id}', [DepartemenController::class, 'hapus_departemen'])->name('admin.departemen.hapus_departemen');
    Route::get('departemen/edit_departemen/{id}', [DepartemenController::class, 'edit_departemen'])->name('admin.departemen.edit_departemen');
    Route::post('departemen/update_departemen/{id}', [DepartemenController::class, 'update_departemen'])->name('admin.departemen.update_departemen');
    Route::delete('departemen/deleteDepartemen/{id}', [DepartemenController::class, 'deleteDepartemen'])->name('admin.departemen.deleteDepartemen');
    
    Route::get('departemen/search', [DepartemenController::class, 'search'])->name('admin.departemen.search');
    
    // Route untuk halaman lowongan pada admin
    Route::get('lowongan', [LowonganController::class, 'index'])->name('admin.lowongan');
    Route::get('lowongan/add_lowongan', [LowonganController::class, 'add_lowongan'])->name('admin.lowongan.add_lowongan');
    Route::post('lowongan/save_lowongan', [LowonganController::class, 'save_lowongan'])->name('admin.lowongan.save_lowongan');
    Route::get('lowongan/edit_lowongan/{id}', [LowonganController::class, 'edit_lowongan'])->name('admin.lowongan.edit_lowongan');
    Route::post('lowongan/update_lowongan/{id}', [LowonganController::class, 'update_lowongan'])->name('admin.lowongan.update_lowongan');
    Route::delete('lowongan/delete_lowongan/{id}', [LowonganController::class, 'delete_lowongan'])->name('admin.lowongan.delete_lowongan');
    
    Route::get('lowongan/search', [LowonganController::class, 'search'])->name('admin.lowongan.search');
    
    // Route for generate qr code
    Route::get('lowongan/generateQRCode/{id}', [LowonganController::class, 'generateQRCode'])->name('admin.lowongan.generateQRCode');
    
    
    // Route untuk membuat halaman lokasi wawancara
    Route::get('lokasi_wawancara', [LokasiWawancaraController::class, 'index'])->name('admin.lokasiWawancara');
    Route::get('lokasi_wawancara/add_lokasi_wawancara', [LokasiWawancaraController::class, 'add_lokasi_wawancara'])->name('admin.lokasiWawancara.addLokasiWawancara');
    Route::post('lokasi_wawancara/save_lokasi_wawancara', [LokasiWawancaraController::class, 'save_lokasi_wawancara'])->name('admin.lokasiWawancara.saveLokasiWawancara');
    Route::get('lokasi_wawancara/edit_lokasi_wawancara/{id}', [LokasiWawancaraController::class, 'edit_lokasi_wawancara'])->name('admin.lokasiWawancara.editLokasiWawancara');
    Route::post('lokasi_wawancara/update_lokasi_wawancara/{id}', [LokasiWawancaraController::class, 'update_lokasi_wawancara'])->name('admin.lokasiWawancara.updateLokasiWawancara');

    // Route untuk halaman role
    Route::get('role', [RoleController::class, 'index'])->name('admin.role');
    Route::get('role/add_role', [RoleController::class, 'add_role'])->name('admin.role.add_role');
    Route::post('role/save_role', [RoleController::class, 'save_role'])->name('admin.role.save_role');

    // Route untuk halaman admin
    Route::get('admin', [AdminController::class, 'index'])->name('admin.admin');
    Route::get('admin/add_admin', [AdminController::class, 'add_admin'])->name('admin.admin.add_admin');
    Route::post('admin/save_admin', [AdminController::class, 'save_admin'])->name('admin.admin.save_admin');
    Route::get('admin/hapus_admin/{id}', [AdminController::class, 'hapus_admin'])->name('admin.admin.hapus_admin');

    // Route untuk ubah password khusus admin
    Route::get('ubah-password', [AdminController::class, 'ubah_pwd'])->name('admin.ubah_pwd');
    Route::post('ubah-password', [AdminController::class, 'change_pwd'])->name('admin.change_pwd');

    // Route untuk halaman pelamar
    Route::get('pelamar', [PelamarController::class, 'index'])->name('admin.pelamar');
    
    // Route untuk halaman posisi lamaran 
    // 1. Get all Lamaran
    Route::get('posisi_lamaran', [PosisiLamaranController::class, 'index'])->name('admin.pos_lamaran');
    // 2. Add lamaran
    Route::get('posisi_lamaran/add_pos_lamaran', [PosisiLamaranController::class, 'add_pos_lamaran'])->name('admin.add_pos_lamaran');
    Route::post('posisi_lamaran/save_pos_lamaran', [PosisiLamaranController::class, 'save_pos_lamaran'])->name('admin.save_pos_lamaran');
    // 3. Edit Lamaran
    Route::get('posisi_lamaran/edit_lamaran/{id}', [PosisiLamaranController::class, 'edit_pos_lamaran'])->name('admin.pos_lamaran.edit_pos_lamaran');
    // 4. Update Lamaran
    Route::post('posisi_lamaran/edit_lamaran/{id}', [PosisiLamaranController::class, 'update_posisi_lamaran'])->name('admin.pos_lamaran.update_pos_lamaran');
    
    // Route untuk halaman lokasi psikotes
    Route::get('lokasi_psikotes', [LokasiPsikotesController::class, 'index'])->name('admin.lokasi_psikotes');
    Route::get('lokasi_psikotes/add_lokasi_psikotes', [LokasiPsikotesController::class, 'add_lokasi_psikotes'])->name('admin.lokasi_psikotes.add_lokasi_psikotes');
    Route::post('lokasi_psikotes/save_lokasi_psikotes', [LokasiPsikotesController::class, 'save_lokasi_psikotes'])->name('admin.lokasi_psikotes.save_lokasi_psikotes');
    Route::get('lokasi_psikotes/hapus_lokasi_psikotes/{id}', [LokasiPsikotesController::class, 'hapus_lokasi_psikotes'])->name('admin.lokasi_psikotes.hapus_lokasi_psikotes');
    Route::get('lokasi_psikotes/edit_lokasi_psikotes/{id}', [LokasiPsikotesController::class, 'edit_lokasi_psikotes'])->name('admin.lokasi_psikotes.edit_lokasi_psikotes');
    Route::post('lokasi_psikotes/update_lokasi_psikotes/{id}', [LokasiPsikotesController::class, 'update_lokasi_psikotes'])->name('admin.lokasi_psikotes.update_lokasi_psikotes');
    
    // Route untuk unit kerja
    Route::get('unitKerja', [UnitKerjaController::class, 'index'])->name('admin.unitKerja');
    Route::get('unitKerja/addUnitKerja', [UnitKerjaController::class, 'addUnitKerja'])->name('admin.unitKerja.addUnitKerja');
    Route::post('unitKerja/saveUnitKerja', [UnitKerjaController::class, 'saveUnitKerja'])->name('admin.unitKerja.saveUnitKerja');
    Route::get('unitKerja/editUnitKerja/{id}', [UnitKerjaController::class, 'editUnitKerja'])->name('admin.unitKerja.editUnitKerja');
    Route::post('unitKerja/updateUnitKerja/{id}', [UnitKerjaController::class, 'updateUnitKerja'])->name('admin.unitKerja.updateUnitKerja');
    Route::delete('unitKerja/deleteUnitKerja/{id}', [UnitKerjaController::class, 'deleteUnitKerja'])->name('admin.unitKerja.deleteUnitKerja');
    Route::get('unitKerja/search', [UnitKerjaController::class, 'search'])->name('admin.unitKerja.search');
    
    // Route untuk Status Pegawai
    Route::get('statusPegawai', [StatusPegawaiController::class, 'index'])->name('admin.statusPegawai');
    Route::get('statusPegawai/addStatusPegawai', [StatusPegawaiController::class, 'addStatusPegawai'])->name('admin.statusPegawai.addStatusPegawai');
    Route::post('statusPegawai/saveStatusPegawai', [StatusPegawaiController::class, 'saveStatusPegawai'])->name('admin.statusPegawai.saveStatusPegawai');
    Route::get('statusPegawai/editStatusPegawai/{id}', [StatusPegawaiController::class, 'editStatusPegawai'])->name('admin.statusPegawai.editStatusPegawai');
    Route::post('statusPegawai/updateStatusPegawai/{id}', [StatusPegawaiController::class, 'updateStatusPegawai'])->name('admin.statusPegawai.updateStatusPegawai');
    Route::get('statusPegawai/search', [StatusPegawaiController::class, 'search'])->name('admin.statusPegawai.search');

    // Route untuk halaman recruiter
    Route::get('recruitmen', [RecruitmentController::class, 'index'])->name('admin.recruitmen');
    Route::get('recruitmen/view_recruitmen/{id}', [RecruitmentController::class, 'view_recruitmen'])->name('admin.recruitmen.view_recruitmen');
    // Route untuk melihat CV Pelamar
    Route::get('recruitmen/view_cv/{id}', [RecruitmentController::class, 'view_cv'])->name('admin.recruitmen.view_cv');
    Route::get('recruitmen/view_transkrip/{id}', [RecruitmentController::class, 'view_transkrip'])->name('admin.recruitmen.view_transkrip');
    Route::get('recruitmen/verify_recruitmen/{id}', [RecruitmentController::class, 'verify_doc'])->name('admin.recruitmen.verify_recruitmen');
    Route::get('recruitmen/tolak_recruitmen/{id}', [RecruitmentController::class, 'reject_doc'])->name('admin.recruitmen.tolak_doc');
    Route::get('recruitmen/send_doc/{id}', [RecruitmentController::class, 'send_doc'])->name('admin.recruitmen.send_recruitmen');
    
    // Route untuk ekspor data rekruter
    Route::get('recruitmen/export', [RecruitmentController::class, 'export_recruitment'])->name('admin.export_recruitmen');
    
    // Route untuk mencari data rekrutmen
    Route::get('recruitment/search', [RecruitmentController::class, 'search'])->name('admin.recruitment.search');
    
    // Edit and Update the data recruitment not status
    Route::get('recruitmen/edit_rekrutmen/{id}', [RecruitmentController::class, 'edit_doc'])->name('admin.recruitmen.edit_rekrutmen');
    Route::post('recruitmen/update_rekrutmen/{id}', [RecruitmentController::class, 'update_doc'])->name('admin.recruitmen.update_rekrutmen');
    
    // Edit and Update the data recruitment and status
    Route::get('recruitment/editQuickRecruitment/{id}', [RecruitmentController::class, 'editQuickRecruitment'])->name('admin.recruitment.editQuickRecruitment');
    Route::post('recruitment/updateQuickRecruitment/{id}', [RecruitmentController::class, 'updateQuickRecruitment'])->name('admin.recruitment.updateQuickRecruitment');
    
    // Route untuk halaman psikotes di admin
    Route::get('psikotes', [PsikotesController::class, 'index'])->name('admin.psikotes');
    Route::get('psikotes/add_psikotes', [PsikotesController::class, 'tambah_psikotes'])->name('admin.psikotes.add_psikotes');
    Route::post('psikotes/save_psikotes', [PsikotesController::class, 'save_psikotes'])->name('admin.psikotes.save_psikotes');
    Route::get('psikotes/view_psikotes/{id}', [PsikotesController::class, 'view_psikotes'])->name('admin.psikotes.view_psikotes');
    Route::get('psikotes/acc_psikotes/{id}', [PsikotesController::class, 'acc_psikotes'])->name('admin.psikotes.acc_psikotes');
    Route::get('psikotes/reject_psikotes/{id}', [PsikotesController::class, 'tolak_psikotes'])->name('admin.psikotes.reject_psikotes');
    Route::get('psikotes/send_psikotes/{id}', [PsikotesController::class, 'send_psikotes'])->name('admin.psikotes.send_psikotes');

    // Edit and Update for data and not the status 
    Route::get('psikotes/edit_psikotes/{id}', [PsikotesController::class, 'edit_psikotes'])->name('admin.psikotes.edit_psikotes');
    Route::post('psikotes/update_psikotes/{id}', [PsikotesController::class, 'update_psikotes'])->name('admin.psikotes.update_psikotes');

    Route::get('psikotes/search', [PsikotesController::class, 'search'])->name('admin.psikotes.search');
    
    // Edit and Update Psikotes for the status approval approved
    Route::get('psikotes/editQuickPsikotes/{id}', [PsikotesController::class, 'editQuickPsikotes'])->name('admin.psikotes.editQuickPsikotes');
    Route::post('psikotes/updateQuickPsikotes/{id}', [PsikotesController::class, 'updateQuickPsikotes'])->name('admin.psikotes.updateQuickPsikotes');
    
    // Route untuk export data psikotes
    Route::get('psikotes/export', [PsikotesController::class, 'export_psikotes'])->name('admin.export_psikotes');

    // Route untuk hasil tes di admin
    Route::get('surat_penerimaan', [HasilTesController::class, 'index'])->name('admin.hasil_tes');
    Route::get('surat_penerimaan/add_surat_penerimaan', [HasilTesController::class, 'add_surat_penerimaan'])->name('admin.hasil_tes.add_surat_penerimaan');
    Route::post('surat_penerimaan/save_surat_penerimaan', [HasilTesController::class, 'save_surat_penerimaan'])->name('admin.hasil_tes.save_surat_penerimaan');
    Route::get('surat_penerimaan/view_surat_penerimaan/{id}', [HasilTesController::class, 'view_surat_penerimaan'])->name('admin.hasil_tes.view_surat_penerimaan');
    Route::get('surat_penerimaan/acc_surat_penerimaan/{id}', [HasilTesController::class, 'acc_surat_penerimaan'])->name('admin.hasil_tes.acc_surat_penerimaan');
    Route::get('surat_penerimaan/tolak_surat_penerimaan/{id}', [HasilTesController::class, 'tolak_surat_penerimaan'])->name('admin.hasil_tes.tolak_surat_penerimaan');
    Route::get('surat_penerimaan/send_surat_penerimaan/{id}', [HasilTesController::class, 'kirim_surat_penerimaan'])->name('admin.hasil_tes.send_surat_penerimaan');
    
    
    Route::get('surat_penerimaan/edit_surat_penerimaan/{id}', [HasilTesController::class, 'editSuratPenerimaan'])->name('admin.hasil_tes.editSuratPenerimaan');
    Route::get('surat_penerimaan/update_surat_penerimaan/{id}', [HasilTesController::class, 'updateSuratPenerimaan'])->name('admin.hasil_tes.editSuratPenerimaan');
    
    // Route untuk export data hasil tes atau hasil penerimaan
    Route::get('surat_penerimaan/export', [HasilTesController::class, 'export_hasil_tes'])->name('admin.export_surat_penerimaan');
});

// Halaman Pelamar 
Route::prefix('pelamar')->middleware(['auth', 'pelamar'])->group(function () {
    Route::get('beranda', [PelamarBerandaController::class, 'index'])->name('karyawan.beranda');
    
    // Route untuk melakukan update profile sebelum melakukan rekrutmen
    Route::get('beranda/profile', [PelamarBerandaController::class, 'profile'])->name('pelamar.profile');
    Route::post('beranda/profile/update_profile/{id}', [PelamarBerandaController::class, 'update_profile'])->name('pelamar.profile.update_profile');

    // Route untuk menambahkan fitur recruitmen
    Route::get('recruitmen', [RecruitmenController::class, 'index'])->name('karyawan.recruitmen');
    Route::get('recruitmen/add_recruitmen', [RecruitmenController::class, 'add_recruitmen'])->name('karyawan.recruitmen.add_recruitmen');
    Route::post('recruitmen/save_recruitmen', [RecruitmenController::class, 'save_recruitmen'])->name('karyawan.recruitmen.save_recruitmen');
    
    // Route untuk pelamar yang mengajukan lamarannya
    Route::get('recruitment/create_new_recruitment/{id}', [RecruitmenController::class, 'create_recruitment'])->name('pelamar.recruitment.create_quick_recruitment');
    Route::post('recruitment/save_new_recruitment', [RecruitmenController::class, 'store_recruitment'])->name('pelamar.recruitment.save_quick_recruitment');

    // Route untuk mendapatkan PiC dari departemen
    Route::get('recruitmen/getPIC', [RecruitmenController::class, 'getPiC'])->name('karyawan.recruitmen.getPiC');

    // Route untuk ubah password di halaman karyawan
    Route::get('ubah-pwd', [PelamarBerandaController::class, 'ubah_pwd'])->name('karyawan.ubah-pwd');
    Route::post('ubah-pwd', [PelamarBerandaController::class, 'change_pwd'])->name('karyawan.change-pwd');

    // Route untuk melihat dokumen lamaran dari pelamar
    Route::get('recruitmen/view_doc/{id}', [RecruitmenController::class, 'view_doc'])->name('karyawan.recruitmen.view_doc');

    // Route untuk halaman psikotes
    Route::get('psikotes', [PelamarPsikotesController::class, 'index'])->name('pelamar.psikotes');
    Route::get('psikotes/view_psikotes/{id}', [PelamarPsikotesController::class, 'view_psikotes'])->name('pelamar.psikotes.view_psikotes');

    // Route untuk halaman surat penerimaan dari pelamar
    Route::get('surat_penerimaan', [PelamarHasilTesController::class, 'index'])->name('karyawan.surat_penerimaan');
    Route::get('surat_penerimaan/view_surat_penerimaan/{id}', [PelamarHasilTesController::class, 'view_surat_penerimaan'])->name('karyawan.surat_penerimaan.view_surat_penerimaan');
});

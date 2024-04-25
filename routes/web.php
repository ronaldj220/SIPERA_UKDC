<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\BerandaController;
use App\Http\Controllers\Admin\DepartemenController;
use App\Http\Controllers\Admin\HasilTesController;
use App\Http\Controllers\Admin\PelamarController;
use App\Http\Controllers\Admin\PsikotesController;
use App\Http\Controllers\Admin\RecruitmentController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Auth\LoginController;
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

Route::get('/', [LoginController::class, 'home'])->name('home');

// Route untuk halaman login
Route::get('login', [LoginController::class, 'index'])->name('login')->middleware('guest');
Route::post('login', [LoginController::class, 'aksilogin'])->name('aksilogin');
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

    // Route untuk halaman recruiter
    Route::get('recruitmen', [RecruitmentController::class, 'index'])->name('admin.recruitmen');
    Route::get('recruitmen/view_recruitmen/{id}', [RecruitmentController::class, 'view_recruitmen'])->name('admin.recruitmen.view_recruitmen');
    Route::get('recruitmen/verify_recruitmen/{id}', [RecruitmentController::class, 'verify_doc'])->name('admin.recruitmen.verify_recruitmen');
    Route::get('recruitmen/tolak_recruitmen/{id}', [RecruitmentController::class, 'reject_doc'])->name('admin.recruitmen.tolak_doc');
    Route::get('recruitmen/edit_rekrutmen/{id}', [RecruitmentController::class, 'edit_doc'])->name('admin.recruitmen.edit_rekrutmen');
    Route::post('recruitmen/update_rekrutmen/{id}', [RecruitmentController::class, 'update_doc'])->name('admin.recruitmen.update_rekrutmen');
    Route::get('recruitmen/send_doc/{id}', [RecruitmentController::class, 'send_doc'])->name('admin.recruitmen.send_recruitmen');

    // Route untuk halaman psikotes di admin
    Route::get('psikotes', [PsikotesController::class, 'index'])->name('admin.psikotes');
    Route::get('psikotes/add_psikotes', [PsikotesController::class, 'tambah_psikotes'])->name('admin.psikotes.add_psikotes');
    Route::post('psikotes/save_psikotes', [PsikotesController::class, 'save_psikotes'])->name('admin.psikotes.save_psikotes');
    Route::get('psikotes/view_psikotes/{id}', [PsikotesController::class, 'view_psikotes'])->name('admin.psikotes.view_psikotes');
    Route::get('psikotes/acc_psikotes/{id}', [PsikotesController::class, 'acc_psikotes'])->name('admin.psikotes.acc_psikotes');
    Route::get('psikotes/reject_psikotes/{id}', [PsikotesController::class, 'reject_prikotes'])->name('admin.psikotes.reject_psikotes');
    Route::get('psikotes/send_psikotes/{id}', [PsikotesController::class, 'send_psikotes'])->name('admin.psikotes.send_psikotes');

    // Route untuk hasil tes di admin
    Route::get('surat_penerimaan', [HasilTesController::class, 'index'])->name('admin.hasil_tes');
    Route::get('surat_penerimaan/add_surat_penerimaan', [HasilTesController::class, 'add_surat_penerimaan'])->name('admin.hasil_tes.add_surat_penerimaan');
    Route::post('surat_penerimaan/save_surat_penerimaan', [HasilTesController::class, 'save_surat_penerimaan'])->name('admin.hasil_tes.save_surat_penerimaan');
    Route::get('surat_penerimaan/view_surat_penerimaan/{id}', [HasilTesController::class, 'view_surat_penerimaan'])->name('admin.hasil_tes.view_surat_penerimaan');
    Route::get('surat_penerimaan/acc_surat_penerimaan/{id}', [HasilTesController::class, 'acc_surat_penerimaan'])->name('admin.hasil_tes.acc_surat_penerimaan');
    Route::get('surat_penerimaan/send_surat_penerimaan/{id}', [HasilTesController::class, 'kirim_surat_penerimaan'])->name('admin.hasil_tes.send_surat_penerimaan');
});

// Halaman Pelamar 
Route::prefix('pelamar')->middleware(['auth', 'pelamar'])->group(function () {
    Route::get('beranda', [PelamarBerandaController::class, 'index'])->name('karyawan.beranda');

    // Route untuk menambahkan fitur recruitmen
    Route::get('recruitmen', [RecruitmenController::class, 'index'])->name('karyawan.recruitmen');
    Route::get('recruitmen/add_recruitmen', [RecruitmenController::class, 'add_recruitmen'])->name('karyawan.recruitmen.add_recruitmen');
    Route::post('recruitmen/save_recruitmen', [RecruitmenController::class, 'save_recruitmen'])->name('karyawan.recruitmen.save_recruitmen');

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

// Route untuk Karyawan
Route::prefix('karyawan')->middleware(['auth', 'karyawan'])->group(function () {
    // ... Definisi route untuk karyawan
    Route::get('beranda', [KaryawanBerandaController::class, 'index'])->name('krywn.beranda');
});

// Route untuk Dosen
Route::prefix('dosen')->middleware(['auth', 'dosen'])->group(function () {
    Route::get('beranda', [DosenBerandaController::class, 'index'])->name('dosen.beranda');
});

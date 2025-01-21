<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Admin\Lowongan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;
use Illuminate\Support\Str;


class LowonganController extends Controller
{
    public function index()
    {
        $title = 'Lowongan';
        $admin = User::join('role_has_users', 'users.id', '=', 'role_has_users.fk_user')
            ->join('role', 'role_has_users.fk_role', '=', 'role.id')
            ->where('role_has_users.fk_role', 1)
            ->select('users.*', 'role.role as role_name')
            ->first();
        $lowongan = Lowongan::sortable()->paginate(5);

        // Menyimpan hasil decode dari base64 untuk setiap lowongan
        $decodedImages = [];

        foreach ($lowongan as $item) {
            // Decode base64 menjadi string biner (normal)
            $imgBase64Lowongan = base64_decode($item->img_base_64);

            // Simpan hasil decode di array untuk ditampilkan
            $decodedImages[] = $imgBase64Lowongan;
        }

        return view('halaman_admin.lowongan.index', [
            'title' => $title,
            'admin' => $admin,
            'lowongan' => $lowongan
        ]);
    }

    public function search(Request $request)
    {
        // Get the search query from the 'q' parameter
        $query = $request->input('q');

        // Retrieve lowongan based on the search query
        $lowongan = Lowongan::where('name_lowongan', 'like', '%' . $query . '%')->paginate(10);

        // Return the results as JSON
        return response()->json($lowongan);
    }

    public function add_lowongan()
    {
        $title = 'Tambah Lowongan';
        $admin = User::join('role_has_users', 'users.id', '=', 'role_has_users.fk_user')
            ->join('role', 'role_has_users.fk_role', '=', 'role.id')
            ->where('role_has_users.fk_role', 1)
            ->select('users.*', 'role.role as role_name')
            ->first();
        // Mendapatkan URL saat ini
        $currentUrl = url()->current();

        // Memotong hanya bagian domain dari URL
        $parsedUrl = parse_url($currentUrl);

        // Menghasilkan hanya domain
        $baseUrl = $parsedUrl['scheme'] . '://' . $parsedUrl['host'];
        return view('halaman_admin.lowongan.add_lowongan', [
            'title' => $title,
            'admin' => $admin,
            'baseUrl' => $baseUrl
        ]);
    }

    public function save_lowongan(Request $request)
    {
        // Validasi input
        $request->validate([
            'name_lowongan' => 'required|string|max:255',
            'created_at' => 'required|date',
            'expired_at' => 'required|date|after:created_at',
            'img_lowongan' => 'required|mimes:jpg,jpeg,png|max:2048|unique:lowongan,img_base_64',
            'desc_lowongan' => 'required'
        ], [
            'img_lowongan.required' => 'Harap upload poster untuk lowongan!',
            'img_lowongan.mimes' => 'Poster Lowongan Harus Berformat JPG, PNG, JPEG!',
            'img_lowongan.max' => 'Ukuran Poster Lowongan Tidak Boleh Lebih dari 2MB!',
            'img_lowongan.unique' => 'Poster ini Telah Tersedia! Harap gunakan Poster Lainnya!',
            'name_lowongan.required' => 'Lowongan Wajib Diisi!',
            'created_at.required' => 'Tanggal Pembuatan Poster Lowongan Wajib Diisi!',
            'expired_at.required' => 'Tanggal Kadaluarsa Wajib Diisi!',
            'desc_lowongan.required' => 'Deskripsi Lowongan Wajib Diisi!'
        ]);

        // Ambil data yang divalidasi
        $nameLowongan = $request->input('name_lowongan');
        $createdDate = $request->input('created_at');
        $expiredDate = $request->input('expired_at');
        $descLowongan = $request->input('desc_lowongan');
        $posterLowongan = $request->file('img_lowongan'); // Ambil file yang diupload

        // Simpan input ke dalam session
        session()->put([
            'name_lowongan' => $request->input('name_lowongan'),
            'desc_lowongan' => $request->input('desc_lowongan'),
            'lokasi_lowongan' => $request->input('lokasi_lowongan'),
            'created_at' => $request->input('created_at'),
            'expired_at' => $request->input('expired_at'),
        ]);

        // Mengonversi file ke base64
        $posterBase64 = base64_encode(file_get_contents($posterLowongan->getRealPath()));


        // Convert name_lowongan to camel case
        $camelCaseNameLowongan = Str::camel($nameLowongan);

        // Format the dates to DD-MM-YYYY (instead of slashes for folder compatibility)
        $formattedCreatedDate = Carbon::parse($createdDate)->format('d-m-Y');
        $formattedExpiredDate = Carbon::parse($expiredDate)->format('d-m-Y');

        // Membuat nama folder: nameLowongan(24-09-2024 - 25-09-2024)
        $folderName = $camelCaseNameLowongan . '(' . $formattedCreatedDate . ' - ' . $formattedExpiredDate . ')';

        // Tentukan path untuk menyimpan folder
        $path = public_path('uploads/lowongan/' . $folderName);

        // Cek apakah folder sudah ada, jika belum buat folder
        if (!File::exists($path)) {
            // Buat folder utama sekaligus subfolder CV dan Transkrip
            File::makeDirectory($path . '/CV(PDF)', 0777, true);  // Buat folder CV
            File::makeDirectory($path . '/Transkrip(PDF)', 0777, true);  // Buat folder Transkrip
        }

        // Membuat nama file unik untuk poster
        $posterFileName = time() . '.' . $posterLowongan->getClientOriginalExtension();

        // Pindahkan gambar ke folder utama
        $posterLowongan->move($path, $posterFileName);

        // Simpan data ke dalam tabel lowongan
        Lowongan::create([
            'img_base_64' => $posterBase64,
            'name_lowongan' => $nameLowongan,
            'lokasi_lowongan' => $request->input('lokasi_lowongan'),
            'description' => $descLowongan,
            'created_at' => $createdDate,
            'expired_at' => $expiredDate,
            'link_lowongan' => NULL
        ]);

        // Hapus data dari session setelah sukses
        session()->forget(['name_lowongan', 'desc_lowongan', 'lokasi_lowongan', 'created_at', 'expired_at']);

        // Response Success
        return redirect()->route('admin.lowongan')->with('toast_success', 'Lowongan Berhasil Ditambahkan!');
    }

    public function edit_lowongan($id)
    {
        $title = 'Edit Lowongan';
        $admin = User::join('role_has_users', 'users.id', '=', 'role_has_users.fk_user')
            ->join('role', 'role_has_users.fk_role', '=', 'role.id')
            ->where('role_has_users.fk_role', 1)
            ->select('users.*', 'role.role as role_name')
            ->first();
        $lowongan = Lowongan::findOrFail($id);
        // dd($lowongan);
        return view('halaman_admin.lowongan.edit_lowongan', [
            'title' => $title,
            'admin' => $admin,
            'lowongan' => $lowongan
        ]);
    }

    public function update_lowongan(Request $request, $id)
    {
        $nameLowongan = $request->input('name_lowongan');
        $createdDate = $request->input('created_at');
        $lokasiLowongan = $request->input('lokasi_lowongan');
        $expiredDate = $request->input('expired_at');
        $descLowongan = $request->input('desc_lowongan');
        $linkLowongan = $request->input('link_lowongan');

        // Cari posisi lamaran berdasarkan ID
        $lowongan = Lowongan::findOrFail($id);

        if (!$lowongan) {
            return redirect()->back()->with('error', 'Lowongan tidak ditemukan.');
        }

        $lowongan->update([
            'name_lowongan' => $nameLowongan,
            'lokasi_lowongan' => $lokasiLowongan,
            'description' => $descLowongan,
            'link_lowongan' => $linkLowongan,
            'created_at' => $createdDate,
            'expired_at' => $expiredDate
        ]);

        return redirect()->route('admin.lowongan')->with('toast_success', 'Poster Lowongan Berhasil Diperbarui!');
    }

    public function delete_lowongan($id)
    {
        try {
            $lowongan = Lowongan::find($id); // Cari data berdasarkan ID
            if (!$lowongan) {
                return response()->json(['message' => 'Data tidak ditemukan'], 404);
            }
            $lowongan->delete();
            return response()->json(['message' => 'Lowongan berhasil dihapus'], 200);
        } catch (\Exception $e) {
            return redirect()->route('admin.lowongan')->with('error', 'Gagal menghapus lowongan: ' . $e->getMessage());
        }
    }

    public function generateQRCode($id)
    {
        // Mendapatkan URL saat ini
        $currentUrl = url()->current();

        // Memotong hanya bagian domain dari URL
        $parsedUrl = parse_url($currentUrl);

        // Menghasilkan hanya domain
        $baseUrl = $parsedUrl['scheme'] . '://' . $parsedUrl['host'];

        // dd($baseUrl);

        $lowongan = Lowongan::findOrFail($id);

        $lowongan->update([
            'link_lowongan' => $baseUrl
        ]);
        return redirect()->back()->with('success', 'Link Poster Berhasil Diperbarui!');
    }
}

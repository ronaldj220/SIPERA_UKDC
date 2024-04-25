<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Admin\Role;
use App\Models\Role_Has_User;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function home()
    {
        if (Auth::check()) {
            // dd(Auth::user()->role_has_user[0]->fk_role);
            if (Auth::user()->role_has_user[0]->fk_role == 1) {
                return redirect()->route('admin.beranda');
            } elseif (Auth::user()->role_has_user[0]->fk_role == 2) {
                return redirect()->route('karyawan.beranda');
            } elseif (Auth::user()->role_has_user[0]->fk_role == 3) {
                return redirect()->route('karyawan.beranda');
            } elseif (Auth::user()->role_has_user[0]->fk_role == 4) {
                return redirect()->route('karyawan.beranda');
            }
        } else {
            return redirect()->route('login');
        }
    }
    public function index()
    {
        $title = 'Login';
        return view('auth.login', [
            'title' => $title
        ]);
    }
    public function aksilogin(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $remember = $request->has('remember');
        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            $user = Auth::user()->email;
            if ($user) {
                DB::table('users')->where('email', $user)->update([
                    'is_active' => 1
                ]);
            }
            return redirect()->route('home');
        } else {
            return back()->withErrors([
                'email' => 'Email atau Password salah! Silahkan Lakukan Login Kembali.',
            ]);
        }
    }
    public function logout(Request $request)
    {
        // Check if the user is authenticated
        if (Auth::check()) {
            // Update is_active to 0 for the authenticated user
            DB::table('users')->where('id', Auth::user()->id)->update([
                'is_active' => 0
            ]);
        }

        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
    public function sign_up()
    {
        $title = 'Sign Up';
        return view('auth.sign_up', [
            'title' => $title,
        ]);
    }
    public function proses_sign_up(Request $request)
    {
        // Validasi input
        $request->validate([
            'email' => 'unique:users,email'
        ], [
            'email.unique' => 'Email tidak boleh digunakan kedua kali!'
        ]);
        try {
            $data = [
                'email' => $request->input('email'),
                'nama' => $request->input('nama'),
                'password' => Hash::make($request->input('confirm_pwd')),
                'gender' => $request->input('jk'),
                'is_active' => 0
            ];
            // Buat data role berisi role dari masing-masing
            if ($data['gender'] == 'P') {
                $userId = User::create($data);
                Role_Has_User::create([
                    'fk_user' => $userId->id,
                    'fk_role' => 2
                ]);
            } elseif ($data['gender'] == 'W') {
                $userId = User::create($data);
                Role_Has_User::create([
                    'fk_user' => $userId->id,
                    'fk_role' => 2
                ]);
            }
            return redirect()->route('login')->with('toast_success', 'Anda Berhasil Daftar! Silahkan Login!');
        } catch (\Exception $e) {
            return redirect()->route('login')->with('toast_error', $e->getMessage());
        }
    }
}

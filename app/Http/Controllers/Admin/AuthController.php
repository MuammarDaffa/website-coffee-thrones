<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Menampilkan halaman login admin
     */
    public function showLogin()
    {
        return view('admin.login');
    }

    /**
     * Proses login admin
     */
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $admin = Admin::where('username', $request->username)->first();

        if ($admin && Hash::check($request->password, $admin->password)) {
            // Simpan session admin
            $request->session()->put('admin_id', $admin->id);
            $request->session()->put('admin_username', $admin->username);
            return redirect()->route('admin.dashboard')->with('success', 'Selamat datang, ' . $admin->username);
        } else {
            return back()->with('error', 'Username atau password salah');
        }
    }

    /**
     * Logout admin
     */
 public function logout(Request $request)
{
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect('/admin/login'); // ✅ arahkan ke route login admin yang benar
}


}

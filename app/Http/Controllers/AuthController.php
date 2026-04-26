<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Fungsi Login untuk mendapatkan Token.
     */
    public function login(Request $request)
    {
        // 1. Validasi Request
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // 2. Cari User berdasarkan email
        $user = User::where('email', $request->email)->first();

        // 3. Cek apakah user ada dan password cocok
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Kredensial yang Anda berikan salah.'
            ], 401);
        }

        // 4. Buat Token menggunakan Sanctum
        // Kita simpan role user di dalam nama token agar mudah diidentifikasi (opsional)
        $token = $user->createToken('auth_token')->plainTextToken;

        // 5. Kembalikan Response sukses beserta token dan data user (termasuk role)
        return response()->json([
            'message' => 'Login Berhasil',
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => [
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role, // Menampilkan role saat ini (admin/user)
            ]
        ]);
    }

    /**
     * Fungsi Logout untuk menghapus Token.
     */
    public function logout(Request $request)
    {
        // Menghapus token yang sedang digunakan saat ini
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logout berhasil, token telah dihapus.'
        ]);
    }
}
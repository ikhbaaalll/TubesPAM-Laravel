<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserControler extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only(['email', 'password']);

        if (!Auth::attempt($credentials)) {
            return response()->json(['msg' => 'Login Gagal', 'status' => false, 'error' => 'Akun tidak terdaftar', 'user' => null]);
        }

        $user = auth()->user();

        return response()->json(['msg' => 'Login Berhasil', 'status' => true, 'error' => null, 'user' => $user]);
    }

    public function register(Request $request)
    {
        $request->validate(
            [
                'nama'      => ['required'],
                'email'     => ['required', 'email', 'unique:users,email'],
                'password'  => ['required'],
                'kelas'     => ['required', 'numeric', 'min:1', 'max:6'],
            ]
        );

        $user = User::create($request->validated());

        return response()->json(['msg' => 'Akun berhasil dibuat', 'status' => true]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->flush();
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserControler extends Controller
{
    public function index(Request $request)
    {
        $users = User::where('kelas', $request->kelas)->where('role', 2)->latest()->get();

        return response()->json($users);
    }

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
        $error = 'Email telah digunakan';

        $email = User::where('email', $request->email)->first();

        if (!$email) {
            User::create(
                [
                    'nama'      => $request->nama,
                    'email'     => $request->email,
                    'password'  => bcrypt($request->password),
                    'kelas'     => $request->kelas
                ]
            );
            $error = null;
        }

        $response = array('error' => $error);

        return response()->json($response);
    }

    public function update(Request $request)
    {
        $error = 'Email telah digunakan';

        $email = User::where('id', $request->id)->where('email', $request->email)->first();

        if ($email) {
            User::where('id', $request->id)->update(
                [
                    'nama'      => $request->nama,
                    'email'     => $request->email,
                    'password'  => bcrypt($request->password),
                    'kelas'     => $request->kelas
                ]
            );
            $error = null;
        }

        $response = array('error' => $error);

        return response()->json($response);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->flush();
    }

    public function isAdmin(Request $request)
    {
        $user = User::where('id', $request->id)->first();

        $role = 0;

        if ($user->role == '1') {
            $role = 1;
        }

        $response = array('role' => $role);

        return response()->json($response);
    }

    public function destroy(Request $request)
    {
        User::where('id', $request->id)->delete();

        return response()->json("Sukses", 200);
    }
}

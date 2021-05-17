<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\Kelas;
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

    public function show(Request $request)
    {
        $user = User::where('id', $request->id)->first();

        $matematika = Kelas::where('pelajaran', "Matematika")
            ->where('kelas', $user->kelas)
            ->get()
            ->pluck('id')
            ->toArray();
        $totalMatematika = Absensi::whereIn('kelas_id', $matematika)
            ->where('user_id', $request->id)
            ->count();
        $presensiMatematika = Absensi::whereIn('kelas_id', $matematika)
            ->where('user_id', $request->id)
            ->where('status', 1)
            ->count();

        $bahasaInggris = Kelas::where('pelajaran', "Bahasa Inggris")
            ->where('kelas', $user->kelas)
            ->get()
            ->pluck('id')
            ->toArray();
        $totalBahasaInggris = Absensi::whereIn('kelas_id', $bahasaInggris)
            ->where('user_id', $request->id)
            ->count();
        $presensiBahasaInggris = Absensi::whereIn('kelas_id', $bahasaInggris)
            ->where('user_id', $request->id)
            ->where('status', 1)
            ->count();

        $bahasaIndonesia = Kelas::where('pelajaran', "Bahasa Indonesia")
            ->where('kelas', $user->kelas)
            ->get()
            ->pluck('id')
            ->toArray();
        $totalBahasaIndonesia = Absensi::whereIn('kelas_id', $bahasaIndonesia)
            ->where('user_id', $request->id)
            ->count();
        $presensiBahasaIndonesia = Absensi::whereIn('kelas_id', $bahasaIndonesia)
            ->where('user_id', $request->id)
            ->where('status', 1)
            ->count();

        $ipa = Kelas::where('pelajaran', "Ilmu Pengetahuan Alam")
            ->where('kelas', $user->kelas)
            ->get()
            ->pluck('id')
            ->toArray();
        $totalIpa = Absensi::whereIn('kelas_id', $ipa)
            ->where('user_id', $request->id)
            ->count();
        $presensiIpa = Absensi::whereIn('kelas_id', $ipa)
            ->where('user_id', $request->id)
            ->where('status', 1)
            ->count();

        $ips = Kelas::where('pelajaran', "Ilmu Pengetahuan Sosial")
            ->where('kelas', $user->kelas)
            ->get()
            ->pluck('id')
            ->toArray();
        $totalIps = Absensi::whereIn('kelas_id', $ips)
            ->where('user_id', $request->id)
            ->count();
        $presensiIps = Absensi::whereIn('kelas_id', $ips)
            ->where('user_id', $request->id)
            ->where('status', 1)
            ->count();

        $seni = Kelas::where('pelajaran', "Seni Budaya")
            ->where('kelas', $user->kelas)
            ->get()
            ->pluck('id')
            ->toArray();
        $totalSeni = Absensi::whereIn('kelas_id', $seni)
            ->where('user_id', $request->id)
            ->count();
        $presensiSeni = Absensi::whereIn('kelas_id', $seni)
            ->where('user_id', $request->id)
            ->where('status', 1)
            ->count();

        $pkn = Kelas::where('pelajaran', "Pendidikan Pancasila dan Kewarganegaraan")
            ->where('kelas', $user->kelas)
            ->get()
            ->pluck('id')
            ->toArray();
        $totalPkn = Absensi::whereIn('kelas_id', $pkn)
            ->where('user_id', $request->id)
            ->count();
        $presensiPkn = Absensi::whereIn('kelas_id', $pkn)
            ->where('user_id', $request->id)
            ->where('status', 1)
            ->count();

        $olahraga = Kelas::where('pelajaran', "Pendidikan Jasmani, Olahraga, dan Kesehatan")
            ->where('kelas', $user->kelas)
            ->get()
            ->pluck('id')
            ->toArray();
        $totalOlahraga = Absensi::whereIn('kelas_id', $olahraga)
            ->where('user_id', $request->id)
            ->count();
        $presensiOlahraga = Absensi::whereIn('kelas_id', $olahraga)
            ->where('user_id', $request->id)
            ->where('status', 1)
            ->count();

        $response = array(
            'user' => $user,

            'presensiMatematika' => $presensiMatematika,
            'absenMatematika' => $totalMatematika - $presensiMatematika,
            'persentaseMatematika' => $presensiMatematika / $totalMatematika * 100,

            'presensiBahasaInggris' => $presensiBahasaInggris,
            'absenBahasaInggris' => $totalBahasaInggris - $presensiBahasaInggris,
            'presentaseBahasaInggris' => $presensiBahasaInggris / $totalBahasaInggris * 100,

            'presensiBahasaIndonesia' => $presensiBahasaIndonesia,
            'absenBahasaIndonesia' => $totalBahasaIndonesia - $presensiBahasaIndonesia,
            'presentaseBahasaIndonesia' => $presensiBahasaIndonesia / $totalBahasaIndonesia * 100,

            'presensiIpa' => $presensiIpa,
            'absenIpa' => $totalIpa - $presensiIpa,
            'presentaseIpa' => $presensiIpa / $totalIpa * 100,

            'presensiIps' => $presensiIps,
            'absenIps' => $totalIps - $presensiIps,
            'presentaseIps' => $presensiIps / $totalIps * 100,

            'presensiSeni' => $presensiSeni,
            'absenSeni' => $totalSeni - $presensiSeni,
            'presentaseSeni' => $presensiSeni / $totalSeni * 100,

            'presensiPkn' => $presensiPkn,
            'absenPkn' => $totalPkn - $presensiPkn,
            'presentasePkn' => $presensiPkn / $totalPkn * 100,

            'presensiOlahraga' => $presensiOlahraga,
            'absenOlahraga' => $totalOlahraga - $presensiOlahraga,
            'presentaseOlahraga' => $presensiOlahraga / $totalOlahraga * 100,
        );

        return response()->json($response, 201);
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

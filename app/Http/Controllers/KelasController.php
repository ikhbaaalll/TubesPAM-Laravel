<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\Kelas;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use LaravelQRCode\Facades\QRCode;

class KelasController extends Controller
{
    public function index(Request $request)
    {
        $kelas = Kelas::where('pelajaran', $request->pelajaran)
            ->where('kelas', $request->kelas)->latest()->get();

        return response()->json($kelas);
    }

    public function store(Request $request)
    {
        DB::transaction(function () use ($request) {
            $kelas = Kelas::create(
                [
                    'user_id'       => $request->id,
                    'nama'          => $request->nama,
                    'kelas'         => $request->kelas,
                    'pelajaran'     => $request->pelajaran,
                    'tanggal'       => $request->tanggal,
                    'waktu'         => $request->waktu,
                    'created_at'    => now()->setTimezone('Asia/Jakarta')->toDateTimeString()
                ]
            );

            QRCode::text($kelas->id)->setOutfile($kelas->id . '.png')->png();

            Kelas::where('id', $kelas->id)->update(['qr_code' => secure_asset($kelas->id . '.png')]);

            $siswas = User::where('kelas', $kelas->user->kelas)
                ->where('role', 2)
                ->get();

            foreach ($siswas as $siswa) {
                Absensi::create(
                    [
                        'user_id'   => $siswa->id,
                        'kelas_id'  => $kelas->id,
                    ]
                );
            }
        });

        $response = array('msg' => 'Sukses membuat kelas', 'status' => true);

        return response()->json($response);
    }

    public function show(Request $request)
    {
        $kelas = Kelas::with('user')->where('id', $request->id)->first();
        $presensi = Absensi::with('user')->where('kelas_id', $request->id)->get();
        $totalPresensi = Absensi::with('user')->where('kelas_id', $request->id)->count();
        $totalHadir = Absensi::with('user')->where('kelas_id', $request->id)->where('status', 1)->count();

        $status = Absensi::where('kelas_id', $request->id)
            ->where('user_id', $request->user)
            ->first();

        $total = Absensi::where('kelas_id', $request->id)
            ->where('status', 0)
            ->count();

        $statusKelas = '';
        $waktu = $kelas->tanggal . ' ' . $kelas->waktu;

        if (Carbon::now()->setTimezone('Asia/Jakarta')->subHours(2)->format('Y-m-d H:i:s') > $waktu) {
            $statusKelas = 1;
        } else {
            $statusKelas = 0;
        }

        if (!$status || $status->status == '0') {
            $status = 0;
        } else {
            $status = $status->status;
        }

        $response = array(
            'kelas' => $kelas,
            'presensi' => $presensi,
            'status' => $status,
            'statusKelas' => $statusKelas,
            'total' => $total,
            'totalPresensi' => $totalPresensi,
            'totalHadir' => $totalHadir
        );

        return response()->json($response);
    }

    public function status(Request $request)
    {
        Kelas::where('id', $request->id)
            ->update(
                [
                    'status' => $request->status
                ]
            );

        $status = Kelas::where('id', $request->id)->first();

        $response = array('status' => $status);

        return response()->json($response);
    }

    public function presensiSiswa(Request $request)
    {
        $data = false;

        $kelas = Kelas::where('id', $request->id)->first();

        if ($kelas->status != '0') {
            Absensi::where('user_id', $request->user)
                ->where('kelas_id', $request->id)
                ->update(
                    [
                        'status' => '1'
                    ]
                );
            $data = true;
        }

        return response()->json($data, 200);
    }

    public function setPresensi(Request $request)
    {
        Absensi::where('id', $request->id)
            ->update(
                [
                    'status' => $request->status
                ]
            );

        $status = Absensi::where('id', $request->id)->first();

        $response = array('status' => $status->status);

        return response()->json($response);
    }

    public function getPresensi(Request $request)
    {
        $status = Absensi::where('id', $request->id)->first();

        $response = array('status' => $status->status);

        return response()->json($response);
    }

    public function destroy(Request $request)
    {
        Kelas::where('id', $request->id)->delete();

        return response()->json('Sukses', 201);
    }
}

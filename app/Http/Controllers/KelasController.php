<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\Kelas;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KelasController extends Controller
{
    public function index(Request $request)
    {
        $kelas = Kelas::where('pelajaran', $request->pelajaran)->latest()->get();

        return response()->json($kelas);
    }

    public function store(Request $request)
    {
        DB::transaction(function () use ($request) {
            $kelas = Kelas::create(
                [
                    'user_id'       => $request->id,
                    'nama'          => $request->nama,
                    'pelajaran'     => $request->pelajaran,
                    'tanggal'       => $request->tanggal,
                    'waktu'         => $request->waktu,
                    'created_at'    => now()->setTimezone('Asia/Jakarta')->toDateTimeString()
                ]
            );

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
        $presensi = Absensi::with(['user' => function ($query) use ($kelas) {
            $query->where('users.kelas', $kelas->user->kelas)
                ->where('users.role', 2);
        }])->where('kelas_id', $request->id)->get();

        $response = array('kelas' => $kelas, 'presensi' => $presensi);

        return response()->json($response);
    }

    public function update(Request $request)
    {
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

    public function destroy(Request $request)
    {
        Kelas::where('id', $request->id)->delete();

        $response = array('msg' => 'Sukses menghapus kelas');

        return response()->json($response, 201);
    }
}

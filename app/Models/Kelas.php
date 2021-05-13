<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nama',
        'pelajaran',
        'qr_code',
        'tanggal',
        'waktu'
    ];

    public function absen()
    {
        return $this->hasMany(Absensi::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

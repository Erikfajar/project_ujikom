<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class History extends Model
{
    use HasFactory;
    protected $table = 'history'; // NAMA TABLE YG DIGUNAKAN
    protected $guarded = ['id']; // MENGATUR HANYA COLUMN ID YANG TIDAK BOLEH DI ISI

    // MENGUBAH FORTMAT TANGGAL MENJADI INDONESIA
    protected $appends = ['tanggal_aktivitas_indo'];
    public function getTanggalAktivitasINdoAttribute()
    {
        return Carbon::parse($this->attributes['created_at'])->translatedFormat('d F Y - H:i');
    }

    // MENERIMA RELASI DARI TABLE USERS
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

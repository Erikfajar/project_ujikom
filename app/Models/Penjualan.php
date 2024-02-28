<?php

namespace App\Models;

use Carbon\Carbon; // USE UNTUK MENGGUNAKAN CARBON
use App\Traits\HasFormatRupiah; // USER FORMAT RUPIAH
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Penjualan extends Model
{
    use HasFactory;
    use HasFormatRupiah; // FORMAT RUPIAH
    protected $table = 'penjualan'; // NAMA TABLE YG DIGUNAKAN
    protected $guarded = ['id']; // MENGATUR HANYA COLUMN ID YANG TIDAK BOLEH DI ISI

    // MENGUBAH FORTMAT TANGGAL MENJADI INDONESIA
    protected $appends = ['tanggal_penjualan_indo'];
    public function getTanggalPenjualanINdoAttribute()
    {
        return Carbon::parse($this->attributes['tanggal_penjualan'])->translatedFormat('d F Y');
    }

    // MENERIMA RELASI DARI TABLE PELANGGAN
    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class); // ONE TO ONE
    }

    // MENGIRIMKAN RELASI KE TABLE DETAILPENJUALAN
    public function detailpenjualan()
    {
        return $this->hasMany(DetailPenjualan::class); // ONE TO MANY
    }
}

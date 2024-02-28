<?php

namespace App\Models;

use App\Traits\HasFormatRupiah; // USER FORMAT RUPIAH
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPenjualan extends Model
{
    use HasFactory;
    use HasFormatRupiah; // FORMAT RUPIAH
    protected $table = 'detail_penjualan'; // NAMA TABLE YG DIGUNAKAN
    protected $guarded = ['id']; // MENGATUR HANYA COLUMN ID YANG TIDAK BOLEH DI ISI

    // MENERIMA RELASI DARI TABLE PENJUALAN
    public function penjualan()
    {
        return $this->belongsTo(penjualan::class);// MANY TO ONE/ONE TO MANY
    }

    // MENERIMA RELASI DARI TABLE PRDUK
    public function produk()
    {
        return $this->belongsTo(Produk::class);// MANY TO ONE/ONE TO MANY
    }
}

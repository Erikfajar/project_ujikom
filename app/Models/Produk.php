<?php

namespace App\Models;

use App\Traits\HasFormatRupiah; // USE FORMAT RUPIAH
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;
    use HasFormatRupiah; // FORMAT RUPIAH
    protected $table = 'produk'; // NAMA TABLE YG DIGUNAKAN
    protected $guarded = ['id']; // MENGATUR HANYA COLUMN ID YANG TIDAK BOLEH DI ISI

    // MENGIRIM RELASI KE TABLE DETAIL PENJUALAN
    public function detailpenjualan()
    {
        return $this->hasOne(DetailPenjualan::class); // ONE TO ONE
    }
}

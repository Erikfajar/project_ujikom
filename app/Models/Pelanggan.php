<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelanggan extends Model
{
    use HasFactory;
    protected $table = 'pelanggan'; // NAMA TABLE YG DIGUNAKAN
    protected $guarded = ['id']; // MENGATUR HANYA COLUMN ID YANG TIDAK BOLEH DI ISI

    // MENGIRIM RELASI KE TABLE PENJUALAN
    public function penjualan()
    {
        return $this->hasOne(penjualan::class); // ONE TO ONE
    }


}

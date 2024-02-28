<?php

namespace App\Traits;

trait HasFormatRupiah
{
    // function formatRupiah($field, $prefix = null)
    // {
    //     $prefix = $prefix ? $prefix : 'Rp. ';
    //     $nominal = $this->attributes[$field];
    //     return $prefix . number_format($nominal, 0, ',', '.');
    //     // return $prefix. number_format('Rp.');
    // }

    #-> MEMBUAT DETING FORMAT RUPIAH
    function formatRupiah($field, $prefix = 'Rp. ')
    {
        $nominal = $this->attributes[$field];
        return $prefix . str_replace(',', '.', number_format($nominal, 2, ',', '.'));
    }
}

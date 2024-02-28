<?php

namespace App\Http\Controllers;

use App\Models\DetailPenjualan;
use App\Models\Pelanggan;
use App\Models\Penjualan;
use App\Models\Produk;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    // UNTUK MENMAPILKAN DASHBOARD
    public function index(Request $request)
    {
        #GRAFIK PELANGGAN PER-BULAN -------------------------------------------------------------------------------------
        $GrafikA = "";
        for ($i = 1; $i <= 12; $i++) {
            $queryA = Pelanggan::select('*')->whereRaw('MONTH(created_at)=' . $i . '')->count();
            $GrafikA .= "{$queryA},";
        }
        $dataGrafikA = rtrim($GrafikA, ',');
        #END GRAFIK------------------------------------------------------------------------------------------------------------

        #GRAFIK PRODUK PER-BULAN -------------------------------------------------------------------------------------
        $GrafikB = "";
        for ($i = 1; $i <= 12; $i++) {
            $queryB = Produk::select('*')->whereRaw('MONTH(created_at)=' . $i . '')->count();
            $GrafikB .= "{$queryB},";
        }
        $dataGrafikB = rtrim($GrafikB, ',');
        #END GRAFIK------------------------------------------------------------------------------------------------------------

         #GRAFIK PENJUALAN PER-BULAN -------------------------------------------------------------------------------------
         $GrafikC = "";
         for ($i = 1; $i <= 12; $i++) {
             $queryC = Penjualan::select('*')->whereRaw('MONTH(tanggal_penjualan)=' . $i . '')->count();
             $GrafikC .= "{$queryC},";
         }
         $dataGrafikC = rtrim($GrafikC, ',');
         #END GRAFIK------------------------------------------------------------------------------------------------------------

        $dtKeuanganPenjualan = Penjualan::sum('total_harga');
        // Ubah format menjadi mata uang Rupiah dengan penambahan titik sebagai pemisah ribuan
        $dtKeuangan = "Rp " . number_format($dtKeuanganPenjualan, 2, ',', '.');
        $dtPenjualan = Penjualan::count();
        $dtProduk = Produk::count();
        $dtPelanggan = Pelanggan::count();
        $dtUserAdmin = User::where('role', 'administrator')->count();
        $dtUserPetugas = User::where('role', 'petugas')->count();
        $dtTerakhirUser = User::latest()->paginate(5);
        return view(
            'dashboard.index',
            compact('dataGrafikA', 'dataGrafikB','dataGrafikC', 'dtPelanggan', 'dtProduk', 'dtPenjualan', 'dtKeuangan', 'dtUserAdmin', 'dtUserPetugas', 'dtTerakhirUser')
        );
    }
}

<?php

namespace App\Http\Controllers\data;

use App\Models\Produk; // MODEL PRODUK
use App\Models\History; // MODEL HISTORY
use App\Models\DetailPenjualan; // MODEL DETAILPENJUALAN
use Illuminate\Http\Request; // UNTUK MENJALANKAN REQUEST
use App\Http\Controllers\Controller; // BAWAAN
use Illuminate\Support\Facades\Auth; // UNTUK MEMANGGIL USER YG SEDANG LOGIN

class DetailPenjualanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    // MENAMPILKAN DETAIL PENJUALAN
    public function show($id)
    {
        $detailPenjualan = DetailPenjualan::with('penjualan', 'produk')->where('penjualan_id', $id)->get();
        return view('data.detail_penjualan.index', compact('detailPenjualan'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

     // PROSES TAMPILAN EDIT
    public function edit($id)
    {
        $produk = Produk::all(); // MENAMPILKAN DATA PRODUK
        $dt = DetailPenjualan::find($id); // MENCARI DATA YANG SESUAI ID
        return view('data.detail_penjualan.form_edit', compact('produk', 'dt')); // PROSES MENAMPILKAN DATA DAN HALAMAN
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

     // PROSES UPDATE DATA
    public function update(Request $request, $id)
    {
        // VALIDASI DATA YANG MASUK
        $request->validate([
            'produk_id' => 'required',
            'jumlah_produk' => 'required|integer',
        ], [
            'produk_id.required' => 'Produk harus di isi',
            'jumlah_prdouk.required' => 'Jumlah Produk harus di isi',
            'jumlah_prdouk.integer' => 'Jumlah Produk harus berupa Angka'
        ]);

        // KONDISI STOK DAN JUMLAH PRODUK
        $produk = $request->input('produk_id'); // MENGAMBIL REQUEST INPUT PRODUK_ID
        $jumlah_produk = $request->input('jumlah_produk'); // MENGAMBIL REQUEST INPUT JUMLAH_PRODUK
        $cariProdukId = Produk::where('id', $produk)->first()->stok; // MENCARI DATA MELALUI PRODUK_ID
        $cariProdukNama = Produk::where('id', $produk)->first()->nama_produk; // MENCARI DATA MELALUI PRODUK_ID
        if ($jumlah_produk > $cariProdukId) {
            return back()->with('failed', 'Stok' . ' ' . $cariProdukNama . ' ' . 'hanya' . ' ' . $cariProdukId);
        }

        // MENAMPUNG SEMUA REQUEST KE DALAM VARIABEL
        $data = [
            'produk_id' => $request->produk_id,
            'jumlah_produk' => $request->jumlah_produk,
            'sub_total' => $request->sub_total,
            'penjualan_id' => $request->penjualan_id,
        ];

        // PROSES UPDATE DATA
        DetailPenjualan::find($id)->update($data);

        #PROSES SIMPAN HISTORY----------------------------------------
        $user = Auth::user()->id;
        $history = [
            'user_id' => $user,
            'aktivitas' => 'Melakukan Update data Detail Penjualan'
        ];
        History::create($history);
        #END PROSES SIMPAN HISTORY----------------------------------------

        // DI ARAHKAN KE HALAMAN DATA PENJUALAN
        return redirect()->route('data_penjualan.index')->with('success', 'Detail Penjualan berhasil di update');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // PROSES MENCARI ID YANG MAU DI DELETE LALU MENDELETE
        DetailPenjualan::find($id)->delete();

        #PROSES SIMPAN HISTORY----------------------------------------
        $user = Auth::user()->id;
        $history = [
            'user_id' => $user,
            'aktivitas' => 'Melakukan delete data Detail Penjualan'
        ];
        History::create($history);
        #END PROSES SIMPAN HISTORY----------------------------------------

        // DI ARAHKAN KE HALAMAN SEMULA
        return back()->with('success', 'Data berhasil di hapus');
    }
}

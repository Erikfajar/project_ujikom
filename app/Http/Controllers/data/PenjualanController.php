<?php

namespace App\Http\Controllers\data;

use App\Models\Produk;
use App\Models\History;
use App\Models\Penjualan;
use Illuminate\Http\Request;
use App\Models\DetailPenjualan;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\DataPenjualanExportView;
use App\Models\Pelanggan;
use Barryvdh\DomPDF\Facade\Pdf;// USE DOMPDF

class PenjualanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     // MENAMPILKAN TAMPILAN DATA PENJUALAN
    public function index()
    {
        $produk = Produk::all(); // MENGAMBIL DATA PRODUK
        $penjualan = Penjualan::with('pelanggan')->latest()->get(); // MENGAMBIL DATA PENJUALAN
        return view('data.penjualan.index',compact('penjualan','produk')); // MENAMPILKAN HALAMAN DAN DATA YANG SUDAH DI AMBIL
    }

    // MENAMPILKAN TAMPILAN FORM TRANSAKSI 
    public function pembelian($id)
    {
        $produk = Produk::all(); // MENGAMBIL DATA PRODUK
        $penjualan = Penjualan::find($id); // MENGAMBIL DATA PENJUALAN SESUAI DENGAN ID
        return view('data.penjualan.pembelian_produk',compact('produk','penjualan')); // MENAMPILKAN HALAMAN DAN DATA YANG SUDAH DI AMBIL
    }

    // PROSES TRANSAKSI
    public function transaksi($id)
    {
        $dataTransaksi = [
            'status_pembelian' => 'sudah'
        ];

        Penjualan::where('id',$id)->update($dataTransaksi);
        return back()->with('success','Berhasil melakukan transaksi');
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $pelanggan = Pelanggan::all();
        return view('data.penjualan.form_create',compact('pelanggan'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

     public function simpan_penjualan(Request $request)
     {
        $request->validate([
            'tanggal_penjualan' => 'required',
            'pelanggan_id' => 'required',

        ],[
            'tanggal_penjualan.required' => 'Tanggal penjualan harus di isi',
            'pelanggan_id.required' => 'Pelanggan harus di isi'
        ]);

        $data = [
            'tanggal_penjualan' => $request->tanggal_penjualan,
            'pelanggan_id' => $request->pelanggan_id,
            'total_harga' => 0.00,
        ];

        Penjualan::create($data);

           #PROSES SIMPAN HISTORY----------------------------------------
           $user = Auth::user()->id;
           $history = [
                'user_id' => $user,
                'aktivitas' => 'Melakukan Create data Penjualan'
            ];
            History::create($history);
            #END PROSES SIMPAN HISTORY----------------------------------------

        return redirect()->route('data_penjualan.index')->with('success','Data penjualan berhasil di buat');
     }

     // PROSES SIMPAN DATA KE DB
    public function store(Request $request)
    {
        // VALIDASI DATA TERLEBIH DAHULU
        $request->validate([
            'produk_id' => 'required',
            'jumlah_produk' => 'required',
        ],[
            'produk_id.required' => 'Produk tidak boleh kosong',
            'jumlah_produk.required' => 'Jumlah Produk tidak boleh kosong',
        ]);

        // // KONDISI STOK DAN JUMLAH PRODUK
        $produk = $request->input('produk_id'); // MENGAMBIL REQUEST INPUT PRODUK_ID
        $jumlah_produk = $request->input('jumlah_produk'); // MENGAMBIL REQUEST INPUT JUMLAH_PRODUK
        $cariProdukId = Produk::where('id',$produk)->first()->stok; // MENCARI DATA MELALUI PRODUK_ID
        $cariProdukNama = Produk::where('id',$produk)->first()->nama_produk; // MENCARI DATA MELALUI PRODUK_ID
        if ($jumlah_produk > $cariProdukId) {
            return back()->with('failed','Stok'. ' '.$cariProdukNama . ' '. 'hanya' .' '. $cariProdukId );
        }

        // MENAMPUNG ISI REQUEST KE VARIABEL DATA
        $data = [
            'produk_id' => $request->produk_id,
            'jumlah_produk' => $request->jumlah_produk,
            'sub_total' => $request->sub_total,
            'penjualan_id' => $request->penjualan_id,
        ];
       
        // PROSES SIMPAN DATA KE DB DETAIL_PENJUALAN
        DetailPenjualan::create($data);

         #PROSES SIMPAN HISTORY----------------------------------------
         $user = Auth::user()->id;
         $history = [
             'user_id' => $user,
             'aktivitas' => 'Melakukan Pembelian produk'
         ];
         History::create($history);
         #END PROSES SIMPAN HISTORY----------------------------------------

        // LALU DI ARAHKAN KE HALAMAN DATA PENJUALAN
        return redirect()->route('data_penjualan.index')->with('success','Pembelian berhasil');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $pelanggan = Pelanggan::all();
        $dt = Penjualan::find($id);
        return view('data.penjualan.form_edit',compact('pelanggan','dt'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'tanggal_penjualan' => 'required',
            'pelanggan_id' => 'required',

        ],[
            'tanggal_penjualan.required' => 'Tanggal penjualan harus di isi',
            'pelanggan_id.required' => 'Pelanggan harus di isi'
        ]);

        $data = [
            'tanggal_penjualan' => $request->tanggal_penjualan,
            'pelanggan_id' => $request->pelanggan_id,
        ];

        Penjualan::find($id)->update($data);
        
        #PROSES SIMPAN HISTORY----------------------------------------
        $user = Auth::user()->id;
        $history = [
             'user_id' => $user,
             'aktivitas' => 'Melakukan Update data Penjualan'
         ];
         History::create($history);
         #END PROSES SIMPAN HISTORY----------------------------------------
         
         return redirect()->route('data_penjualan.index')->with('success','Data penjualan berhasil di buat');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Penjualan::find($id)->delete();

         #PROSES SIMPAN HISTORY----------------------------------------
         $user = Auth::user()->id;
         $history = [
             'user_id' => $user,
             'aktivitas' => 'Melakukan Delete data Penjualan'
         ];
         History::create($history);
         #END PROSES SIMPAN HISTORY----------------------------------------

        return back()->with('success','Data berhasil di hapus');
    }

     // EXPORT PDF
     public function export_pdf()
     {

         #PROSES SIMPAN HISTORY----------------------------------------
         $user = Auth::user()->id;
         $history = [
             'user_id' => $user,
             'aktivitas' => 'Melakukan Export PDF data Penjualan'
         ];
         History::create($history);
         #END PROSES SIMPAN HISTORY----------------------------------------

         // MEMANGGIL DATA 
         $data = Penjualan::latest();
         $data = $data->get(); // MENGAMBIL DATA YANG SUDAH DIPANGGIL
 
         // MENGATUR HALAMAN YANG AKAN DI JAKIKAN EXPORT PDF
         $pdf = PDF::loadview('data.penjualan.exportPdf', ['data'=>$data]);
         $pdf->setPaper('a4', 'portrait'); // MENGATUR PAPER/KERTAS
         $pdf->setOption(['dpi' => 150, 'defaultFont' => 'sans-serif']);// MENGATUR FONT
         // SET FILE NAME
         $filename = date('YmdHis') . '_data_penjualan';// MENGATUR NAMA FILE PDF
         // Download the Pdf file
         return $pdf->download($filename.'.pdf');// PROSES DOWNLOAD FILE
     }
 
     // EXPORT EXCEL
     public function export_excel(Request $request)
     {

         #PROSES SIMPAN HISTORY----------------------------------------
         $user = Auth::user()->id;
         $history = [
             'user_id' => $user,
             'aktivitas' => 'Melakukan Export Excel data Penjualan'
         ];
         History::create($history);
         #END PROSES SIMPAN HISTORY----------------------------------------

         // MEMANGGIL DATA 
         $data = Penjualan::latest();
         $data = $data->get(); // MENGAMBIL DATA YANG SUDAH DI PANGGIL
 
         // Pass parameters to the export class
         $export = new DataPenjualanExportView($data);
         
         // SET FILE NAME
         $filename = date('YmdHis') . '_data_penjualan';// MENGATUR NAMA FILE
         
         // Download the Excel file
         return Excel::download($export, $filename . '.xlsx');// PROSES DOWNLOAD FILE
     }
}

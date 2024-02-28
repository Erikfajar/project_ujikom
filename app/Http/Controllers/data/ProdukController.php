<?php

namespace App\Http\Controllers\data;

use Exception;
use App\Models\Produk;
use App\Models\History;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\DataProdukExportView;
use App\Imports\ImportDataProdukClass;
use Barryvdh\DomPDF\Facade\Pdf; // USE DOMPDF

class ProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // MENAMPILKAN HALAMAN PRODUK
    public function index()
    {
        // PROSES MENGAMBIL DATA MELALUI MODEL
        $produk = Produk::with('detailpenjualan')->orderBy('nama_produk', 'asc')->get();
        // DI TAMPILKAN KE HALAMAN PRODUK
        return view('data.produk.index', compact('produk'));
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
    // FUNGSI UNTUK PROSES MENYIMPAN DATA KE KE DB
    public function store(Request $request)
    {

        // VALIDASI DATA YANG MASUK SESUAI KEBUTUHAN
        $request->validate([
            'nama_produk' => 'required',
            'harga' => 'required|max:7',
            'stok' => 'required|integer',
            'foto_produk' => 'nullable|image|mimes:jpg,png,jpeg|max:2000',
        ], [
            'nama_produk' => 'Nama Produk harus di isi',
            'harga.required' => 'Harga Produk harus di isi',
            'harga.max' => 'Harga Produk tidak boleh lebih dari 7 angka',
            'stok.required' => 'Stok Produk harus di isi',
            'foto_produk.mimes' => 'Foto hanya di perbolehkan ber ekstensi jpg,png,jpeg',
            'foto_produk.max' => 'Maksimal size Foto 2mb'
        ]);

        if ($request->hasFile('foto_produk')) {
            $foto_file = $request->file('foto_produk');
            $foto_extensi = $foto_file->extension();
            $foto_nama = date('ymdhis') . "." . $foto_extensi;
            $foto_file->move(public_path('image/foto_produk'), $foto_nama); // KONDISINYA SUDAH TER UPLOAD KE DIREKTORY

            $isiRequest = [
                'nama_produk' => $request->nama_produk,
                'harga' => $request->harga,
                'stok' => $request->stok,
                'foto_produk' => $foto_nama
            ];
        } else {
            // VARIABEL UNTUK MENAMPUNG REQUEST
            $isiRequest = [
                'nama_produk' => $request->nama_produk,
                'harga' => $request->harga,
                'stok' => $request->stok,
            ];
        }

        // PROSES SIMPAN DATA
        Produk::create($isiRequest);

        #PROSES SIMPAN HISTORY----------------------------------------
        $user = Auth::user()->id;
        $history = [
            'user_id' => $user,
            'aktivitas' => 'Melakukan Create data Produk'
        ];
        History::create($history);
        #END PROSES SIMPAN HISTORY----------------------------------------

        return back()->with('success', 'Data Produk berhasil di tambahkan');
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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // FUNGSI UNTUK PROSES MENYIMPAN UPDATE DATA KE KE DB
    public function update(Request $request, $id)
    {
        // VALIDASI DATA YANG MASUK SESUAI KEBUTUHAN
        $request->validate([
            'nama_produk' => 'required',
            'harga' => 'required|max:10',
            'stok' => 'required|integer',
            'foto_produk' => 'nullable|image|mimes:jpg,png,jpeg|max:2000',
        ], [
            'nama_produk' => 'Nama Produk harus di isi',
            'harga.required' => 'Harga Produk harus di isi',
            'harga.max' => 'Harga Produk tidak boleh lebih dari 10 angka',
            'stok.required' => 'Stok Produk harus di isi',
            'foto_produk.mimes' => 'Foto hanya di perbolehkan ber ekstensi jpg,png,jpeg',
            'foto_produk.max' => 'Maksimal size Foto 2mb'
        ]);

        if ($request->hasFile('foto_produk')) {
            $foto_file = $request->file('foto_produk');
            $foto_extensi = $foto_file->extension();
            $foto_nama = date('ymdhis') . "." . $foto_extensi;
            $foto_file->move(public_path('image/foto_produk'), $foto_nama); // KONDISINYA SUDAH TER UPLOAD KE DIREKTORY

            // HAPUS FOTO KALO USER MEMASUKAN FOTO BARU
            $data_foto = Produk::where('id', $id)->first();
            File::delete(public_path('image/foto_produk') . '/' . $data_foto->foto_produk);

            $isiRequest = [
                'nama_produk' => $request->nama_produk,
                'harga' => $request->harga,
                'stok' => $request->stok,
                'foto_produk' => $foto_nama
            ];
        } else {
            // dd($imageName);
            // VARIABEL UNTUK MENAMPUNG REQUEST
            $isiRequest = [
                'nama_produk' => $request->nama_produk,
                'harga' => $request->harga,
                'stok' => $request->stok,

            ];
        }

        // PROSES UPDATE DATA
        Produk::find($id)->update($isiRequest);

        #PROSES SIMPAN HISTORY----------------------------------------
        $user = Auth::user()->id;
        $history = [
            'user_id' => $user,
            'aktivitas' => 'Melakukan Update data Produk'
        ];
        History::create($history);
        #END PROSES SIMPAN HISTORY----------------------------------------

        return back()->with('success', 'Data Produk berhasil di update');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // PROSES DELETE DATA
    public function destroy($id)
    {
        $data = Produk::where('id', $id)->first();
        File::delete(public_path('image/foto_produk') . '/' . $data->foto_produk);
        // MENCARI DATA SESUAI ID LALU DI HAPUS
        Produk::find($id)->delete();

        #PROSES SIMPAN HISTORY----------------------------------------
        $user = Auth::user()->id;
        $history = [
            'user_id' => $user,
            'aktivitas' => 'Melakukan Delete data Produk'
        ];
        History::create($history);
        #END PROSES SIMPAN HISTORY----------------------------------------

        // MENGARAHKAN HALAMAN KE SEMULA
        return back()->with('success', 'Data Produk berhasil di delete');
    }

    public function export_pdf()
    {
        #PROSES SIMPAN HISTORY----------------------------------------
        $user = Auth::user()->id;
        $history = [
            'user_id' => $user,
            'aktivitas' => 'Melakukan Export PDF data Produk'
        ];
        History::create($history);
        #END PROSES SIMPAN HISTORY----------------------------------------

        $data = Produk::orderBy('nama_produk', 'asc');
        $data = $data->get();

        // Pass parameters to the export view
        $pdf = PDF::loadview('data.produk.exportPdf', ['data' => $data]);
        $pdf->setPaper('a4', 'portrait');
        $pdf->setOption(['dpi' => 150, 'defaultFont' => 'sans-serif']);
        // SET FILE NAME
        $filename = date('YmdHis') . '_data_produk';
        // Download the Pdf file
        return $pdf->download($filename . '.pdf');
    }

    // EXPORT EXCEL
    public function export_excel(Request $request)
    {

        #PROSES SIMPAN HISTORY----------------------------------------
        $user = Auth::user()->id;
        $history = [
            'user_id' => $user,
            'aktivitas' => 'Melakukan Export Excel data Produk'
        ];
        History::create($history);
        #END PROSES SIMPAN HISTORY----------------------------------------

        //QUERY
        $data = Produk::orderBy('nama_produk', 'asc');
        $data = $data->get();

        // Pass parameters to the export class
        $export = new DataProdukExportView($data);

        // SET FILE NAME
        $filename = date('YmdHis') . '_data_produk';

        // Download the Excel file
        return Excel::download($export, $filename . '.xlsx');
    }

    // IMPORT EXCEL
    public function import_excel(Request $request)
    {

        #PROSES SIMPAN HISTORY----------------------------------------
        $user = Auth::user()->id;
        $history = [
            'user_id' => $user,
            'aktivitas' => 'Melakukan Import Excel data Produk'
        ];
        History::create($history);
        #END PROSES SIMPAN HISTORY----------------------------------------

        //DECLARE REQUEST
        $file = $request->file('file');

        //VALIDATION FORM
        $request->validate([
            'file' => 'required|mimes:csv,xls,xlsx'
        ]);
        //  dd($file);
        try {
            if ($file) {
                // IMPORT DATA
                $import = new ImportDataProdukClass;
                Excel::import($import, $file);

                // SUCCESS
                $notimportlist = "";
                if ($import->listgagal) {
                    $notimportlist .= "<hr> Not Register : <br> {$import->listgagal}";
                }
                return back()
                    ->with('success', 'Import Data berhasil,<br>
                 Size ' . $file->getSize() . ', File extention ' . $file->extension() . ',
                 Insert ' . $import->insert . ' data, Update ' . $import->edit . ' data,
                 Failed ' . $import->gagal . ' data, <br> ' . $notimportlist . '');
            } else {
                // ERROR
                return back()
                    ->withInput()
                    ->with('error', 'Gagal memproses!');
            }
        } catch (Exception $e) {
            // ERROR
            return back()
                ->withInput()
                ->with('error', 'Gagal memproses!');
        }
    }
}

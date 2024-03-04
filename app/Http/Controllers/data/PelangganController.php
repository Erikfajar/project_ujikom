<?php

namespace App\Http\Controllers\data;

use Exception;
#-> USE KE MODEL ---------------
use App\Models\Pelanggan;
use App\Models\Penjualan;
use App\Models\History;
#-> END USE MODEL

#-> BAWAAN 
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
#-> END

#-> USE MAATWEBSITE EXCEL
use App\Exports\DataPelangganExportView;
use App\Imports\ImportDataPelangganClass;
use Maatwebsite\Excel\Facades\Excel;
#-> END USE MAATWEBSITE EXCEL
use Barryvdh\DomPDF\Facade\Pdf; // USE DOMPDF
use App\Exports\DataProdukExportView;
use Illuminate\Support\Facades\Auth;

class PelangganController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pelanggan = Pelanggan::with('penjualan')->orderBy('nama_pelanggan', 'asc')->get();
        return view('data.pelanggan.index', compact('pelanggan'));
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
        $request->validate(
            [
                'nama_pelanggan' => 'required',
                'alamat' => 'required',
                'nomor_telepon' => 'required|numeric',
                'nomor_telepon' => 'unique:pelanggan,nomor_telepon'
            ],

            // FUNGSI UNTUK MEMBERI TAU KALO ADA YANG TIDAK SESUAI WAKTU VALIDASI
            [
                'nama_pelanggan.required' => 'Nama Pelanggan harus di isi',
                'alamat.required' => 'Alamat harus di isi',
                'nomor_telepon.required' => 'No Telpn harus di isi',
                // 'nomor_telepon.max' => 'No Telpn maksimal 15 angka',
                'nomor_telepon.numeric' => 'No Telpn harus berupa angka',
                'nomor_telepon.unique' => 'No Telpn sudah terpakai',

            ]
        );

        // VARIABEL UNTUK MENAMPUNG REQUEST
        $isiRequest = [
            'nama_pelanggan' => $request->nama_pelanggan,
            'alamat' => $request->alamat,
            'nomor_telepon' => $request->nomor_telepon,
        ];

        // PROSES SIMPAN KE DB MELALUI MODEL
        $simpanDataPelanggan = Pelanggan::create($isiRequest);
        $ambilPelangganId = $simpanDataPelanggan->id; // MENGAMBIL ID

        // PROSES SIMPAN DATA KE PENJUALAN
        $dataPenjualan = [
            'tanggal_penjualan' => now(),
            'total_harga' => '0.00',
            'pelanggan_id' => $ambilPelangganId,
        ];

        // PROSES SIMPAN DATA PENJUALAN
        Penjualan::create($dataPenjualan);

        #PROSES SIMPAN HISTORY----------------------------------------
        $user = Auth::user()->id;
        $history = [
            'user_id' => $user,
            'aktivitas' => 'Melakukan Create data Pelanggan & Penjualan'
        ];
        History::create($history);
        #END PROSES SIMPAN HISTORY----------------------------------------

        // PROSES MELEMPAR HALAMAN KALO SUDAH BERHASIL TERSIMPAN
        return back()->with('success', 'Data Pelanggan & data penjualan berhasil ditambahkan!!');
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
    public function update(Request $request, $id)
    {
        // VALIDASI DATA YANG MASUK SESUAI KEBUTUHAN
        $request->validate(
            [
                'nama_pelanggan' => 'required',
                'alamat' => 'required',
                'nomor_telepon' => 'required|numeric',
                'nomor_telepon' => 'max:15'
            ],

            // FUNGSI UNTUK MEMBERI TAU KALO ADA YANG TIDAK SESUAI WAKTU VALIDASI
            [
                'nama_pelanggan.required' => 'Nama Pelanggan harus di isi',
                'alamat.required' => 'Alamat harus di isi',
                'nomor_telepon.required' => 'No Telpn harus di isi',
                'nomor_telepon.max' => 'No Telpn maksimal 15 angka',
                'nomor_telepon.numeric' => 'No Telpn harus berupa angka',
            ]
        );

        // VARIABEL UNTUK MENAMPUNG REQUEST
        $isiRequest = [
            'nama_pelanggan' => $request->nama_pelanggan,
            'alamat' => $request->alamat,
            'nomor_telepon' => $request->nomor_telepon,
        ];

        // PROSES SIMPAN KE DB MELALUI MODEL
        Pelanggan::where('id', $id)->update($isiRequest);

        #PROSES SIMPAN HISTORY----------------------------------------
        $user = Auth::user()->id;
        $history = [
            'user_id' => $user,
            'aktivitas' => 'Melakukan Update data Pelanggan'
        ];
        History::create($history);
        #END PROSES SIMPAN HISTORY----------------------------------------

        // PROSES MELEMPAR HALAMAN KALO SUDAH BERHASIL UPDATE
        return back()->with('success', 'Data Pelanggan berhasil di Update!!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // FUNGSI DELETE DATA
    public function destroy($id)
    {
        // CARI DULU ID(PK) YANG DI PILIH
        Pelanggan::where('id', $id)->delete();

        #PROSES SIMPAN HISTORY----------------------------------------
        $user = Auth::user()->id;
        $history = [
            'user_id' => $user,
            'aktivitas' => 'Melakukan Delete data Pelanggan'
        ];
        History::create($history);
        #END PROSES SIMPAN HISTORY----------------------------------------

        return back()->with('success', 'Data Pelanggan berhasil terhapus!!');
        // PROSES MELEMPAR HALAMAN KALO SUDAH TERDELETE
    }

    // EXPORT PDF
    public function export_pdf()
    {
        #PROSES SIMPAN HISTORY----------------------------------------
        $user = Auth::user()->id;
        $history = [
            'user_id' => $user,
            'aktivitas' => 'Melakukan Export PDF data Pelanggan'
        ];
        History::create($history);
        #END PROSES SIMPAN HISTORY----------------------------------------

        // MEMANGGIL DATA 
        $data = Pelanggan::orderBy('nama_pelanggan', 'asc');
        $data = $data->get(); // MENGAMBIL DATA YANG SUDAH DIPANGGIL

        // MENGATUR HALAMAN YANG AKAN DI JAKIKAN EXPORT PDF
        $pdf = PDF::loadview('data.pelanggan.exportPdf', ['data' => $data]);
        $pdf->setPaper('a4', 'portrait'); // MENGATUR PAPER/KERTAS
        $pdf->setOption(['dpi' => 150, 'defaultFont' => 'sans-serif']); // MENGATUR FONT
        // SET FILE NAME
        $filename = date('YmdHis') . '_data_pelanggan'; // MENGATUR NAMA FILE PDF
        // Download the Pdf file
        return $pdf->download($filename . '.pdf'); // PROSES DOWNLOAD FILE
    }

    // EXPORT EXCEL
    public function export_excel(Request $request)
    {
        #PROSES SIMPAN HISTORY----------------------------------------
        $user = Auth::user()->id;
        $history = [
            'user_id' => $user,
            'aktivitas' => 'Melakukan Export Excel data Pelanggan'
        ];
        History::create($history);
        #END PROSES SIMPAN HISTORY----------------------------------------

        // MEMANGGIL DATA 
        $data = Pelanggan::orderBy('nama_pelanggan', 'asc');
        $data = $data->get(); // MENGAMBIL DATA YANG SUDAH DI PANGGIL

        // Pass parameters to the export class
        $export = new DataPelangganExportView($data);

        // SET FILE NAME
        $filename = date('YmdHis') . '_data_pelanggan'; // MENGATUR NAMA FILE

        // Download the Excel file
        return Excel::download($export, $filename . '.xlsx'); // PROSES DOWNLOAD FILE
    }

    // IMPORT EXCEL
    public function import_excel(Request $request)
    {
         #PROSES SIMPAN HISTORY----------------------------------------
         $user = Auth::user()->id;
         $history = [
             'user_id' => $user,
             'aktivitas' => 'Melakukan Import Excel data Pelanggan'
         ];
         History::create($history);
         #END PROSES SIMPAN HISTORY----------------------------------------

        //DECLARE REQUEST
        $file = $request->file('file');

        //VALIDATION FORM
        $request->validate([
            'file' => 'required|mimes:csv,xls,xlsx'
        ]);

        try {
            if ($file) {
                // IMPORT DATA
                $import = new ImportDataPelangganClass;
                Excel::import($import, $file);

                // SUCCESS
                $notimportlist = "";
                if ($import->listgagal) {
                    $notimportlist .= "<hr> Not Register : <br> {$import->listgagal}";
                }

                #PROSES SIMPAN HISTORY----------------------------------------
                $user = Auth::user()->id;
                $history = [
                    'user_id' => $user,
                    'aktivitas' => 'Melakukan Import Excel data pelanggan'
                ];
                History::create($history);
                #END PROSES SIMPAN HISTORY----------------------------------------

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

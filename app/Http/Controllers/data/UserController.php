<?php

namespace App\Http\Controllers\data;

use Exception;
use App\Models\User;
use App\Models\History;
use Illuminate\Http\Request;
use App\Exports\DataUserExportView;
use App\Http\Controllers\Controller;
use App\Imports\ImportDataUserClass;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;// USE DOMPDF

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = User::latest()->get();
        return view('data.user.index',compact('user'));
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

     // PROSES SIMPAN DATA KE DB
    public function store(Request $request)
    {
        // VALIDASI DATA
      $request->validate([
        'username' => 'required|max:30',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|max:60|min:8',
        'nama_lengkap' => 'required|max:50',
        'alamat' => 'required',
        'role' => 'required'
      ],[
        'username.required' => 'Username harus di isi',
        'username.max' => 'Username maksimal 30 karakter',
        'email.required' => 'Email harus di isi', 
        'email.unique' => 'Email sudah terpakai', 
        'password.required' => 'Password harus di isi',
        'password.min' => 'Password minimal 8 karakter',
        'password.max' => 'Password minimal 60 karakter',
        'nama_lengkap.required' => 'Nama Lengkap harus di isi',
        'nama_lengkap.max' => 'Nama Lengkap maksimal 50 karakter',
        'alamat.required' => 'Alamat harus di isi',
        'role.required' => 'Role harus di isi'
      ]);

     // MEMBUAT VARIABEL UNTUK MENAMPUNG ISI REQUETS
     $data = [
        'username' => $request->username,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'nama_lengkap' => $request->nama_lengkap,
        'alamat' => $request->alamat,
        'role' => $request->role, 
    ];

    // PROSES SIMPAN DATA MELALUI MODEL
    User::create($data);

        #PROSES SIMPAN HISTORY----------------------------------------
        $user = Auth::user()->id;
        $history = [
            'user_id' => $user,
            'aktivitas' => 'Melakukan Create data User'
        ];
        History::create($history);
        #END PROSES SIMPAN HISTORY----------------------------------------

    // KALO SUDAH TERSIMPAN DI ARAHKAN KE HALAMAN SEMULA
    return back()->with('success','Data User berhasil di buat');

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
            // VALIDASI DATA
      $request->validate([
        'username' => 'required|max:30',
        'email' => 'required|email',
        'password' => 'nullable|max:60|min:8',
        'nama_lengkap' => 'required|max:50',
        'alamat' => 'required',
        'role' => 'required'
      ],[
        'username.required' => 'Username harus di isi',
        'username.max' => 'Username maksimal 30 karakter',
        // 'password.required' => 'Password harus di isi',
        'password.min' => 'Password minimal 8 karakter',
        'password.max' => 'Password minimal 60 karakter',
        'nama_lengkap.required' => 'Nama Lengkap harus di isi',
        'nama_lengkap.max' => 'Nama Lengkap maksimal 50 karakter',
        'alamat.required' => 'Alamat harus di isi',
        'role.required' => 'Role harus di isi'
      ]);

     // MEMBUAT VARIABEL UNTUK MENAMPUNG ISI REQUETS
     $data = [
        'username' => $request->username,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'nama_lengkap' => $request->nama_lengkap,
        'alamat' => $request->alamat,
        'role' => $request->role, 
    ];

    // PROSES SIMPAN DATA MELALUI MODEL
    User::find($id)->update($data);

    
        #PROSES SIMPAN HISTORY----------------------------------------
        $user = Auth::user()->id;
        $history = [
            'user_id' => $user,
            'aktivitas' => 'Melakukan Update data User'
        ];
        History::create($history);
        #END PROSES SIMPAN HISTORY----------------------------------------

    // KALO SUDAH TERSIMPAN DI ARAHKAN KE HALAMAN SEMULA
    return back()->with('success','Data User berhasil di update');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::find($id)->delete();

        
        #PROSES SIMPAN HISTORY----------------------------------------
        $user = Auth::user()->id;
        $history = [
            'user_id' => $user,
            'aktivitas' => 'Melakukan Delete data User'
        ];
        History::create($history);
        #END PROSES SIMPAN HISTORY----------------------------------------

        return back()->with('success','Data berhasil di hapus!!');
    }

    // EXPORT PDF
    public function export_pdf()
    {
        
        #PROSES SIMPAN HISTORY----------------------------------------
        $user = Auth::user()->id;
        $history = [
            'user_id' => $user,
            'aktivitas' => 'Melakukan Export PDF data User'
        ];
        History::create($history);
        #END PROSES SIMPAN HISTORY----------------------------------------

        // MEMANGGIL DATA 
        $data = User::orderBy('username','asc');
        $data = $data->get(); // MENGAMBIL DATA YANG SUDAH DIPANGGIL

        // MENGATUR HALAMAN YANG AKAN DI JAKIKAN EXPORT PDF
        $pdf = PDF::loadview('data.user.exportPdf', ['data'=>$data]);
        $pdf->setPaper('a4', 'portrait'); // MENGATUR PAPER/KERTAS
        $pdf->setOption(['dpi' => 150, 'defaultFont' => 'sans-serif']);// MENGATUR FONT
        // SET FILE NAME
        $filename = date('YmdHis') . '_data_user';// MENGATUR NAMA FILE PDF
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
            'aktivitas' => 'Melakukan Export Excel data User'
        ];
        History::create($history);
        #END PROSES SIMPAN HISTORY----------------------------------------

        // MEMANGGIL DATA 
        $data = User::orderBy('username','asc');
        $data = $data->get(); // MENGAMBIL DATA YANG SUDAH DI PANGGIL

        // Pass parameters to the export class
        $export = new DataUserExportView($data);
        
        // SET FILE NAME
        $filename = date('YmdHis') . '_data_user';// MENGATUR NAMA FILE
        
        // Download the Excel file
        return Excel::download($export, $filename . '.xlsx');// PROSES DOWNLOAD FILE
    }

     // IMPORT EXCEL
     public function import_excel(Request $request)
     {
        
        #PROSES SIMPAN HISTORY----------------------------------------
        $user = Auth::user()->id;
        $history = [
            'user_id' => $user,
            'aktivitas' => 'Melakukan Import Excel data User'
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
             if($file){
                 // IMPORT DATA
                 $import = new ImportDataUserClass;
                 Excel::import($import, $file);
                 
                 // SUCCESS
                 $notimportlist="";
                 if ($import->listgagal) {
                     $notimportlist.="<hr> Not Register : <br> {$import->listgagal}";
                 }
                 return back()
                 ->with('success', 'Import Data berhasil,<br>
                 Size '.$file->getSize().', File extention '.$file->extension().',
                 Insert '.$import->insert.' data, Update '.$import->edit.' data,
                 Failed '.$import->gagal.' data, <br> '.$notimportlist.'');
 
             } else {
                 // ERROR
                 return back()
                 ->withInput()
                 ->with('error','Gagal 1!');
             }
             
         }
         catch(Exception $e){
             // ERROR
             return back()
             ->withInput()
             ->with('error','Gagal 2!');
         }
 
     }
}

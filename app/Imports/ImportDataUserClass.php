<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;

HeadingRowFormatter::default('none');


class ImportDataUserClass implements ToCollection, WithCalculatedFormulas
{
    /**
     * @param Collection $rows
     * @return MsHdCashflow
     */

    public  $insert;
    public  $edit;
    public  $gagal;
    public  $listgagal;

    // public function __construct(){
    //     $this->Tanggal = new Tanggal();
    //     $this->Konversi = new Konversi();
    // }

    public function collection(Collection $rows)
    {
        $trDt = [];
        $this->insert = 0;
        $this->edit = 0; 
        $this->gagal = 0; 
        $this->listgagal = "";

        foreach ($rows as $idx => $row) {
            if ($idx > 0) {
                //DECLARE REQUEST
                $no=isset($row[0])?($row[0]):'';
                // $username = isset($row[1][4]) ? $row[1][4] : '';
                // $email = isset($row[2][4]) ? $row[2][4] : '';
                // $password = isset($row[3][4]) ? $row[3][4] : '';
                // $nama_lengkap = isset($row[4][4]) ? $row[4][4] : '';
                // $alamat = isset($row[4][4]) ? $row[4][4] : '';
                // $role = isset($row[4][4]) ? $row[4][4] : '';
                // $verifikasi = isset($row[4][4]) ? $row[4][4] : '';
                $username=isset($row[1])?($row[1]):'';
                $email=isset($row[2])?($row[2]):'';
                $password=isset($row[3])?($row[3]):'';
                $nama_lengkap=isset($row[4])?($row[4]):'';
                $role=isset($row[5])?($row[5]):'';
                $alamat=isset($row[6])?($row[6]):'';
                // $verifikasi=isset($row[4])?($row[4]):'';
      
                $hashedPassword = Hash::make($password);

                //READY REQUEST
                $trDt[$idx]['username'] = $username;
                $trDt[$idx]['email'] = $email;
                $trDt[$idx]['password'] = $hashedPassword;
                $trDt[$idx]['nama_lengkap'] = $nama_lengkap;
                $trDt[$idx]['alamat'] = $alamat;
                $trDt[$idx]['role'] = $role;
                // $trDt[$idx]['verifikasi'] = $verifikasi;


                $data = User::where('email', '=',''.$trDt[$idx]['email'].'')->first();
                if ($data) {//UPDATE DATA
                    $data->username         = $trDt[$idx]['username'];
                    $data->email         = $trDt[$idx]['email'];
                    $data->password         = $trDt[$idx]['password'];
                    $data->nama_lengkap         = $trDt[$idx]['nama_lengkap'];
                    $data->alamat         = $trDt[$idx]['alamat'];
                    $data->role         = $trDt[$idx]['role'];
                    // $data->verifikasi         = $trDt[$idx]['verifikasi'];

                    // SAVE THE DATA
                    if ($data->save()) {
                        // SUCCESS
                        ++$this->edit;
                    }
                } else {//INSERT DATA
                    if($trDt[$idx]['email']){
                        $data =  new User();
                        $data->username         = $trDt[$idx]['username'];
                        $data->email         = $trDt[$idx]['email'];
                        $data->password         = $trDt[$idx]['password'];
                        $data->nama_lengkap         = $trDt[$idx]['nama_lengkap'];
                        $data->alamat         = $trDt[$idx]['alamat'];
                        $data->role         = $trDt[$idx]['role'];
                        // $data->verifikasi         = $trDt[$idx]['verifikasi'];
                        // dd($data);
                        // SAVE THE DATA
                        if ($data->save()) {
                            // SUCCESS
                            ++$this->insert;
                        }
                    }else{
                        // FAILED
                        ++$this->gagal;
                        $this->listgagal.="(".$trDt[$idx]['email']." - ".$trDt[$idx]['email']."),<br>";
                    }
                }
            }
        }
    }


}

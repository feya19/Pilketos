<?php

namespace App\Console\Commands;

use App\Models\Jurusan;
use App\Models\Kelas;
use App\Models\User;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Str;

class ImportPemilihCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:staff';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import Pemilih Command';


    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        echo 'Start Import Pemilih ...'. PHP_EOL;
        if(file_exists(public_path('import/import_staff_pemilih.xlsx'))){
            $spreadsheet = IOFactory::load(public_path('import/import_staff_pemilih.xlsx'));
            $worksheet = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
            $success = 0;
            $failure = '';
            $tampung = [];
            $date = (int) date('Ymdh');
            $jurusan = Jurusan::firstOrCreate([
                'name' => 'SMKN 1 Boyolangu'
            ]);
            $kelas = Kelas::firstOrCreate([
                'name' => 'Guru & Staff'
            ], [
                'jurusan_id' => $jurusan->id
            ]);
            $int = $date;
            for ($i = 2; $i <= count($worksheet); $i++) {
                $array_pemilih = [
                    'no' => trim($worksheet[$i]['A']),
                    'name' => trim($worksheet[$i]['B']),
                ];
                $validator = Validator::make($array_pemilih, [
                    'name' => 'required',
                ]);
                if($validator->fails()){
                    $failure .= (count($worksheet) == 2 || $i == count($worksheet) ? $array_pemilih['no'] :  $array_pemilih['no'].', ');
                    continue;
                }
                DB::beginTransaction();
                try{
                    $user = User::updateOrCreate([
                        'email' =>  $int
                    ], [
                        'email' => $int,
                        'name' => $array_pemilih['name'],
                        'kelas_id' => $kelas->id,
                        'jurusan_id' => $jurusan->id
                    ]);
                    if(!$user->token){
                        $user->token = strtolower(Str::random(6));
                    }
                    $user->assignRole('user');
                    $user->save();
                    $int++;
                    $success++;
                    DB::commit();
                }catch(Exception $e){
                    DB::rollback();
                    dump($e);
                    $failure .= (count($worksheet) == 2 || $i == count($worksheet) ? $array_pemilih['no'] :  $array_pemilih['no'].', ');
                    continue;
                }
                
            }
            echo 'Berhasil Import '.$success.' Pemilih'. PHP_EOL;
            echo '-----------------------------------------------------------------'. PHP_EOL;
            if($failure != '') echo 'No Pemilih '.$failure. ' Tidak Ditemukan'. PHP_EOL;
        }else{
            echo 'import/import_staff_pemilih.xlsx Tidak Ada Di Folder'. PHP_EOL;
        }
    }
}

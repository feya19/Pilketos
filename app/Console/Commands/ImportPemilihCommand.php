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
    protected $signature = 'import:pemilih';

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
        if(file_exists(public_path('import/import_pemilih.xlsx'))){
            $spreadsheet = IOFactory::load(public_path('import/import_pemilih.xlsx'));
            $worksheet = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
            $success = 0;
            $failure = '';
            for ($i = 2; $i <= count($worksheet); $i++) {
                $array_pemilih = [
                    'no' => trim($worksheet[$i]['A']),
                    'email' => trim($worksheet[$i]['B']),
                    'name' => trim($worksheet[$i]['C']),
                    'jurusan' => trim($worksheet[$i]['D']),
                    'kelas' => trim($worksheet[$i]['E'])
                ];
                $validator = Validator::make($array_pemilih, [
                    'email' => 'required',
                    'name' => 'required',
                    'jurusan' => 'required',
                    'kelas' => 'required'
                ]);
                if($validator->fails()){
                    $failure .= (count($worksheet) == 2 || $i == count($worksheet) ? $array_pemilih['no'] :  $array_pemilih['no'].', ');
                    continue;
                }
                DB::beginTransaction();
                try{
                    $jurusan = Jurusan::firstOrCreate([
                        'name' => $array_pemilih['jurusan']
                    ]);
                    $kelas = Kelas::firstOrCreate([
                        'name' => $array_pemilih['kelas']
                    ], [
                        'jurusan_id' => $jurusan->id
                    ]);
                    $user = User::updateOrCreate([
                        'email' => $array_pemilih['email'],
                        'name' => $array_pemilih['name'],
                    ], [
                        'email' => $array_pemilih['email'],
                        'kelas_id' => $kelas->id,
                        'jurusan_id' => $jurusan->id
                    ]);
                    if(!$user->token){
                        $user->token = strtolower(Str::random(6));
                    }
                    $user->assignRole('user');
                    $user->save();
                    $success++;
                    DB::commit();
                }catch(Exception $e){
                    DB::rollback();
                    dd($e);
                    $failure .= (count($worksheet) == 2 || $i == count($worksheet) ? $array_pemilih['no'] :  $array_pemilih['no'].', ');
                    continue;
                }
                
            }
            echo 'Berhasil Import '.$success.' Pemilih'. PHP_EOL;
            echo '-----------------------------------------------------------------'. PHP_EOL;
            if($failure != '') echo 'No Pemilih '.$failure. ' Tidak Ditemukan'. PHP_EOL;
        }else{
            echo 'import/import_pemilih.xlsx Tidak Ada Di Folder'. PHP_EOL;
        }
    }
}

<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\PemilihDatatable;
use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\User;
use App\Repositories\BaseRepository;
use App\Services\PemilihService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Zip;

class PemilihController extends Controller
{
    protected $pemilih,$kelas,$files;
    public function __construct(User $pemilih,Kelas $kelas)
    {
        $this->pemilih = new BaseRepository($pemilih);
        $this->kelas = new BaseRepository($kelas);
    }

    public function __destruct(){
        $this->files && File::delete($this->files);
    }

    public function index(PemilihDatatable $datatable)
    {
        try {
            return $datatable->render('backend.pemilih.index');
        }catch (\Throwable $th) {
            return view('error.index',['message' => $th->getMessage()]);
        }
    }

    public function create()
    {
        try {
            $data['kelas'] = $this->kelas->get();
            return view('backend.pemilih.create',compact('data'));
        }catch (\Throwable $th) {
            return view('error.index',['message' => $th->getMessage()]);
        }
    }

    public function store(Request $request,PemilihService $pemilihService)
    {
        try {
            $pemilihService->store($request->all());
            return redirect()->route('backend.pemilih.index')->with('success',__('message.store'));
        }catch (\Throwable $th) {
            return view('error.index',['message' => $th->getMessage()]);
        }
    }

    public function edit($id)
    {
        try {
            $data['kelas'] = $this->kelas->get();
            $data['pemilih'] = $this->pemilih->find($id);
            return view('backend.pemilih.edit',compact('data'));
        }catch (\Throwable $th) {
            return view('error.index',['message' => $th->getMessage()]);
        }
    }

    public function update(Request $request,$id)
    {
        try {
            $this->pemilih->update($id,$request->all());
            return redirect()->route('backend.pemilih.index')->with('success',__('message.update'));
        }catch (\Throwable $th) {
            return view('error.index',['message' => $th->getMessage()]);
        }
    }

    public function delete($id)
    {
        try {
            $this->pemilih->delete($id);
            return redirect()->route('backend.pemilih.index')->with('success',__('message.delete'));
        }catch (\Throwable $th) {
            return view('error.index',['message' => $th->getMessage()]);
        }
    }

    public function export() {
        $spreadsheet = IOFactory::load(public_path().'/import/export_pemilih.xlsx');
        $worksheet = $spreadsheet->getActiveSheet();
        $cols = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z');

        $style = array(
            'borders' => array(
                'bottom' => array(
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ),
                'left' => array(
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ),
                'right' => array(
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ),
            ),
        );
        $model = User::with('kelas.jurusan')->where('kelas_id', '!=', '')->get();
        $row = 6;
        $no = 1;
        $worksheet->getCell('A1')->setValue('Export');
        $worksheet->getCell('B1')->setValue('Pemilih');
        $worksheet->getCell('A3')->setValue(date('Y-m-d H:i:s'));
        foreach ($model as $key => $value) {
            $worksheet->getCell('A' . $row)->setValue($no);
            $worksheet->getCell('B' . $row)->setValue($value->email);
            $worksheet->getCell('C' . $row)->setValue($value->token);
            $worksheet->getCell('D' . $row)->setValue($value->name);
            $worksheet->getCell('E' . $row)->setValue($value->kelas->jurusan->name);
            $worksheet->getCell('F' . $row)->setValue($value->kelas->name);
            for ($i = 0; $i < 6; $i++) {
                $spreadsheet->getActiveSheet()->getStyle($cols[$i] . $row)->applyFromArray($style);
            }
            $no++;
            $row++;
        }
        foreach ($worksheet->getColumnDimensions() as $colDim) {
            $colDim->setAutoSize(true);
        }
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        header('Content-Disposition: attachment; filename="export_pemilih.xlsx"');
        $writer->save("php://output");
        exit;
    }

    public function exportKelas() {
        $model = Kelas::with(['user','jurusan'])->get();
        $files = [];
        foreach($model as $i => $data){
            $spreadsheet = IOFactory::load(public_path().'/import/export_pemilih.xlsx');
            $worksheet = $spreadsheet->getActiveSheet();
            $cols = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z');

            $style = array(
                'borders' => array(
                    'bottom' => array(
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    ),
                    'left' => array(
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    ),
                    'right' => array(
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    ),
                ),
            );
            $model = $data->user;
            $row = 6;
            $no = 1;
            $worksheet->getCell('A1')->setValue('Export');
            $worksheet->getCell('B1')->setValue('Pemilih');
            $worksheet->getCell('A2')->setValue($data->name);
            $worksheet->getCell('A3')->setValue(date('Y-m-d H:i:s'));
            foreach ($model as $key => $value) {
                $worksheet->getCell('A' . $row)->setValue($no);
                $worksheet->getCell('B' . $row)->setValue($value->email);
                $worksheet->getCell('C' . $row)->setValue($value->token);
                $worksheet->getCell('D' . $row)->setValue($value->name);
                $worksheet->getCell('E' . $row)->setValue($data->jurusan->name);
                $worksheet->getCell('F' . $row)->setValue($data->name);
                for ($i = 0; $i < 6; $i++) {
                    $spreadsheet->getActiveSheet()->getStyle($cols[$i] . $row)->applyFromArray($style);
                }
                $no++;
                $row++;
            }
            foreach ($worksheet->getColumnDimensions() as $colDim) {
                $colDim->setAutoSize(true);
            }	
            $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
            $fileName = 'export_pemilih_'.$data->name.'.xlsx';
            $writer->save($fileName);
            $files[] = $fileName;
        } 
        $this->files = $files;
        return Zip::create('export_pemilih_'.date('Y-m-d H:i:s').'.rar', $files);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Collection;
use Illuminate\Pagination\Paginator;
use\App\Result;
use\App\Student; 
use\App\Employee;
use\App\LabResult;
use DataTables;
use\App\Providers;
use Carbon\Carbon;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Encryption\Encrypter;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\MedClientAddController;
use Illuminate\Support\Facades\File;


class LabResultController extends Controller
{
    protected $aes;
    public function __construct() {
        $this->aes = new AESCipher;
    }
    public function profilephoto($data = []){

      $ces_url = env('CES');
      $key = base64_decode(env('SHARED_CRYPT_KEY'));
      $encrypter = new Encrypter($key, 'AES-256-CBC');
      
      $campuses = [1 => 'sg',2 => 'mcc',3 => 'to',4 => 'bn',5 => 'sj',6 => 'hn'];
      $connection = $campuses[$data['campus']];
      $encrypted = $encrypter->encrypt($data['StudentNo']);
      $campus= $encrypter->encrypt($connection);
      $image = $ces_url . "/profile-photo?snum=".urlencode($encrypted)."&campus=".urlencode($campus);

      return $image;

    }
    public function index(){
       
        $pageConfigs = ['pageHeader' => true];
        $breadcrumbs = [
          ["link" => "/", "name" => "Home"],["name" => "Search"]
        ];

        return view('pages.lab-results',['pageConfigs'=>$pageConfigs,'breadcrumbs'=>$breadcrumbs]);
    }
    public function searchLab(Request $request){ 
        $search = $request->input('search');
        if ($request->get('role') === 'Student') {

            $connection = MedClientAddController::getCampusConnection();

            $result = DB::connection($connection)
                ->table('students as s')
                ->select('s.*','r.SchoolLevel')
                ->leftJoin('registration as r', 's.StudentNo', '=', 'r.StudentNo') 
                ->where(function ($query) use ($request) {
                    $query->where('s.StudentNo', 'like', '%' . $request->search . '%')
                        ->orWhere('s.LastName', 'LIKE', '%' . $request->search . '%')
                        ->orWhere('s.FirstName', 'LIKE', '%' . $request->search . '%');
                })
                ->where('r.SchoolLevel', '=' ,'Under Graduate')
                ->where('s.notuse', 0)
                ->distinct()
                ->get();
            
          $encryptedResults = $result->map(function ($student) {
              $student->encryptedStudentNo = $this->aes->encrypt($student->StudentNo);
              return $student;
          });

          $response = [
              'role' => $request->get('role'),
              'data' => $encryptedResults,
          ];
          
          return response()->json($response);
      } else if ($request->get('role') === 'Employee') {
               
            $search = $request->input('search');
      
            $result = DB::table('employee_info')
                ->where(function ($query) use ($request) {
                    $query->where('AgencyNumber', 'like', '%' . $request->search . '%')
                        ->orWhere('LastName', 'LIKE', '%' . $request->search . '%')
                        ->orWhere('FirstName', 'LIKE', '%' . $request->search . '%');
                })
                ->where('campus',session('campus'))
                ->orderBy('LastName', 'asc')
                ->get();
  
          $encryptedResults = $result->map(function ($employee) {
          $employee->encryptedEmployeeNo = $this->aes->encrypt($employee->AgencyNumber);
          return $employee;
          });
          
          $response = [
            'role' => $request->get('role'),
            'data' => $encryptedResults,
        ];
  
        return response()->json($response);
        } else {
            return response()->json('<tr><td colspan="5" style="text-align:center;">No records found</td></tr>');
          }
    }
    public function labRecords(Request $request){
        $pageConfigs = ['pageHeader' => true];
        $breadcrumbs = [
            ["link" => "/", "name" => "Home"],
            ["link" => "/lab-results", "name" => "Search"], 
            ["name" => "Lab Result Records"]
        ];

        if ($request->get('role') === 'Student') {
            $connection = MedClientAddController::getCampusConnection();
            $patient = DB::connection($connection)->table('students')->where('StudentNo', (new AESCipher)->decrypt($request->id))->first();

        } else if ($request->get('role') === 'Employee') {
            $patient = Employee::where('AgencyNumber', $this->aes->decrypt($request->id))->where('campus',session('campus'))->first();
        }
    
        $newID = $request->id;
          
        $uploaded = DB::table('labresult')
            ->where('patientId',$this->aes->decrypt($request->id))
            ->whereNull('deleted_at')
            ->where('campus',session('campus'))
            ->get();

        return view('pages.lab-test-result-records',['pageConfigs'=>$pageConfigs,'breadcrumbs'=>$breadcrumbs],compact('patient','newID','uploaded'));
     
    }
    public function uploadFiles(Request $request){
        try {
             
            $request->validate([
                'file_cbc' => 'nullable|mimes:jpeg,png,jpg,gif,pdf|max:10240', 
                'file_urinalysis' => 'nullable|mimes:jpeg,png,jpg,gif,pdf|max:10240',
                'file_xray' => 'nullable|mimes:jpeg,png,jpg,gif,pdf|max:10240',
                'file_ecg' => 'nullable|mimes:jpeg,png,jpg,gif,pdf|max:10240',
                'file_drug_test' => 'nullable|mimes:jpeg,png,jpg,gif,pdf|max:10240',
                'file_others' => 'nullable|mimes:jpeg,png,jpg,gif,pdf|max:10240',
            ]);
            
            $file_cbc = $request->file('file_cbc');
            $file_urinalysis = $request->file('file_urinalysis');
            $file_xray = $request->file('file_xray');
            $file_ecg = $request->file('file_ecg');
            $file_drug_test = $request->file('file_drug_test');
            $file_others = $request->file('file_others');
            
            $uploadPath = env('APP_NAME') . '/laboratory_result';
            if (!\Storage::exists($uploadPath)) {
                \Storage::makeDirectory($uploadPath);
            }

            $files = [
                'file_cbc' => $file_cbc,
                'file_urinalysis' => $file_urinalysis,
                'file_xray' => $file_xray,
                'file_ecg' => $file_ecg,
                'file_drug_test' => $file_drug_test,
                'file_others' => $file_others,
            ];

            foreach ($files as $key => $file) {
                if ($file) {
                    $fileName = $file->getClientOriginalName();
                    $file->storeAs($uploadPath, $fileName);
                    $file->move('storage/'. $uploadPath, $fileName); 
                } else {
                    $$key = null;
                }
            }
    
            $storeFile = LabResult::insert([
                    'patientId' => $request->patientId,
                    'file_cbc' => $file_cbc ? $file_cbc->getClientOriginalName() : null,
                    'file_urinalysis' => $file_urinalysis ? $file_urinalysis->getClientOriginalName() : null,
                    'file_xray' => $file_xray ? $file_xray->getClientOriginalName() : null,
                    'file_ecg' => $file_ecg ? $file_ecg->getClientOriginalName() : null,
                    'file_drug_test' => $file_drug_test ? $file_drug_test->getClientOriginalName() : null,
                    'file_others' => $file_others ? $file_others->getClientOriginalName() : null,
                    'campus' => session('campus'),
                    'created_at' => Carbon::now('Asia/Manila'),
                ]);
       
        session()->flash('success', 'File(s) successfully uploaded.');

        } catch (\Exception $e) {
            \Log::error('File upload error: ' . $e->getMessage());
            
        } return back();
    }   
    public function deleteLabResult(Request $request){

    $labResult = LabResult::where('id', $request->id)->where('campus',session('campus'))->first();

    if ($labResult) {

        LabResult::where('id', $request->id)
            ->where('campus',session('campus'))
            ->update([
                'deleted_at' => Carbon::now('Asia/Manila'),
            ]);

    
        $uploadPath = env('APP_NAME') . '/laboratory_result';
        
        $files = [
            'file_cbc' => $labResult->file_cbc,
            'file_urinalysis' => $labResult->file_urinalysis,
            'file_xray' => $labResult->file_xray,
            'file_ecg' => $labResult->file_ecg,
            'file_drug_test' => $labResult->file_drug_test,
            'file_others' => $labResult->file_others,
        ];
      

        foreach ($files as $key => $filename) {
            if ($filename) {
                if (\Storage::exists($uploadPath . '/' . $filename)) {
                    try {
                        \Storage::delete($uploadPath . '/' . $fileName);
                    } catch (\Exception $e) {
                        \Log::error('Error deleting file: ' . $e->getMessage());
                    }
                    
                }
            }
        }

        return response()->json(['message' => 'Lab result deleted successfully']);
    } else {
        return response()->json(['message' => 'Lab result not found'], 404);
    }
   }   

    public function deleteFile($id, $type)
   {
    //  dd($type);
   $labResult = LabResult::findOrFail($id);

    if ($labResult->$type) {
        $filePath = storage_path('app/public/Laravel/laboratory_result/' . $labResult->$type);
        if (file_exists($filePath)) {
            unlink($filePath);
        }
        $labResult->$type = null;
        $labResult->save();
    }

        return response()->json(['message' => 'File deleted successfully']);
    }
             
}

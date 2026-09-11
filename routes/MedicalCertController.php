<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Collection;
use Illuminate\Pagination\Paginator;
use\App\Student;
use\App\Employee;
use\App\Medical;
use DataTables;
use\App\Providers;
use Carbon\Carbon;
use\App\HealthHistory;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use App\Http\Controllers\AESCipher;
use App\Http\Controllers\MedClientAddController;
use Barryvdh\DomPDF\Facade\Pdf;

class MedicalCertController extends Controller
{
    protected $aes;
    public function __construct() {
        $this->aes = new AESCipher;
    }
    public function index(){
      $pageConfigs = ['pageHeader' => true];
      $breadcrumbs = [
        ["link" => "/", "name" => "Home"],["name" => "Search"]
      ];
    
      return view('pages.medical-certificate',['pageConfigs'=>$pageConfigs,'breadcrumbs'=>$breadcrumbs]);
    }

    public function create(Request $request){ 

      $pageConfigs = ['pageHeader' => true];
      $breadcrumbs = [
        ["link" => "/", "name" => "Home"],
        ["link" => "/medical-certificate", "name" => "Search"], 
        ["name" => "Patient Information"]
      ];

      $role = $request->get('role');
       
      if ($role === 'Student') {  

        $check = HealthHistory::where('patientId',$this->aes->decrypt($request->id))->where('campus',session('campus'))->first();
     
        $name =  Student::where('StudentNo', $this->aes->decrypt($request->id))->where('campus', session('campus'))->first();
        if (empty($check)){

          $error_message = 'No Health History';
          $namePatient =  $name->FirstName . ' ' . $name->MiddleName . ' ' . $name->LastName;
        
          session()->flash('error', $error_message);
          session()->flash('patient',$namePatient);

          return redirect()->route('backtoview1')->with(['error', $error_message],['patient',$namePatient]);

        }else{

          $schoolyr = date('Y');
          $current_month = date('n');
       if ($current_month >= 6 && $current_month <= 12) {
            $semester = [1, 9];
            $schoolyr_start = [$schoolyr, $schoolyr - 1]; 
        } else {
            $semester = [2];
            $schoolyr_start = [$schoolyr - 1]; 
        }

         $connection = MedClientAddController::getCampusConnection();

          $view = DB::table('student_info as s')
            ->join('health_history as h', 's.StudentNo', '=', 'h.patientId')
            ->where('s.StudentNo', $this->aes->decrypt($request->id))
            ->select('s.*', 'h.*')
            ->where('s.campus',session('campus'))
            ->first();

          $data = DB::connection($connection)->table('registration as r')
            ->select('c.id', 'c.course_title', 'c.accro', 's.StudentNo', 'r.StudentNo', 'r.Course', 'm.course_major', 'r.StudentYear', 'r.SchoolYear', 'r.Semester')
            ->join('students as s', 'r.StudentNo', '=', 's.StudentNo')
            ->join('course as c', 'c.id', '=', 'r.Course')
            ->join('major as m', 'm.id', '=', 's.Major')
            ->where('r.StudentNo', $this->aes->decrypt($request->id))
            ->whereIn('r.SchoolYear', $schoolyr_start)
            ->whereIn('r.Semester', $semester)
            ->orderBy('r.SchoolYear', 'desc')
            ->first(); 
            //  dd($data);

        if (empty($data)){
          $error_message = 'Student Not Validated';
          $namePatient =  $name->FirstName . ' ' . $name->MiddleName . ' ' . $name->LastName;
        
          session()->flash('error', $error_message);
          session()->flash('patient',$namePatient);
          return redirect()->route('backtoview1')->with(['error', $error_message],['patient',$namePatient]);
        }else{
         
          $encryptedId = $request->id;

          $today = Carbon::today();
          $bdatetmp = explode(' ', $view->BirthDate);
          $newbday = $bdatetmp[2].'-'.str_pad($bdatetmp[0], 2, "0", STR_PAD_LEFT).'-'.str_pad($bdatetmp[1], 2, "1", STR_PAD_LEFT);
          $age = $today->diff($newbday)->y;
  
          $medicalrecord = DB::table('medicalrecord')->where('id',$request->recId)->where('campus',session('campus'))->first();

          // dd($medicalrecord);
  
          return view('pages.medical-certificate-patient-information', ['pageConfigs' => $pageConfigs, 'breadcrumbs' => $breadcrumbs], compact('data','view', 'encryptedId', 'role', 'request','age','newbday','medicalrecord'));      
          }
        
        }
        return back();
      } else if($role === 'Employee'){ 
        
        $name =  Employee::where('AgencyNumber', $this->aes->decrypt($request->id))->where('campus', session('campus'))->first();
        $check = HealthHistory::where('patientId',$this->aes->decrypt($request->id))->where('campus',session('campus'))->first();


        if (empty($check)){

          $error_message = 'No Health History';
          $namePatient =  $name->FirstName . ' ' . $name->MiddleName . ' ' . $name->LastName;

          session()->flash('error', $error_message);
          session()->flash('patient',$namePatient);
          return redirect()->route('backtoslip')->with(['error', $error_message],['patient',$namePatient]);

        } else{

        $view = DB::table('employee_info as e')
          ->join('health_history as h', 'e.AgencyNumber', '=', 'h.patientId')
          ->where('e.AgencyNumber', $this->aes->decrypt($request->id))
          ->select('e.*', 'h.*')
          ->where('e.campus', session('campus'))
          ->first();

        $encryptedId = $request->id;

        $today = Carbon::today();
        $dateofbirth =$view->DateOfBirth;
        $age = $today->diff($dateofbirth)->y;

        $medicalrecord = Medical::where('id',$request->recId)->where('campus',session('campus'))->first();

        return view('pages.medical-certificate-patient-information',['pageConfigs'=>$pageConfigs,'breadcrumbs'=>$breadcrumbs],compact('medicalrecord','view','encryptedId','role','request','age','dateofbirth'));
        }
      return back();
      }
    }
    public function search(Request $request){ 
      try{
        if ($request->get('role') === 'Student') {
      
          $result = DB::table('student_info as s')
            ->where(function ($query) use ($request) {
              $query->where('s.StudentNo', 'like', '%' . $request->search . '%')
                ->orWhere('s.LastName', 'LIKE', '%' . $request->search . '%')
                ->orWhere('s.FirstName', 'LIKE', '%' . $request->search . '%');
            })
            ->where('campus',session('campus'))
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
      }else if ($request->get('role') === 'Employee') {
         
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
        } catch (\Throwable $th) {
          dd('error',$th);
        }
     }
  
      public function viewForApprove(Request $request){
    
      $pageConfigs = ['pageHeader' => true];
      $breadcrumbs = [["link" => "/", "name" => "Home"],
      ["link" => "/medical-certificate-patient-information", "name" => "Patient Information"], 
        ["name" => "Preview Certificate"]
      ]; 
      $role = $request->get('role');
   
        $schoolyr = date('Y');
        $current_month = date('n');
        
        if ($current_month >= 6 && $current_month <= 12) {
            $semester = [1, 9];
            $schoolyr_start = [$schoolyr, $schoolyr - 1]; 
          } else {
              $semester = [2];
              $schoolyr_start = [$schoolyr - 1]; 
          }

      $syr = $schoolyr + 1;
      $addYear = $schoolyr.'-'.$syr;


      $response = DB::table('medicalcert')
        ->where("patientId", $this->aes->decrypt($request->id))
        ->where('campus', session('campus'))
        ->latest('id')
        ->first();

      $doctor = DB::table('doctors')
        ->where('specialization','physician')
        ->where('campus', session('campus'))
        ->first(); 

      $newencryptedId = $this->aes->encrypt($response->id); 

      return view('pages.medical-preview-certificate', ['pageConfigs' => $pageConfigs, 'breadcrumbs' => $breadcrumbs], compact('doctor','response','request','newencryptedId','role','addYear'));

  }
    public function viewCertificate(Request $request){
      $pageConfigs = ['pageHeader' => true];
      $breadcrumbs = [["link" => "/", "name" => "Home"],
        ["link" => "/medical-certificate", "name" => "Search"],
        ["name" => "Generated Certificate Records"]];
 
      $record =  DB::table('medicalcert')->where('patientId',$this->aes->decrypt($request->id))->where('campus',session('campus'))->first();
         
      if ($record === null) {

        $role = $request->get('role');
        $decryptedId = $this->aes->decrypt($request->id);
        $table = $role === 'Student' ? 'student_info' : 'employee_info';
        $identifier = $role === 'Student' ? 'StudentNo' : 'AgencyNumber';

        $check = DB::table($table)->where($identifier, $decryptedId)->where('campus',session('campus'))->first();

        $error_message = 'No record found';
        $namePatient = utf8_decode($check->FirstName) . ' ' . utf8_decode($check->MiddleName) . ' ' . utf8_decode($check->LastName);

        session()->flash('error', $error_message);
        session()->flash('patient', $namePatient);

        return redirect()->route('backtoview1')->with(['error' => $error_message, 'patient' => $namePatient]);
      }else{
        $role = $request->get('role');
          
        $list =  DB::table('medicalcert')->where('patientId',$this->aes->decrypt($request->id))->where('campus',session('campus'))->whereNull('deleted_at')->get();
        $newencryptedId =  DB::table('medicalcert')->where('patientId',$this->aes->decrypt($request->id))->where('campus',session('campus'))->first();
  
        return view('pages.medical-view-certificate',['pageConfigs'=>$pageConfigs,'breadcrumbs'=>$breadcrumbs],compact('list','newencryptedId','request','role'));   
      }
       return redirect();
    }
    public function generateCertificate(Request $request){
      
      $pageConfigs = ['pageHeader' => true];
      $breadcrumbs = [    ["link" => "/", "name" => "Home"],
          ["link" => "/medical-certificate", "name" => "Search"],
          ["link" => "/medical-view-certificate", "name" => "Generated Certificate Records"], 
          ["name" => "Generated Certificate"]
      ];
      $response =  DB::table('medicalcert')->where("id", $this->aes->decrypt($request->id))->where('campus',session('campus'))->first();

      $schoolyr =  date('Y', strtotime($response->date));
      $current_month = date('m', strtotime($response->date));
      
      if ($current_month >= 8 && $current_month <= 12) {
        $semester = '1';
        $schoolyr_start = $schoolyr; 
      } elseif ($current_month >= 6 && $current_month <= 7) {
        $semester = '2';
       $schoolyr_start = $schoolyr - 1;
      } elseif ($current_month >= 1 && $current_month <= 5) {
         $semester = '9';
       $schoolyr_start = $schoolyr - 1;
      }

      $today = Carbon::today();
      $newbday =$response->bday;
      $age = $today->diff($newbday)->y;

      $schoolyr = $schoolyr_start;
      $syr = $schoolyr + 1;
      $addYear = $schoolyr . '-' . $syr;
      //  dd($schoolyr);

      $doctor = DB::table('doctors')
        ->where('specialization','physician')
        ->where('campus',session('campus'))
        ->first(); 

      return view('pages.medical-generated-certificate',['pageConfigs'=>$pageConfigs,'breadcrumbs'=>$breadcrumbs],compact('doctor','newbday','age','addYear','response','request'));
  }
    public function statusCert(Request $request){
      $pageConfigs = ['pageHeader' => true];
      $breadcrumbs = [["link" => "/", "name" => "Home"],
            ["link" => "/medical-certificate", "name" => "Search"],
            ["name" => "Certificate Status"]
      ];

      if ($request->has('id')) {
          $role = $request->get('role');
          if ($request->has('id')) {
         
            $decryptedId = $this->aes->decrypt($request->id);
            
            $name = DB::table('medicalcert as m')
              ->select("s.id", "m.*", "e.AgencyNumber")
              ->join('student_info as s', 'm.patientId', '=', 's.id')
              ->where("s.id", $decryptedId)
              ->where('m.campus',session('campus'))
              ->first();
          
            $status = DB::table('medicalcert as m')
              ->select("s.id", "m.*")
              ->join('student_info as s', 'm.patientId', '=', 's.id')
              ->where("s.id", $decryptedId)
              ->where('m.campus',session('campus'))
              ->get();
      
        
            $newencryptedId = $response->id;
        
            return view('pages.medical-status-certificate', [
                'pageConfigs' => $pageConfigs,
                'breadcrumbs' => $breadcrumbs
            ], compact('status', 'name', 'request', 'newencryptedId'));
        }        
        } else if ($request->has('to_id')) {
          
          $name = DB::table('medicalcert')
            ->where('id', $this->aes->decrypt($request->to_id))
            ->where('campus',session('campus'))
            ->first();      
        
          $status = DB::table('medicalcert')
            ->where('id', $this->aes->decrypt($request->to_id))
            ->orderBy('updated_at', 'desc')
            ->where('campus',session('campus'))
            ->latest()
            ->get();
            
          $newencryptedId = $request->to_id;
          
          return view('pages.medical-status-certificate', [
              'pageConfigs' => $pageConfigs,
              'breadcrumbs' => $breadcrumbs
          ], compact('status', 'request', 'name', 'role', 'newencryptedId'));
              
        } else {
          return redirect()->back()->with('error', 'Invalid request!');
        }
    }
    public function saveCert(Request $request){
 
      $existingRecord = Medical::where('patientId', $this->aes->decrypt($request->patientId))
        ->where('findings', $request->diagnosis) 
        ->where('recommendation', $request->remarks)  
        ->where('weight', $request->weight)
        ->where('height', $request->height)
        ->where('blood_type', $request->bloodtype)
        ->where('temp', $request->temperature)
        ->where('pulse',$request->pulse_rate)
        ->where('res_rate', $request->res_rate)
        ->where('bp', $request->bp)
        ->where('campus',session('campus'))
        ->latest('patientId', $this->aes->decrypt($request->patientId))
        ->exists();


      $cert_issued = json_encode($request->cert_issued);
      $role =  $request -> role;

      $user =  DB::table('medicalcert')
        ->insert([
          'course'=> $request-> course,
          'accro'=> $request-> accro,
          'major'=> $request-> major,
          'yr' => $request ->yr,
          'campus' => session('campus'),
          'patientId' => $this->aes->decrypt($request->patientId),
          'role' => $role,
          'lastname' => $request -> lastname,
          'firstname' => $request -> firstname,
          'middlename' => $request -> middlename,
          'age' => $request -> age,
          'gender' => $request -> gender,
          'bday' => $request -> bday,
          'brgy' => $request -> brgy,
          'city' => $request -> city,
          'province' => $request -> province,
          'contactNo' => $request -> contactNo,
          'allergies' => $request -> allergies,
          'medication' => $request -> medication,
          'weight' => $request -> weight,
          'height' => $request -> height,
          'bloodtype' => $request -> bloodtype,
          'temperature' => $request -> temperature,
          'pulse_rate' => $request -> pulse_rate,
          'res_rate' => $request -> res_rate,
          'bp' => $request -> bp,
          'diagnosis' => $request -> diagnosis,
          'remarks' => $request -> remarks,
          'cert_issued' =>  $cert_issued,
          'purpose' =>  $request ->purpose,
          'status' =>  $request ->status,
          'others' => $request -> others,
          'date' => Carbon::now('Asia/Manila')->format('Y-m-d'),
          'created_at' => Carbon::now('Asia/Manila'),
        ]);

        if($role === 'Student'){
          
          $student = DB::table('student_info')
            ->where('StudentNo',$this->aes->decrypt($request->patientId))
            ->where('campus',session('campus'))
            ->update([
              'courses'=> $request-> course,
              'accro'=> $request-> accro,
              'major'=> $request-> major,
              'StudentYear' => $request ->yr,
              'brgy' => $request->brgy,
              'city' => $request->city,
              'province' => $request->province,
              'updated_at' =>  Carbon::now('Asia/Manila'),
            ]);
        }

        $role = $request->input('role');

        return response()->json([
          'status' => 200,
          'success'   => 'Saved Successfully!',
          'newID' => $request->patientId,
          'role' => $role
        ]);
    }
    public function updateRecord(Request $request){
      try {
        $update = DB::table('medicalcert')->where('id',$request->id)
        ->update([
          'weight' => $request->weight,
          'height' => $request->height,
          'bloodtype' => $request->bloodtype,
          'temperature' => $request->temperature,
          'pulse_rate' => $request->pulse_rate,
          'res_rate' => $request->res_rate,
          'bp' => $request->bp,
          'allergies' => $request->allergies,
          'medication' => $request ->medication,
          'diagnosis' => $request ->diagnosis,
          'remarks' => $request ->remarks,
          'others' => $request ->others,
          'campus'=> session('campus'),
          'cert_issued' => json_encode($request ->cert_issued),
          'updated_at' => Carbon::now('Asia/Manila')->toDateTimeString()
        ]);

        $response =DB::table('medicalcert')->where('id',$request->id)->where('campus',session('campus'))->first();

        $data = [
            'status' => 200,
            'success'   => 'Updated Successfully!',
            'id'   =>  $request->id,
            'patientId'   =>  $response->patientId,
            'lastname'   =>  $response->lastname,
            'firstname'   =>  $response->firstname,
            'middlename'   =>  $response->middlename,
            'course'   =>  $response->course,
            'StudentYear'   =>  $response->yr,
            'age'   =>  $response->age,
            'bday'   =>  $response->bday,
            'weight'   =>  $response->weight,
            'height'   =>  $response->height,
            'bloodtype'   =>  $response->bloodtype,
            'allergies'   =>  $response->allergies,
            'medication'   =>  $response->medication,
            'brgy'   =>  $response->brgy,
            'city'   =>  $response->city,
            'province'   =>  $response->province,
            'contactNo'   =>  $response->contactNo,
            'temperature'   =>  $response->temperature,
            'pulse_rate'   =>  $response->pulse_rate,
            'res_rate'   =>  $response->res_rate,
            'bp'   =>  $response->bp,
            'diagnosis'   =>  $response->diagnosis,
            'remarks'   =>  $response->remarks,
            'others' => $response->others,
            'cert_issued'  =>  $response->cert_issued,
            'campus'=> session('campus'),
            'role' => $role
        ];
        
        $role = $request->input('role');
          return response()->json($data);

            } catch (\Throwable $th) {
                dd('error',$th);
            }
    }
    public function approve(Request $request){
      try {
       
          $status = DB::table('medicalcert')
            ->where('id',$this->aes->decrypt($request->id))
            ->where('campus', session('campus'))
            ->update([
              'status' => $request->status,
              'updated_at' =>  Carbon::now('Asia/Manila')
            ]);
  
          $role = $request->input('role');
          return response()->json(['status' => 200,'success'   => 'Submitted Successfully!','newId' => $request->id,'role' => $role]);
        
          } catch (\Throwable $th) {
            dd('error',$th);
          }
    
    }
    public function generatedCert(Request $request){
      try {
        $cert = DB::table('medicalcert')
          ->where('id',$request->id)
          ->where('campus', session('campus'))
          ->update([
            'purpose' => $request->purpose,
            'generated_at' =>  Carbon::now('Asia/Manila')
          ]);
        
        return response()->json(['status' => 200,'success' => 'Submitted Successfully!']);
        } catch (\Throwable $th) {
          dd('error',$th);
        } 
    }
    public function view(Request $request){
      try {
  
        $recieve = DB::table('medicalcert')
          ->where('id',$this->aes->decrypt($request->id))
          ->where('campus',session('campus'))
          ->first();

        return response()->json($recieve);

          } catch (\Throwable $th) {
            dd('error',$th);
          }
    }
    public function deleteCert(Request $request)
    {
      $delete=DB::connection('mysql')->table('medicalcert')
        ->where('id', $this->aes->decrypt($request->id))
        ->where('campus', session('campus'))
        ->update([
            'deleted_at' => Carbon::now('Asia/Manila'),
        ]);

   
      return response()->json(['message' => 'Deleted successfully']);
   }
   public function generateMCPDF(Request $request){

        
      $response = DB::table('medicalcert')
        ->where("patientId", $this->aes->decrypt($request->id))
        ->where('campus', session('campus'))
        ->latest('id')
        ->first();

      $schoolyr =  date('Y', strtotime($response->date));
      $current_month = date('m', strtotime($response->date));
      
      if ($current_month >= 8 && $current_month <= 12) {
        $semester = '1';
        $schoolyr_start = $schoolyr; 
      } elseif ($current_month >= 6 && $current_month <= 7) {
        $semester = '2';
       $schoolyr_start = $schoolyr - 1;
      } elseif ($current_month >= 1 && $current_month <= 5) {
         $semester = '9';
       $schoolyr_start = $schoolyr - 1;
      }

     $schoolyr = $schoolyr_start;
      $syr = $schoolyr + 1;
      $addYear = $schoolyr . '-' . $syr;

      $doctor = DB::table('doctors')
        ->where('specialization','physician')
        ->where('campus',session('campus'))
        ->first();  

      return Pdf::loadView('pages.medical-certificate-form',compact('response','addYear','doctor'))->stream();
   }
   public function generateMCPDFgen(Request $request)
   {
      $response = DB::table('medicalcert')
        ->where("id", $this->aes->decrypt($request->id))
        ->where('campus',session('campus'))
        ->first();

      $schoolyr =  date('Y', strtotime($response->date));
      $current_month = date('m', strtotime($response->date));
      
      if ($current_month >= 8 && $current_month <= 12) {
        $semester = '1';
        $schoolyr_start = $schoolyr; 
      } elseif ($current_month >= 6 && $current_month <= 7) {
        $semester = '2';
       $schoolyr_start = $schoolyr - 1;
      } elseif ($current_month >= 1 && $current_month <= 5) {
         $semester = '9';
       $schoolyr_start = $schoolyr - 1;
      }


      $schoolyr = $schoolyr_start;
      $syr = $schoolyr + 1;
      $addYear = $schoolyr . '-' . $syr;
        
      $doctor = DB::table('doctors')
        ->where('specialization','physician')
        ->where('campus',session('campus'))
        ->first(); 
    
      return Pdf::loadView('pages.medical-generated-certificate-form',compact('response','addYear','doctor'))->stream();

 
   }
}

<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Collection;
use Illuminate\Pagination\Paginator;
use App\Student;
use App\Employee;
use App\Doctor;
use DataTables;
use App\Providers;
use Carbon\Carbon;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use App\Http\Controllers\AESCipher;
use App\Http\Controllers\MedClientAddController;
use Barryvdh\DomPDF\Facade\Pdf;

class DentalCertController extends Controller
{
  protected $aes;
  public function __construct(){
      $this->aes = new AESCipher;
  }
  public function index(){
    $pageConfigs = ['pageHeader' => true];
    $breadcrumbs = [
      ["link" => "/", "name" => "Home"],["name" => "Search"]
    ];
  
    return view('pages.dental-certificate',['pageConfigs'=>$pageConfigs,'breadcrumbs'=>$breadcrumbs]);
  }
  public function search(Request $request){ 
    try{
      if ($request->get('role') === 'Student') {
        
        $result = Student::where(function ($query) use ($request) {
            $query->where('StudentNo', 'like', '%' . $request->search . '%')
              ->orWhere('LastName', 'LIKE', '%' . $request->search . '%')
              ->orWhere('FirstName', 'LIKE', '%' . $request->search . '%');
          })
          ->where('campus',session('campus'))
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
      }else if ($request->get('role') === 'Employee') {
  
        $result = Employee::where(function ($query) use ($request) {
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
  public function view(Request $request){ 
    $pageConfigs = ['pageHeader' => true];
    $breadcrumbs = [
      ["link" => "/", "name" => "Home"],
      ["link" => "/dental-certificate", "name" => "Search"], 
      ["name" => "Patient Information"]
    ];
    $today = Carbon::today();
    $ldate = date('Y-m-d');

    $role = $request->get('role');
    $encryptedId = $request->id;
      
    if ($role === 'Student') {  
      $connection = MedClientAddController::getCampusConnection();

      $view = Student::where('StudentNo', $this->aes->decrypt($request->id))->where('campus',session('campus'))->first();

      $bdatetmp = explode(' ', $view->BirthDate);
      $newbday = $bdatetmp[2].'-'.str_pad($bdatetmp[0], 2, "0", STR_PAD_LEFT).'-'.str_pad($bdatetmp[1], 2, "1", STR_PAD_LEFT);
      $age = $today->diff($newbday)->y;

      $gender = $view->Sex;
      if ($gender === 'F') {
          $newgender = "Female";
      } else if ($gender === 'M') {
          $newgender = "Male";
      }

      return view('pages.dental-certificate-patient-information', ['pageConfigs' => $pageConfigs, 'breadcrumbs' => $breadcrumbs], compact( 'view','encryptedId', 'role', 'request','age','newgender','newbday','ldate'));      
    } else if($role === 'Employee'){ 

      $view =  Employee::where('AgencyNumber',$this->aes->decrypt($request->id))->where('campus',session('campus'))->first();
    
      $today = Carbon::today();
      $dateofbirth =$view->DateOfBirth;
      $age = $today->diff($dateofbirth)->y;
      
      $newgender = $view->Sex;

      $ldate = date('Y-m-d');
        
      return view('pages.dental-certificate-patient-information',['pageConfigs'=>$pageConfigs,'breadcrumbs'=>$breadcrumbs],compact('newgender','view','encryptedId','role','request','age','dateofbirth','ldate'));
    }
  }
  public function save(Request $request){
  try {
  
    $user =  DB::table('dentalcert')
      ->insert([
        'campus' => session('campus'),
        'patientId' => $this->aes->decrypt($request->patientId),
        'role' => $request -> role,
        'lastname' => $request -> lastname,
        'firstname' => $request -> firstname,
        'middlename' => $request -> middlename,
        'gender' => $request -> gender,
        'brgy' => $request -> brgy,
        'city' => $request -> city,
        'province' => $request -> province,
        'purpose' =>  $request ->purpose,
        'treated_by' =>  $request ->treated_by,
        'no_days' => $request -> no_days,
        'date' =>  $request -> date,
        'created_at' => Carbon::now('Asia/Manila'),
      ]);
      
      $role = $request->input('role');
      $newID = DB::table('dentalcert')->where('patientId', $this->aes->decrypt($request->patientId))->where('campus',session('campus'))->latest('id')->first();

      $ID= $this->aes->encrypt($newID->id);
      return response()->json(['status' => 200,'success'   => 'Saved Successfully!',
        'newID' => $ID,
        'role' => $role
      ]);

    } catch (\Throwable $th) {
      return response()->json([
        'error'   => 'Duplicate'
      ]);
    }
      return back();  
  }
  public function preview(Request $request){
      $pageConfigs = ['pageHeader' => true];
      $breadcrumbs = [["link" => "/", "name" => "Home"],
        ["link" => "/dental-generated-certificate", "name" => "Generate Certificate"],  
        ["name" => "Certificate"]
      ]; 
      
      $role = $request->get('role');
     
    
      $doctor = Doctor::where('specialization','dentist')
        ->where('campus',session('campus'))
        ->first(); 

      $response = DB::table('dentalcert')
        ->where("id", $this->aes->decrypt($request->id))
        ->whereNull('deleted_at')
        ->where('campus',session('campus'))
        ->first();

         $date = Carbon::parse($response->date);
      $formattedDay = $date->format('jS');
      $month = date("M", strtotime($date));
      $year = date("Y", strtotime($date));

      $newencryptedId = $this->aes->encrypt($response->id);
      $id = $this->aes->encrypt( $response->patientId);
    
      return view('pages.dental-preview-certificate', ['pageConfigs' => $pageConfigs, 'breadcrumbs' => $breadcrumbs], compact('response','request','newencryptedId','role', 'formattedDay','year','month','id','doctor'));
      
  }
  public function viewRecord(Request $request){
    $pageConfigs = ['pageHeader' => true];
    $breadcrumbs = [["link" => "/", "name" => "Home"], ["link" => "/medical-certificate", "name" => "Generate Certificate"], ["name" => "Generated Certificate Records"]];

    $record =  DB::table('dentalcert')->where('patientId',$this->aes->decrypt($request->id))->whereNull('deleted_at')->where('campus',session('campus'))->first();
        
    if ($record === null) {
      $role = $request->get('role');
      if ($role === 'Student') {
          $check =  Student::where('StudentNo',$this->aes->decrypt($request->id))->where('campus',session('campus'))->first();
        
          $error_message = 'No record found ';
          $namePatient =  $check->FirstName . ' ' . $check->MiddleName . ' ' . $check->LastName;
          
          session()->flash('error', $error_message);
          session()->flash('patient',$namePatient);

        return redirect()->route('backtoview')->with(['error', $error_message],['patient',$namePatient]);

      } else if ($role === 'Employee') {
          $check = Employee::where('AgencyNumber',$this->aes->decrypt($request->id))->where('campus',session('campus'))->first();
        
          $error_message = 'No record found ';
          $namePatient =  $check->FirstName . ' ' . $check->MiddleName . ' ' . $check->LastName;
      
          session()->flash('error', $error_message);
          session()->flash('patient',$namePatient);
        return redirect()->route('backtoview')->with(['error', $error_message],['patient',$namePatient]);
      }
    }else{
      if($request->has('id')){
        $role = $request->get('role');
        
          $list =  DB::table('dentalcert')
            ->where('patientId',$this->aes->decrypt($request->id))
            ->whereNull('deleted_at')
            ->where('campus',session('campus'))
            ->get();

          $newencryptedId =  DB::table('dentalcert')
            ->where('patientId',$this->aes->decrypt($request->id))
            ->whereNull('deleted_at')
            ->where('campus',session('campus'))
            ->first();

          return view('pages.dental-view-certificate',['pageConfigs'=>$pageConfigs,'breadcrumbs'=>$breadcrumbs],compact('list','newencryptedId','request','role'));
      }
    }
      return redirect();
  }
  public function modalEdit(Request $request){
    try {

      $recieve =  DB::table('dentalcert')
        ->where('id',$this->aes->decrypt($request->id))
        ->whereNull('deleted_at')
        ->where('campus',session('campus'))
        ->first();

      return response()->json($recieve);

    } catch (\Throwable $th) {
      dd('error',$th);
    }
  }
  public function updateRecord(Request $request){
    try {
      $update =  DB::table('dentalcert')
        ->where('id',$request->id)
        ->where('campus',session('campus'))
        ->update([
          'date' => $request->date,
          'treated_by' => $request->treated_by,
          'no_days' => $request->no_days,
          'updated_at' => Carbon::now('Asia/Manila'),
        ]);

      $response = DB::table('dentalcert')
        ->where('id',$request->id)
        ->where('campus',session('campus'))
        ->whereNull('deleted_at')
        ->first();
        

      $role = $request->input('role');

      return response()->json(['status' => 200,'success'   => 'Updated Successfully!','id'   =>  $this->aes->encrypt($request->id),'date'   =>  $response->date,'treated_by'   =>  $response->lastname,'no_days'   =>  $response->lastname,'role' => $role]);
   
    } catch (\Throwable $th) {
        dd('error',$th);
    }
  }
  public function generateDMPDF(Request $request){
  
    $schoolyr = date('Y');
    $syr = $schoolyr + 1;
    $addYear = $schoolyr.'-'.$syr;
  
    $response = DB::table('dentalcert as d')
      ->join('student_info as s','s.StudentNo','=', 'd.patientId')
      ->select('s.accro','s.StudentNo','s.BirthDate','d.firstname','d.middlename','d.lastname','d.brgy','d.city','d.province','d.treated_by','d.no_days','d.date','d.id')
      ->where("d.patientId", $this->aes->decrypt($request->id))
      ->where('d.campus',session('campus'))
      ->latest('d.id')
      ->first();
  
    $date = Carbon::parse($response->date);
    $formattedDay = $date->format('jS');
    $month = date("M", strtotime($date));
    $year = date("Y", strtotime($date));

    $doctor = Doctor::where('specialization','dentist')
      ->where('campus',session('campus'))
      ->first(); 

    return Pdf::loadView('pages.dental-certificate-form',compact('year','month','formattedDay','response','addYear','doctor'))->stream();
  }
  public function deleteRecord (Request $request){
    $delete = DB::table('dentalcert')->where('id', $this->aes->decrypt($request->id))
                ->update([
                    'deleted_at' =>  Carbon::now('Asia/Manila'),
                ]);

    return response()->json(['message' => 'Deleted successfully']);
  }
}

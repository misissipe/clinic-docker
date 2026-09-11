<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Collection;
use Illuminate\Pagination\Paginator;
use\App\Student;
use\App\Employee;
use\App\HealthHistory;
use\App\Medical;
use DataTables;
use\App\Providers;
use Carbon\Carbon;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use App\Http\Controllers\AESCipher;
use App\Http\Controllers\MedClientAddController;
use Barryvdh\DomPDF\Facade\Pdf;

class ReferralController extends Controller
{
    protected $aes;
    public function __construct(){
        $this->aes = new AESCipher;
    }
    public function index(){
      $pageConfigs = ['pageHeader' => true];
      $breadcrumbs = [["link" => "/", "name" => "Home"],["name" => "Search"]];

      return view('pages.referral-slip',['pageConfigs'=>$pageConfigs,'breadcrumbs'=>$breadcrumbs]);
    }
    public function search(Request $request){ 
      try{
        if ($request->get('role') === 'Student') {
          $search = $request->input('search');
      
          $result = Student::where(function ($query) use ($request) {
             $query->where('StudentNo', 'like', '%' . $request->search . '%')
              ->orWhere('LastName', 'LIKE', '%' . $request->search . '%')
              ->orWhere('FirstName', 'LIKE', '%' . $request->search . '%');
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
     
        $search = $request->input('search');
      
          $result = Employee::where(function ($query) use ($request) {
            $query->where('AgencyNumber', 'like', '%' . $request->search . '%')
              ->orWhere('LastName', 'LIKE', '%' . $request->search . '%')
              ->orWhere('FirstName', 'LIKE', '%' . $request->search . '%');
          })
          ->where('campus', session('campus'))
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
    public function referalPatientInfo(Request $request){
      $pageConfigs = ['pageHeader' => true];
      $breadcrumbs = [["link" => "/", "name" => "Home"],
      ["link" => "/referral-slip", "name" => "Search"],
      ["name" => "Patient Information"]];
     
        $today = Carbon::today();
        $role = $request->get('role');

      $check = HealthHistory::where('patientId',$this->aes->decrypt($request->id))->where('campus', session('campus'))->first();
      if (empty($check)){

          $error_message = 'No Health History';
          $namePatient =  $name->FirstName . ' ' . $name->MiddleName . ' ' . $name->LastName;

          session()->flash('error', $error_message);
          session()->flash('patient',$namePatient);
          return redirect()->route('backtoReferral')->with(['error', $error_message],['patient',$namePatient]);

        }else{
          if ($role === 'Student') { 
     
        $schoolyr = date('Y');
        $current_month = date('n');
            
      
        if ($current_month >= 6 && $current_month <= 12) {
            $semester = [1, 9];
            $schoolyr_start = [$schoolyr - 1, $schoolyr]; 
        } else {
              $semester = [2];
              $schoolyr_start = [$schoolyr - 1]; 
        }

        $view = DB::table('student_info as s')
              ->join('health_history as h', 's.StudentNo', '=', 'h.patientId')
              ->where('s.StudentNo', $this->aes->decrypt($request->id))
              ->select('s.*', 'h.*')
              ->where('s.campus',session('campus'))
              ->first();

        $bdatetmp = explode(' ', $view->BirthDate);
        $newbday = $bdatetmp[2].'-'.str_pad($bdatetmp[0], 2, "0", STR_PAD_LEFT).'-'.str_pad($bdatetmp[1], 2, "1", STR_PAD_LEFT);
        $age = $today->diff($newbday)->y;

     } else if ($role === 'Employee') { 
        $view = DB::table('employee_info as e')
                ->join('health_history as h', 'e.AgencyNumber', '=', 'h.patientId')
                ->where('e.AgencyNumber', $this->aes->decrypt($request->id))
                ->select('e.*', 'h.*')
                ->where('e.campus', session('campus'))
                ->first();

        $today = Carbon::today();
        $newbday =$view->DateOfBirth;
        $age = $today->diff($newbday)->y;
        
       
      }
      $mr = DB::table('medicalrecord')
              ->where('id',$request->recId)
              ->whereJsonContains('purpose', 'Referral')
              ->latest('id')
              ->first();
        
        $id = $request->id;

         return view('pages.referral-patient-information',['pageConfigs'=>$pageConfigs,'breadcrumbs'=>$breadcrumbs],compact('view','id','role','age','newbday','mr'));
    }
      return back();
    }
    public function saveRefer(Request $request){

      $referTo = $request->referTo;
      $role = $request->role;

      $save = DB::table('referral')
        ->insert([
          'campus' => session('campus'),
          'patientId' => $this->aes->decrypt($request->patientId),
          'role' =>$role,
          'lastname' => $request->lastname,
          'firstname' => $request->firstname,
          'middlename' => $request->middlename,
          'age' => $request->age,
          'gender' => $request->gender,
          'ContactNo' => $request->ContactNo,
          'guardian' => $request->guardian,
          'g_ContactNo' => $request->g_ContactNo,
          'g_Address' => $request->g_Address,
          'course' => $request->accro,
          'yr' => $request->yr,
          'bday' => $request->bday,
          'civil_stat' => $request->civil_stat,
          'nationality' => $request->nationality,
          'religion' => $request->religion,
          'brgy' => $request->brgy,
          'city' => $request->city,
          'province' => $request->province,
          'referTo' => $referTo,
          'others' => $request->others,
          'reason' => $request->reason,
          'complaint' => $request->complaint,
          'action_taken' => $request->action_taken,
          'bp' => $request->bp,
          'temp' => $request->temp,
          'pr' => $request->pr,
          'rr' => $request->rr,
          'weight' => $request->weight,
          'height' => $request->height,
          'b_brgy' => $request->b_brgy,
          'b_city' => $request->b_city,
          'b_province' => $request->b_province,
          'date' => Carbon::now('Asia/Manila')->format('Y-m-d'),
          'created_at' => Carbon::now('Asia/Manila'),
        ]);

        if($role === 'Student'){
          $student = DB::table('student_info')
          ->where('StudentNo',$this->aes->decrypt($request->patientId))
          ->where('campus',session('campus'))
          ->update([
            'brgy' => $request->brgy,
            'city' => $request->city,
            'province' => $request->province,
            'updated_at' =>  Carbon::now('Asia/Manila'),
          ]);
        }
    
        // $medicalRecord = DB::table('medicalrecord')
        //   ->insert([
        //     'positioncourse'=> $request-> accro,
        //     'campus' => session('campus'),
        //     'patientId' => (new AESCipher)->decrypt($request->patientId),
        //     'role' => $request -> role,
        //     'age' =>   $request->age ,
        //     'gender' => $request->sex,
        //     'findings' => $request -> findings,
        //     'purpose' => $request -> purpose,
        //     'date' => Carbon::now()->format('Y-m-d'),
        //     'created_at' => Carbon::now(),
        //     'updated_at' =>  null,
        //     'deleted_at' =>  null
        //   ]);

      $role = $request->input('role');
      $newId = DB::connection('mysql')->table('referral')->latest('id')->where('campus', session('campus'))->first();  
      
      $latestmedCertId = $this->aes->encrypt($newId->id);
      // $response =DB::table('referral as r')->join('student_info as s','r.patientId','=','s.id')->select('s.*','r.*')->latest('r.id')->first();
      return response()->json([
        'status' => 200,
        'success'   => 'Saved Successfully!',
        'id'   =>  $latestmedCertId,
        'role' => $role
       ]);
        return back(); 
    }
    public function previewReferral(Request $request){

      if ($request->has('id')) {
          $pageConfigs = ['pageHeader' => true];
          $breadcrumbs = [["link" => "/", "name" => "Home"],
          ["link" => "/referral-slip", "name" => "Search"],
          ["name" => "Slip for Approval"]];
          // $cipher = new AESCipher;
        
          $role = $request->get('role');
       
          if ($role === 'Student') { 
            $response = DB::table('referral')
            ->where("id", $this->aes->decrypt($request->id))
            ->where('campus', session('campus'))
            ->first();

          $view = DB::table('student_info')->where('StudentNo',$response->patientId)->first();

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
  
          $course = DB::connection($connection)->table('registration as r')
              ->select('c.id', 'c.course_title', 'c.accro', 's.*', 'r.StudentNo', 'r.Course', 'm.course_major', 'r.StudentYear', 'r.SchoolYear', 'r.Semester')
              ->join('students as s', 'r.StudentNo', '=', 's.StudentNo')
              ->join('course as c', 'c.id', '=', 'r.Course')
              ->join('major as m', 'm.id', '=', 's.Major')
              ->where('r.StudentNo', $view->StudentNo)
              ->where('r.SchoolYear', $schoolyr_start)
              ->where('r.Semester', $semester)
              ->orderBy('r.SchoolYear', 'desc')
              ->first();

          #for New Birthday
          $today = Carbon::today();
          $bdatetmp = explode(' ', $view->BirthDate);
          $newbday = $bdatetmp[2].'-'.str_pad($bdatetmp[0], 2, "0", STR_PAD_LEFT).'-'.str_pad($bdatetmp[1], 2, "1", STR_PAD_LEFT);
          $age = $today->diff($newbday)->y;

          $currentMonth = date('n');
          $schoolYearStartMonth = 8;
  
          if ($currentMonth >= $schoolYearStartMonth) {
              $schoolYear = date('Y');
          } else {
              $schoolYear = date('Y') - 1;
          }
  
          $nextSchoolYear = $schoolYear + 1;
  
          $addYear = $schoolYear . '-' . $nextSchoolYear;

          $encryptedId= $this->aes->encrypt($response->id);

          $doctor = DB::table('doctors')
            ->where('specialization','physician')
            ->where('campus',session('campus'))
            ->first(); 
     
          return view('pages.referral-preview-slip',['pageConfigs'=>$pageConfigs,'breadcrumbs'=>$breadcrumbs],compact('response','request','cipher','role','encryptedId','addYear','age','newbday','course','doctor'));
         
         }else if ($role === 'Employee') { 
          $response = DB::table('referral')
            ->where("id", $this->aes->decrypt($request->id))
            ->where('campus', session('campus'))
            ->latest('id')
            ->first();

          $today = Carbon::today();
          $newbday =$response->bday;
          $age = $today->diff($newbday)->y;

          $doctor = DB::table('doctors')
            ->where('specialization','dentist')
            ->where('campus',session('campus'))
            ->first(); 

          $encryptedId= $this->aes->encrypt($response->id);
          return view('pages.referral-preview-slip',['pageConfigs'=>$pageConfigs,'breadcrumbs'=>$breadcrumbs],compact('response','request','cipher','role','encryptedId','newbday','age','doctor'));
          } 
        } elseif ($request->has('to_id')) {

        $pageConfigs = ['pageHeader' => true];
        $breadcrumbs = [
        ["link" => "/", "name" => "Home"],
        ["link" => "/referral-slip", "name" => "Search"],
        ["link" => "/referral-view-record", "name" => "Generated Referral Record"],
        ["name" => "Slip for Approval"]];
        // $cipher = new AESCipher;
        $role = $request->get('role');
         
        if ($role === 'Student') { 

          $course = DB::table('student_info as s')
            ->join('referral as r','r.patientId','=','s.StudentNo')
            ->where('r.id',$this->aes->decrypt($request->to_id))
            ->where('campus',session('campus'))
            ->first();

          #for New Birthday
          $today = Carbon::today();
          $bdatetmp = explode(' ', $course->BirthDate);
          $newbday = $bdatetmp[2].'-'.str_pad($bdatetmp[0], 2, "0", STR_PAD_LEFT).'-'.str_pad($bdatetmp[1], 2, "1", STR_PAD_LEFT);
          $age = $today->diff($newbday)->y;

          $currentMonth = date('n');
          $schoolYearStartMonth = 8;
  
          if ($currentMonth >= $schoolYearStartMonth) {
              $schoolYear = date('Y');
          } else {
              $schoolYear = date('Y') - 1;
          }
  
          $nextSchoolYear = $schoolYear + 1;
  
          $addYear = $schoolYear . '-' . $nextSchoolYear;
          
          $response = DB::table('referral')
            ->where("id", $this->aes->decrypt($request->to_id))
            ->where('campus', session('campus'))
            ->latest('id')
            ->first();

        $encryptedId= $this->aes->encrypt($response->id);

        $doctor = DB::table('doctors')
        ->where('specialization','dentist')
        ->where('campus',session('campus'))
        ->first(); 
        
        return view('pages.referral-preview-slip',['pageConfigs'=>$pageConfigs,'breadcrumbs'=>$breadcrumbs],compact('response','request','cipher','role','encryptedId','addYear','age','newbday','course','doctor'));
        }else if ($role === 'Employee') { 
          // $cipher = new AESCipher;
          $response = DB::table('referral')
          ->where("empNo", $this->aes->decrypt($request->to_id))
          ->where('campus', session('campus'))
          ->latest('id')
          ->first();

          $doctor = DB::table('doctors')
          ->where('specialization','dentist')
          ->where('campus',session('campus'))
          ->first(); 
          
          $encryptedId= $this->aes->encrypt($response->id);

          return view('pages.referral-preview-slip',['pageConfigs'=>$pageConfigs,'breadcrumbs'=>$breadcrumbs],compact('response','request','cipher','role','encryptedId','doctor'));
          }  
      } else {
          return redirect()->back()->with('error', 'Invalid request!');
      }
    }
    public function pendingSlip(Request $request){
      try {
        
        $role = $request->get('role');
     
        $status = DB::connection('mysql')->table('referral')
        ->where('id',$this->aes->decrypt($request->id))
        ->update([
          'status' => $request->status,
          'stat_remarks' => '',
          'updated_at' =>  Carbon::now('Asia/Manila')
        ]);
       
        $newID = $request->id;

        return response()->json(['status' => 200,'success'   => 'Submitted Successfully!','newID' =>  $newID,'role'  => $role]);

        } catch (\Throwable $th) {
          dd('error',$th);
        }
    }
    public function statusSlip(Request $request){
       
      if ($request->has('id')) {
          $pageConfigs = ['pageHeader' => true];
          $breadcrumbs = [
            ["link" => "/", "name" => "Home"],
            ["link" => "/referral-slip", "name" => "Search"],
            ["link" => "/referral-view-record", "name" => "Generated Referral Record"],
            ["name" => "Slip Status"]];
         
          $role = $request->get('role');
       
        if ($role === 'Student') { 
          $name = DB::table('referral')->where('patientId',$this->aes->decrypt($request->id))->first();
          $status = DB::table('referral as r')
            ->select("s.*","r.*")
            ->join('student_info as s','r.patientId','=','s.StudentNo')
            ->where("s.StudentNo", $this->aes->decrypt($request->id))
            ->where('s.campus',session('campus'))
            ->get();

          return view('pages.referral-status-slip',['pageConfigs'=>$pageConfigs,'breadcrumbs'=>$breadcrumbs],compact('name','status','request'));
        } else  if ($role === 'Employee') { 
          $name = DB::table('referral')->where('patientId',$this->aes->decrypt($request->id))->first();
          $status = DB::table('referral as r')
            ->select("e.*","r.*")
            ->join('employee_info as e','r.patientId','=','e.empNo')
            ->where("e.empNo", $this->aes->decrypt($request->id))
            ->where('e.campus', session('campus'))
            ->get();

          return view('pages.referral-status-slip',['pageConfigs'=>$pageConfigs,'breadcrumbs'=>$breadcrumbs],compact('name','status','request'));
        }

        } elseif ($request->has('to_id')) {
            $pageConfigs = ['pageHeader' => true];
            $breadcrumbs = [
              ["link" => "/", "name" => "Home"],
              ["link" => "/referral-slip", "name" => "Search"],
              ["link" => "/referral-preview-slip", "name" => "Slip for Approval"],
              ["name" => "Slip Status"]
            ];

            $role = $request->get('role');

            if ($role === 'Student') { 

              $name = DB::table('referral')->where('id',$this->aes->decrypt($request->to_id))->where('campus',session('campus'))->first();

              $status = DB::table('referral')
                ->where("id", $this->aes->decrypt($request->to_id))
                ->where('campus', session('campus'))
                ->get();
    
              return view('pages.referral-status-slip',['pageConfigs'=>$pageConfigs,'breadcrumbs'=>$breadcrumbs],compact('name','status','request'));
            } else  if ($role === 'Employee') { 
              $name = DB::table('referral')->where('id',$this->aes->decrypt($request->to_id))->where('campus', session('campus'))->first();
              $status = DB::table('referral')
                ->where("id", $this->aes->decrypt($request->to_id))
                ->where('campus', $this->campus)
                ->get();
    
              return view('pages.referral-status-slip',['pageConfigs'=>$pageConfigs,'breadcrumbs'=>$breadcrumbs],compact('name','status','request'));
            }
        } else {
            return redirect()->back()->with('error', 'Invalid request!');
        }

    }
    public function viewMedicalRecord(Request $request){
      $pageConfigs = ['pageHeader' => true];
      $breadcrumbs = [
        ["link" => "/", "name" => "Home"],
        ["link" => "/referral-slip", "name" => "Search"],
        ["name" => "Generated Referral Record"]
      ];      
      // dd((new AESCipher)->decrypt($request->id)); 
   
      $record = DB::table('referral')->where('patientId',$this->aes->decrypt($request->id))->where('campus', session('campus'))->whereNull('deleted_at')->first();

      if ($record === null) {
        $role = $request->get('role');
      
        if ($role === 'Student') {
      
           $check = Student::where('StudentNo',$this->aes->decrypt($request->id))->where('campus',session('campus'))->first();
          //  dd($check);
            $error_message = 'No record found ';
            $namePatient =  $check->FirstName . ' ' . $check->MiddleName . ' ' . $check->LastName;
          
            session()->flash('error', $error_message);
            session()->flash('patient',$namePatient);
            return redirect()->route('backtoslip')->with(['error', $error_message],['patient',$namePatient]);
        } else if ($role === 'Employee') {
          $check = Employee::where('AgencyNumber',$this->aes->decrypt($request->id))->where('campus',session('campus'))->first();
         
          $error_message = 'No record found ';
          $namePatient =  $check->FirstName . ' ' . $check->MiddleName . ' ' . $check->LastName;
          
          session()->flash('error', $error_message);
          session()->flash('patient',$namePatient);
          return redirect()->route('backtoslip')->with(['error', $error_message],['patient',$namePatient]);
        }else {
          return redirect()->back()->with('error', 'Invalid request!');
        }
       } else {
        if($request->has('id')){
          $role = $request->get('role');

            $cipher = new AESCipher;
            $name = DB::table('referral')->where('patientId',$this->aes->decrypt($request->id))->where('campus',session('campus'))->first();
            $record = DB::table('referral')->where('patientId',$this->aes->decrypt($request->id))->whereNull('deleted_at')->where('campus', session('campus'))->get();
         
            return view('pages.referral-view-record',['pageConfigs'=>$pageConfigs,'breadcrumbs'=>$breadcrumbs],compact('record','name','cipher','request','role'));

        } elseif($request->has('to_id')){
          $role = $request->get('role');
        
            $cipher = new AESCipher;
            $name = DB::table('referral')->where('id',$this->aes->decrypt($request->to_id))->where('campus', session('campus'))->first();
            $record = DB::table('referral')->where('id', $this->aes->decrypt($request->to_id))->whereNull('deleted_at')->where('campus',session('campus'))->get();

            return view('pages.referral-view-record',['pageConfigs'=>$pageConfigs,'breadcrumbs'=>$breadcrumbs],compact('record','name','cipher','request','role'));
        }
        else {
          return redirect()->back()->with('error', 'Invalid request!');
        }
      }
       
       return redirect();  
    }
    public function saveEdit(Request $request){

      $save = DB::table('referral')
      ->where('id',$this->aes->decrypt($request->id))
      ->update([
          'date' => $request->date,
          'referTo' => $request->referTo,
          'others' => $request->others,
          'reason' => $request->reason,
          'updated_at' =>  Carbon::now('Asia/Manila')->toDateTimeString() ,
      ]);

      $response =DB::table('referral as r')
      ->join('student_info as s','r.patientId','=','s.StudentNo')
      ->select('s.*','r.*')
      ->where('r.id',$this->aes->decrypt($request->id))
      ->where('s.campus', session('campus'))
      ->first();
      
       
      $role = $request->input('role');
     
      return response()->json([
        'status' => 200,
        'success'   => 'Saved Successfully!',
        'id'   =>   $request->id,
        'patientId'   =>  $response->patientId,
        'role' => $role
        
       ]);
      // } catch (\Throwable $th) {
      //   return response()->json([
      //     'error'   => 'Duplicate'
      //    ]);
      // }
        return back(); 
    }
    public function uploadReturnSlip(Request $request){
     
      $pageConfigs = ['pageHeader' => true];
      $breadcrumbs = [
        ["link" => "/", "name" => "Home"],
        ["link" => "/referral-slip", "name" => "Search"],
        ["name" => "Return Slip"]
      ];
      $name = Student::where('id',$request->id)->where('cammpus',session('campus'))->first();

        $return = DB::table('referral as r')
        ->select("s.*","r.*")
        ->join('student_info as s','r.patientId','=','s.StudentNo')
        ->where("s.StudentNo", $request->id)
        ->where('s.campus', session('campus'))
        ->get();
            
      return view('pages.referral-upload-return-slip',['pageConfigs'=>$pageConfigs,'breadcrumbs'=>$breadcrumbs],compact('return','name'));
    }
    public function upload(Request $request){

      $files[] = $request->file('file');
   
      if (!is_null($files) && is_array($files)) {
        foreach ($files as $file) {
          $uploadPath = env('APP_NAME').'/return_slip';
          if (!\Storage::exists($uploadPath)) {
              \Storage::makeDirectory($uploadPath);
          }
          $fileName = $file->getClientOriginalName();
          $storedFilePath = $file->storeAs($uploadPath, $fileName);          
          $file->move('storage/'. $uploadPath, $fileName);
    
          
          $storeFile=DB::table('referral')
          ->where('id',$this->aes->decrypt($request->id))
          ->update([
            'campus' => session('campus'),
            'file_name' => $fileName,
            'file_directory'=> 'storage/'.$uploadPath.'/'.$fileName,
            'uploaded_at' => Carbon::now('Asia/Manila')
          ]);
        }
        session()->flash('success', 'File(s) successfully uploaded.');
      } 
      return back();
    }
    public function viewStatus(Request $request){
     
      $pageConfigs = ['pageHeader' => true];
      $breadcrumbs = [
        ["link" => "/", "name" => "Home"],
        ["link" => "/referral-slip", "name" => "Search"],
        ["name" => "Referral Slip Status"]
      ];

        $name = DB::table('referral')->where('id',$request->id)->where('campus',session('campus'))->first();

        $view = DB::table('referral')
          ->where("patientId", $request->id)
          ->where('campus',session('campus'))
          ->get();
            
      return view('pages.referral-view-status',['pageConfigs'=>$pageConfigs,'breadcrumbs'=>$breadcrumbs],compact('view','name'));
    }
    public function viewForPrint(Request $request){
     
      $pageConfigs = ['pageHeader' => true];
      $breadcrumbs = [
        ["link" => "/", "name" => "Home"],
        ["link" => "/referral-slip", "name" => "Search"],
        ["link" => "/referral-view-status", "name" => "Referral Slip Status"],
        ["name" => "Generated Referral Slip"]
      ];
      $role = $request->get('role');

        $doctor = DB::table('doctors')
        ->where('specialization','physician')
        ->where('campus', session('campus'))
        ->first(); 

      if ($role === 'Student') {
      $name = Student::where('StudentNo',$this->aes->decrypt($request->to_id))->where('campus', session('campus'))->first();

        $generate = DB::table('referral as r')
          ->select("s.*","r.*")
          ->join('student_info as s','r.patientId','=','s.StudentNo')
          ->where("r.id", $this->aes->decrypt($request->to_id))
          ->where('s.campus', session('campus'))
          ->first();

          

          $currentMonth = date('n');
          $schoolYearStartMonth = 8;
  
         if ($currentMonth >= $schoolYearStartMonth) {
              $schoolYear = date('Y');
          } else {
              $schoolYear = date('Y') - 1;
         }
  
        $nextSchoolYear = $schoolYear + 1;
  
        $addYear = $schoolYear . '-' . $nextSchoolYear;  

        $today = Carbon::today();

        $bdatetmp = explode(' ', $generate->BirthDate);
        $newbday = $bdatetmp[2].'-'.str_pad($bdatetmp[0], 2, "0", STR_PAD_LEFT).'-'.str_pad($bdatetmp[1], 2, "1", STR_PAD_LEFT);
        $age = $today->diff($newbday)->y;
       
      return view('pages.referral-generated-referral-slip',['pageConfigs'=>$pageConfigs,'breadcrumbs'=>$breadcrumbs],compact('generate','name','age','newbday','addYear','request','doctor'));
      } else if ($role === 'Employee') {
        $name = Employee::where('AgencyNumber',$this->aes->decrypt($request->to_id))->where('campus',session('campus'))->first();
  
          $generate = DB::table('referral as r')
            ->select("e.*","r.*")
            ->join('employee_info as e','r.patientId','=','e.AgencyNumber')
            ->where("r.id", $this->aes->decrypt($request->to_id))
            ->where('e.campus',session('campus'))
            ->first();
         
        return view('pages.referral-generated-referral-slip',['pageConfigs'=>$pageConfigs,'breadcrumbs'=>$breadcrumbs],compact('generate','name','request','doctor'));
        }
    }
    public function view(Request $request){
      try {

        $view = DB::table('referral')
        ->where("id", $this->aes->decrypt($request->id))
        ->where('campus', session('campus'))
        ->first();

        return response()->json(['view' =>$view,'newID' => $request->id]);

        } catch (\Throwable $th) {
           dd('error',$th);
        }
    }

    public function generatedSlip(Request $request){
      try {
        $cert = DB::table('referral')
        ->where('id',$request->id)
        ->update([
          'purpose' => $request->purpose,
          'generated_at' =>  Carbon::now('Asia/Manila')
        ]);
            
        return response()->json(['status' => 200,'success' => 'Submitted Successfully!']);
        } catch (\Throwable $th) {
            dd('error',$th);
        }
    }
    public function modalUpload(Request $request){
      $uploadReturnSlip = DB::table('referral')->where('id', $this->aes->decrypt($request->id))->where('campus',session('campus'))->first();
      $newID = $request->id;

      return response ([
          'uploadReturnSlip' =>  $uploadReturnSlip,
          'status'    => 200,
          'newID' => $newID
      ]);
    }
    public function generateRSPDF(Request $request)
    {
      // dd((new AESCipher)->decrypt($request->id));
      $schoolyr = date('Y');
      $current_month = date('n');
      if ($current_month >= 6 && $current_month <= 12) {
        $semester = [1, 9];
        $schoolyr_start = [$schoolyr - 1, $schoolyr]; 
      } else {
        $semester = [2];
        $schoolyr_start = [$schoolyr - 1]; 
      }
      $syr = $schoolyr + 1;
      $addYear = $schoolyr.'-'.$syr;
         
      $response = DB::table('referral')
        ->where("id", $this->aes->decrypt($request->id))
        ->where('campus',session('campus'))
        ->first();

      $doctor = DB::table('doctors')
        ->where('specialization','physician')
        ->where('campus',session('campus'))
        ->first(); 
      
     return Pdf::loadView('pages.referral-slip-form', compact('response', 'addYear', 'doctor'))
    ->setPaper([0, 0, 612, 936], 'portrait') 
    ->stream();


    }
}

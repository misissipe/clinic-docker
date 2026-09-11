<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Collection;
use Illuminate\Pagination\Paginator;
use App\Student;
use App\Treatment;
use App\Appointment;
use DataTables;
use App\Providers;
use Carbon\Carbon;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use App\Http\Controllers\AESCipher; 
use App\Http\Controllers\MedClientAddController;
use Barryvdh\DomPDF\Facade\Pdf;
class DentalClientAddController extends Controller
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
     //   $student = DB::connection('sg')->table('students')->get('StudentNo');

      return view('pages.student-dental-record',['pageConfigs'=>$pageConfigs,'breadcrumbs'=>$breadcrumbs]);
    }
     public function dentalChart(Request $request){
      $pageConfigs = ['pageHeader' => true];
      $breadcrumbs = [
        ["link" => "/", "name" => "Home"],
        ["link" => "/search-dental-record", "name" => "Search"], 
        ["name" => "Dental Record Chart"]
      ];
        $connection = MedClientAddController::getCampusConnection();

        $record = DB::connection($connection)->table('students')->where('StudentNo', $this->aes->decrypt($request->StudentId))->first();
       
        $dentalchart = DB::table('dentalchart')
            ->where('id', $this->aes->decrypt($request->StudentId))
            ->where('campus',session('campus'));

        $newencryptedId = $request->StudentId;
             
        $course = DB::connection($connection)->table('registration as r')
            ->select('c.id', 'c.course_title', 'c.accro', 's.*', 'r.StudentNo', 'r.Course', 'm.course_major', 'r.StudentYear', 'r.SchoolYear')
            ->join('students as s', 'r.StudentNo', '=', 's.StudentNo')
            ->join('course as c', 'c.id', '=', 'r.Course')
            ->join('major as m', 'm.id', '=', 's.Major')
            ->where('r.StudentNo', $record->StudentNo)
            ->orderBy('r.SchoolYear', 'desc')
            ->first();

        $today = Carbon::today();

        $bdatetmp = explode(' ', $course->BirthDate);
        $newbday = $bdatetmp[2].'-'.str_pad($bdatetmp[0], 2, "0", STR_PAD_LEFT).'-'.str_pad($bdatetmp[1], 2, "1", STR_PAD_LEFT);
        $age = $today->diff($newbday)->y;
    
        if($record->Sex === 'F'){
            $gender = 'Female';
        }else if($record->Sex === 'M'){
            $gender = 'Male';
        }

        $details = DB::table('dentalchart')->where('id', $this->aes->decrypt($request->StudentId))->where('campus',session('campus'))->first();
       
        if($details){
            $issueDetails = json_decode($details->dental_issues,true);
        }else{
            $issueDetails = null;
        }
       
        return view('pages.student-dental-chart', ['pageConfigs' => $pageConfigs,'breadcrumbs' => $breadcrumbs], compact('record','dentalchart','newencryptedId','course','newbday','age','gender', 'details','issueDetails'));
    }
    
//TREATMENT RECORD
    public function treatmentRecord(Request $request){
        $pageConfigs = ['pageHeader' => true];
        $breadcrumbs = [
            ["link" => "/", "name" => "Home"],
            ["link" => "/search-dental-record", "name" => "Search"], 
            ["link" => "/dental-record-chart", "name" => "Dental Record Chart"], 
            ["name" => "Treatment Record"]
        ];

        
            if ($request->has('id')) {
            $details = DB::table('dentalchart')->where('id', $this->aes->decrypt($request->id))->where('role',$request->role)->where('campus',session('campus'))->first();

            if($details){
                $issue = json_decode($details->dental_issues,true);
            }else{
                $issue = null;
            }
        
            $today = Carbon::today();
            if ($details->role === 'Student')
            {
                if (preg_match('/^\d{1,2} \d{1,2} \d{4}$/', $details->birthdate)) {
                    $bdatetmp = explode(' ', $details->birthdate);
                    $newbday = $bdatetmp[2].'-'.str_pad($bdatetmp[0], 2, "0", STR_PAD_LEFT).'-'.str_pad($bdatetmp[1], 2, "0", STR_PAD_LEFT);
                    $age = $today->diff($newbday)->y;
                } else {
    
                    $dateofbirth = $details->birthdate;
                    $age = $today->diff($dateofbirth)->y;
                }
            }elseif($details->role === 'Employee'){
                $dateofbirth =$details->birthdate;
                $age = $today->diff($dateofbirth)->y;
            }elseif($details->role === 'Dependent'){
                $newId = $request->id;
                return view('pages.dental-treatment-record', ['data' => $details,'issueDetails' => $issue,'newId' => $newId,'pageConfigs' => $pageConfigs,'breadcrumbs' => $breadcrumbs,]);
            }
        
            $newId = $request->id;

            return view('pages.dental-treatment-record', ['data' => $details,'issueDetails' => $issue,'newId' => $newId,'pageConfigs' => $pageConfigs,'breadcrumbs' => $breadcrumbs, 'age' => $age,]);
        } elseif ($request->has('to_id')) {

            $details = DB::table('dentalchart as d')
                ->select('d.*','t.*')
                ->join('treatmentrecord as t', 't.patientId','=','d.id')
                ->where('t.id',  $request->to_id)
                ->where('t.campus',session('campus'))
                ->first();

            $issue = json_decode($details->dental_issues,true);
            $newId = $request->to_id;

            $today = Carbon::today();
            if ($details->role === 'Student')
            {
                if (preg_match('/^\d{1,2} \d{1,2} \d{4}$/', $details->birthdate)) {
                    $bdatetmp = explode(' ', $details->birthdate);
                    $newbday = $bdatetmp[2].'-'.str_pad($bdatetmp[0], 2, "0", STR_PAD_LEFT).'-'.str_pad($bdatetmp[1], 2, "0", STR_PAD_LEFT);
                    $age = $today->diff($newbday)->y;
                } else {
    
                    $dateofbirth = $details->birthdate;
                    $age = $today->diff($dateofbirth)->y;
                }
            }elseif($details->role === 'Employee'){
                $dateofbirth =$details->birthdate;
                $age = $today->diff($dateofbirth)->y;
            }
           
            return view('pages.dental-treatment-record', ['data' => $details,'issueDetails' => $issue,'newId' => $newId,'pageConfigs' => $pageConfigs,'breadcrumbs' => $breadcrumbs, 'age' => $age,]);
        }
    }
    public function editTreatmeant(Request $request){

        $response = Treatment::where('id',  $this->aes->decrypt($request->id))
            ->where('campus',session('campus'))
            ->first();
   
        return response()->json( $response);
    } 
    public function saveModal(Request $request){

        $treatment = $request->treatment;
        $diagnosis = $request->diagnosis;
        $patientId = $request->id;
        $date = $request->date;

        $existingTreatment = Treatment::where('patientId', $patientId)
            ->where('treatment', $treatment)
            ->where('diagnosis', $diagnosis)
            ->where('date', $date)
            ->where('campus', session('campus'))
            ->exists();

       if (!empty($existingTreatment)) {
        return response()->json(["Error" => 1, "Message" => "Already exist."]);
          
        }else{
            
            $save=Treatment::insert([ 
                'campus' => session('campus'),
                'patientId'=> $patientId,
                'role'=> $request->role,
                'age'=> $request->age,
                'gender'=> $request->gender,
                'stat' => $request->stat,
                'treatment' => $treatment,
                'diagnosis' =>$diagnosis,
                'remarks' => json_encode($request->remarks),
                'created_at' => Carbon::now('Asia/Manila'),
                'date' =>   $request->date,
             ]);
     
              $newId = DB::table('treatmentrecord')
                ->where('patientId', $request->id)
                ->latest('id')
                ->where('campus', session('campus'))
                ->first();
     
             return response()->json([
                'newId' => $newId->id,
                'status' => 200,
                'success'   => 'Saved Successfully!'
            ]);
        }
    }
    public function updateModal(Request $request){

        $update = Treatment::where('id',  $request->id)
            ->where('campus',session('campus'))
            ->update([ 
            'date' => $request->date,
            'diagnosis' => $request->diagnosis,
            'treatment' => $request->treatment,
            'remarks' => json_encode($request->remarks),
            'updated_at' => Carbon::now('Asia/Manila'),
         ]);
              
        return response()->json(['status' => 200,'success' => 'Updated Successfully!']);
    }
    public function search(Request $request){ 
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
            ->whereIn('r.SchoolLevel', ['Under Graduate', 'Masteral', 'Doctoral', 'Highschool','Cross Enrolment'])
            ->where('s.notuse', 0)
            ->where('r.finalize', 1)
            ->distinct()
            ->get();

        $encryptedResults = $result->map(function ($student) {
            $student->encryptedStudentNo = $this->aes->encrypt($student->StudentNo);
            return $student;
        });
        
        return response()->json($encryptedResults);
    }
    public function viewChart(Request $request) {

        $response = DB::table('student_info as s')
            ->join('dentalchart as d', 'd.patientId', '=', 's.id')
            ->select('d.*', 's.*')
            ->where('s.id', $request->id)
            ->where('d.campus',session('campus'))
            ->first();

          if ($response) {
              if ($response->id) {
                  return response()->json($response);
              } else {
                  $student_info = [
                    'id' => $response->id,
                    'last_name' => $response->last_name,
                    'middle_name' => $response->middle_name,
                    'first_name' => $response->last_name, 
                  ];
                  return response()->json($student_info);
              }
          } else {
              return response()->json(['message' => 'No matching record found']);
          }
          return response()->json($response);
    }
    public function viewModal(Request $request){
        $id = $request->input('toothId');
        $dataId = $request->input('patientId');
                 
        $response = [
            'toothId' => $id,
            'patientId' => $dataId,
        ];

        return response()->json( $response);
    }
    public function create(Request $request){

        $patientId =$request->patientId;

        $foundStudent = DB::table('student_info')->where('StudentNo',$patientId)->where('campus',session('campus'))->exists();

        if ($foundStudent) {

            $found2 = DB::table('dentalchart')->where('id',$patientId)->where('campus',session('campus'))->exists();
          
            $issues = $request->input('dental_issues');
            $filteredIssues = array_filter($issues, function ($value) {
                return $value !== null;
            });
  //Dental Chart
            if ($found2) {
                $update = DB::table('dentalchart')
                    ->where('id',$patientId)
                    ->where('campus',session('campus'))
                    ->update([ 
                        'dental_issues' => json_encode($filteredIssues),
                        'periodontal' => json_encode($request->periodontal),
                        'occlusion' => json_encode($request->occlusion),
                        'appliances' => json_encode($request->appliances),
                        'tmd' => json_encode($request->tmd),
                        'othersApp' => $request->othersApp,
                        'date' => $request->date,
                        'updated_at' => Carbon::now('Asia/Manila'),
                    ]);

                $updateStudent = DB::table('student_info')
                    ->where('StudentNo', $this->aes->decrypt($request->patientId))
                    ->where('campus',session('campus'))
                    ->update([
                        'StudentYear' => $request->StudentYear,
                        'LastName' => $request->lastname,
                        'FirstName' => $request->firstname,
                        'MiddleName' => $request->middlename,
                        'courses' => $request->course,
                        'accro' => $request->accro,
                        'major' => $request->major,
                        'updated_at' => Carbon::now('Asia/Manila'),
                    ]);

                Appointment::where('id', $request->appointmentId)->where('id', $request->patientId)
                    ->where('campus',session('campus'))
                    ->update([ 
                        'status' => $request->status,
                        'updated_at' => Carbon::now('Asia/Manila')
                    ]);
        
                $newId = DB::table('dentalchart')->where('id', $request->patientId)->latest('id')->where('campus', session('campus'))->first();

                return response()->json(['newId' => $this->aes->encrypt($newId->id),'status' => 200,'success'   => 'Updated Successfully!']);
            } elseif(empty($found2)) {
             
                    $patientId =$request->patientId;

                    DB::table('dentalchart')->insert([
                        'campus' => session('campus'),
                        'lastname' => $request->lastname,
                        'firstname' => $request->firstname,
                        'middlename' => $request->middlename,
                        'id' => $patientId,
                        'role' => $request->role,
                        'poscourse' => $request->poscourse,
                        'birthdate' => $request->bday,
                        'gender' => $request->gender,
                        'dental_issues' => json_encode($filteredIssues),
                        'periodontal' => json_encode($request->periodontal),
                        'occlusion' => json_encode($request->occlusion),
                        'appliances' => json_encode($request->appliances),
                        'tmd' => json_encode($request->tmd),
                        'othersApp' => $request->othersApp,
                        'date' => $request->date,
                        'created_at' => Carbon::now('Asia/Manila'),
                    ]);

                    Appointment::where('id', $request->appointmentId)
                        ->where('id', $request->patientId)
                        ->where('campus',session('campus'))
                        ->update([ 
                        'status' => $request->status,
                        'updated_at' => Carbon::now('Asia/Manila')
                        ]);
            
                    $newId = DB::table('dentalchart')->where('id', $request->patientId)->latest('id')->where('campus',  session('campus'))->first();
    
                    return response()->json(['newId' => $this->aes->encrypt($newId->id),'status' => 200,'success'   => 'Added Successfully!']); 
            }   else{
                return response()->json(['status' => 500, 'error' => 'Failed to Update Information!']);
            }     
        } elseif(empty($foundStudent)) {
            
            $issues = $request->input('dental_issues');
            $filteredIssues = array_filter($issues, function ($value) {
                return $value !== null;
            });

            $student = [
                'StudentNo' => $request->patientId,
                'campus' => session('campus'),
                'LastName' => $request->lastname,
                'FirstName' => $request->firstname,
                'MiddleName' => $request->middlename,
                'Sex' => $request->gender,
                'BirthDate' => $request->bday,
                'courses' => $request->course,
                'accro' => $request->accro,
                'major' => $request->major,
                'StudentYear' => $request->StudentYear,
                'ContactNo' => $request->ContactNo,
                'brgy' => $request->p_street,
                'city' => $request->p_municipality,
                'province' => $request->p_province,
                'civil_status' => $request->civil_status,
                'nationality' => $request->nationality,
                'religion' => $request->religion,
                'FatherName' => $request->father_name,
                'MotherName' => $request->mother_name,
                'f_occupation' => $request->father_occu,
                'm_occupation' => $request->mother_occu,
                'EC_name' => $request->emer_name,
                'EC_contactNo' => $request->emer_contact,
                'EC_brgy' => $request->emer_street,
                'EC_city' => $request->emer_city,
                'EC_province' => $request->emer_province,
                'created_at' =>Carbon::now('Asia/Manila'),
                'created_by' => session('employee_id')
            ];

            $savestudent = Student::insert($student);

            if ($savestudent){

            $dental=DB::table('dentalchart')
            ->insert([
                'campus' => session('campus'),
                'lastname' => $request->lastname,
                'firstname' => $request->firstname,
                'middlename' => $request->middlename,
                'id' => $request->patientId,
                'role' => $request->role,
                'poscourse' => $request->poscourse,
                'birthdate' => $request->bday,
                'gender' => $request->gender,
                'dental_issues' => json_encode($filteredIssues),
                'periodontal' => json_encode($request->periodontal),
                'occlusion' => json_encode($request->occlusion),
                'appliances' => json_encode($request->appliances),
                'tmd' => json_encode($request->tmd),
                'othersApp' => $request->othersApp,
                'date' => $request->date,
                'created_at' =>Carbon::now('Asia/Manila'),
            ]); 
    
            Appointment::where('id', $request->appointmentId)
                ->where('id', $request->patientId)
                ->where('campus',session('campus'))
                ->update([ 
                    'status' => $request->status,
                ]);
    
            $newId = DB::table('dentalchart')->where('id', $request->patientId)->latest('id')->where('campus', session('campus'))->first();

            return response()->json([
                'newId' => $this->aes->encrypt($newId->id),
                'status' => 200,
                'success'   => 'Added Successfully!'
            ]);
        } else{
            return response()->json(['status' => 500, 'error' => 'Failed to save student information!']);
        }
    }     
    else{
        return response()->json(['status' => 500, 'error' => 'Failed to save student information!']);   
    }
    }         
    public function treatment (Request $request){

        $treatment = $request->treatment;
        $diagnosis = $request->diagnosis;
        $patientId = $request->id;
        $date = $request->date;

        $existingTreatment = Treatment::where('patientId', $patientId)
            ->where('treatment', $treatment)
            ->where('diagnosis', $diagnosis)
            ->where('date', $date)
            ->where('campus',session('campus'))
            ->exists();

       if (!empty($existingTreatment)) {
        return response()->json(["Error" => 1, "Message" => "Already exist."]);
          
        }else{
            $save=Treatment::insert([ 
                'campus' => session('campus'),
                'patientId'=> $patientId,
                'role'=> $request->role,
                'age'=> $request->age,
                'gender'=> $request->gender,
                'stat' => $request->stat,
                'treatment' => $treatment,
                'diagnosis' =>$diagnosis,
                'remarks' => json_encode($request->remarks),
                'created_at' => Carbon::now('Asia/Manila'),
                'date' =>   $request->date,
             ]);
     
              $newId = Treatment::where('patientId', $request->id)
                ->latest('id')
                ->where('campus', session('campus'))
                ->first();
     
             return response()->json([
                'newId' => $newId->id,
                'status' => 200,
                'success'   => 'Saved Successfully!'
            ]);
        }
    }
    public function recordList(Request $request){
        $pageConfigs = ['pageHeader' => true];
        $breadcrumbs = [["link" => "/", "name" => "Home"],
              ["link" => "/medical-generated-certificate", "name" => "Dental Record Chart"], 
              ["link" => "/dental-treatment-record", "name" => "Treatment Record"],
              ["name" => "Record"]
        ];

        if ($request->has('id')) {
        
        $name = DB::table('treatmentrecord as t')
            ->join('dentalchart as d', 't.patientId', '=', 'd.id')
            ->select('d.*', 't.*')
            ->where('t.id', $request->id)
            ->where('t.campus', session('campus'))
            ->first();

        $status = Treatment::where("id",$request->id)
            ->where('campus', session('campus'))
            ->get();

            
        return view('pages.treatment-record-status',['pageConfigs'=>$pageConfigs,'breadcrumbs'=>$breadcrumbs], compact('name','status','request'));
     } else if($$request->has('to_id')){
        
        $name = DB::table('treatmentrecord as t')
            ->join('dentalchart as d', 't.patientId', '=', 'd.id')
            ->select('d.*', 't.*')
            ->where('t.id', $this->aes->decrypt($request->to_id))
            ->where('t.campus', session('campus'))
            ->first();
  
        $status = Treatment::where("id", $this->aes->decrypt($request->id))
            ->where('campus', session('campus'))
            ->get();
            
        return view('pages.treatment-record-status',['pageConfigs'=>$pageConfigs,'breadcrumbs'=>$breadcrumbs], compact('name','status'));
    }
   }
   public function viewModalPayment(Request $request){

        $paymentAll = DB::table('treatmentrecord as t')
            ->join('dentalchart as d', 't.patientId', '=', 'd.id')
            ->select('d.*', 't.*')
            ->where('t.id',$request->id)
            ->where('t.campus', session('campus'))
            ->first();

        return response()->json( $paymentAll);

   }
    public function payment(Request $request){

        $payment = DB::table('treatmentrecord')
            ->where('id',$request->id)
            ->update([ 
                'ORnumber' => $request->ORnumber,
                'ORcreated_at' => Carbon::now('Asia/Manila'),
            ]);

        return response()->json([
            'status' => 200,
            'success'   => 'Saved Successfully!'
        ]);
    }
    public function generatedPrintChart(Request $request)
    {
        $response = DB::table('dentalchart')->first();

        return Pdf::loadView('pages.dental-student-print',compact('response'))->setPaper('a4')->stream();
    }
}

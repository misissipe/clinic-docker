<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Collection;
use Illuminate\Pagination\Paginator;
use\App\Student;
use DataTables;
use DateTime;
use\App\Providers;
use\App\HealthHistory;
use Carbon\Carbon;
use App\Http\Controllers\AESCipher;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use App\Http\Controllers\MedClientAddController;
use Barryvdh\DomPDF\Facade\Pdf;

class StudentController extends Controller
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
      
        return view('pages.search-student',['pageConfigs'=>$pageConfigs,'breadcrumbs'=>$breadcrumbs]);
      }
      public function search(Request $request){ 
      
        $result = DB::table('student_info')
          ->where(function ($query) use ($request) {
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
    
      return response()->json($encryptedResults);
    }
    public function data(Request $request){
        $pageConfigs = ['pageHeader' => true];
        $breadcrumbs = [
          ["link" => "/", "name" => "Home"],["name" => "Information"]
        ];

        $data = Student::where('StudentNo', $this->aes->decrypt($request->id))->where('campus',session('campus'))->first();
      
        $today = Carbon::today();

        $bdatetmp = explode(' ', $data->BirthDate);
        $newbday = $bdatetmp[2].'-'.str_pad($bdatetmp[0], 2, "0", STR_PAD_LEFT).'-'.str_pad($bdatetmp[1], 2, "1", STR_PAD_LEFT);
        $age = $today->diff($newbday)->y;

        return view('pages.information-student',['pageConfigs'=>$pageConfigs,'breadcrumbs'=>$breadcrumbs],compact('data','age','newbday'));
      }
      public function modalPersonal(Request $request){
        try {
      
          $student = Student::where('StudentNo',$this->aes->decrypt($request->id))->where('campus', session('campus'))->first();

          return response()->json($student);
  
          } catch (\Throwable $th) {
            dd('error',$th);
          }
      }
      public function updatePersonal(Request $request){
        try {
      
          $birthDate = $request->BirthDate;
          $date = new DateTime($birthDate); 
          $formattedDate = $date->format('m d Y');

          $viewModal = Student::where('StudentNo',$request->id)
            ->update([
              'FirstName' =>$request->FirstName,
              'MiddleName' =>$request->MiddleName,
              'LastName' =>$request->LastName,
              'BirthDate' => $formattedDate,
              'ContactNo' =>$request->ContactNo,
              'civil_status' =>$request->civil_status,
              'nationality' =>$request->nationality,
              'religion' =>$request->religion,
              'brgy' =>$request->brgy,
              'city' =>$request->city,
              'province' =>$request->province,
              'courses' =>$request->courses,
              'major' =>$request->major,
              'accro' =>$request->accro,
              'StudentYear' =>$request->StudentYear,
              'campus' => session('campus'),
              'updated_at' => Carbon::now('Asia/Manila')
            ]);
      
          return response()->json($viewModal);
  
          } catch (\Throwable $th) {
            dd('error',$th);
          }
      }
      public function updateFamily(Request $request){
        try {

          $viewModal = Student::where('StudentNo',$request->id)
          ->update([
            'FatherName' =>$request->FatherName,
            'MotherName' =>$request->MotherName,
            'f_occupation' =>$request->f_occupation,
            'm_occupation' => $request->m_occupation,
            'f_officeadd' =>$request->f_officeadd,
            'm_officeadd' =>$request->m_officeadd,
            'campus'=> session('campus'),
            'updated_at' => Carbon::now('Asia/Manila')
          ]);
      
          return response()->json($viewModal);
  
          } catch (\Throwable $th) {
            dd('error',$th);
          }
      }
      public function updateEmergency(Request $request){
        try {
  
          $viewModal = Student::where('StudentNo',$request->id)
            ->update([
                'EC_name' =>$request->EC_name,
                'EC_contactNo' =>$request->EC_contactNo,
                'EC_brgy' =>$request->EC_brgy,
                'EC_city' => $request->EC_city,
                'EC_province' =>$request->EC_province,
                'campus'=> session('campus'),
                'updated_at' => Carbon::now('Asia/Manila')
              ]);
        
          return response()->json($viewModal);
  
          } catch (\Throwable $th) {
            dd('error',$th);
          }
      }
      public function indexEnrolled(){
        $pageConfigs = ['pageHeader' => true];
        $breadcrumbs = [
          ["link" => "/", "name" => "Home"],["name" => "Search"]
        ];
      
        return view('pages.search-enrolledstudent',['pageConfigs'=>$pageConfigs,'breadcrumbs'=>$breadcrumbs]);
      }
      public function searchEnrolled(Request $request){ 
      
        $schoolyr =  date('Y');
        $current_month = date('n');

        if ($current_month >= 6 && $current_month <= 12) {
            $semester = '1';
            $schoolyr_start = $schoolyr; 
        } elseif ($current_month >= 6 && $current_month <= 7) {
            $semester = '9';
            $schoolyr_start = $schoolyr - 1;
        } elseif ($current_month >= 1 && $current_month <= 5) {
            $semester = '2';
            $schoolyr_start = $schoolyr - 1 ;
        }

        $schoolyr = $schoolyr_start;
        $syr = $schoolyr + 1;
        $addYear = $schoolyr . '-' . $syr;

         $connection = MedClientAddController::getCampusConnection();

        $result = DB::connection($connection)
            ->table('students as s')
            ->select('s.*','r.SchoolLevel','r.finalize','r.SchoolYear','r.Semester','r.StudentYear','c.accro')
            ->leftJoin('registration as r', 's.StudentNo', '=', 'r.StudentNo') 
            ->leftJoin('course as c', 'c.id', '=', 'r.Course')
            ->where(function ($query) use ($request) {
              $query->where('s.StudentNo', 'LIKE', '%' . $request->search . '%')
                  ->orWhere('s.LastName', 'LIKE', '%' . $request->search . '%')
                  ->orWhere('s.FirstName', 'LIKE', '%' . $request->search . '%');
            })
            ->whereIn('r.SchoolLevel', ['Under Graduate', 'Masteral', 'Doctoral', 'Highschool','Cross Enrolment'])
            ->where('s.notuse', 0)
            ->where('r.finalize', 1)
            ->where('r.SchoolYear', $schoolyr_start)
            ->where('r.Semester', $semester)
            ->where(function ($query) {
                $query->where('s.bor', '=' , '')
                    ->orWhereNull('s.bor');
            })
            ->distinct()
            ->get();

        $encryptedResults = $result->map(function ($student) {
            $student->encryptedStudentNo = (new AESCipher)->encrypt($student->StudentNo);
            return $student;
        });
    
      return response()->json($encryptedResults);
    }
    public function indexGenerate(){
      $pageConfigs = ['pageHeader' => true];
      $breadcrumbs = [
        ["link" => "/", "name" => "Home"],["name" => "Generate"]
      ];
    
      $campus = session('campus');
      $courses = [];
      $year = [];
      
      $courseList = [
          1 => ['BEED', 'BSCrim', 'BSCE', 'BSComPE', 'BSFT', 'BSHRTM', 'BSHM', 'BSInfoTech', 'BSIT', 'BSME', 'BSEE', 'BSTM', 'BTLEd', 'BIT', 'MAT', 'MM', 'MTE', 'MSIT', 'PhD-TM','ROTC-CE-BIST','ROTC-CE-STAC'],
          2 => ['BSA', 'BSSW', 'BST'],
          3 => ['BEED', 'BPEd', 'BSBA', 'BSIT', 'BSED', 'EdD', 'LHS', 'MAEd', 'SHS'],
          4 => ['BSFi', 'BSInfoTech', 'BSMB', 'BSA','PN'],
          5 => ['BSA', 'BSEntrep', 'BSED', 'BSIndutech', 'BSIT', 'BSMA', 'BSOA', 'BTLEd'],
          6 => ['BAT', 'BSA', 'BSAE', 'BSAF', 'BSAB', 'BSE', 'BSES', 'BSIT', 'BTLEd'],
      ];
      
      $yearList = [
          1 => ['1', '2', '3', '4'],
          2 => ['1', '2', '3', '4'],
          3 => ['1', '2', '3', '4', '7', '8', '9', '10', '11', '12'],
          4 => ['1', '2', '3', '4'],
          5 => ['1', '2', '3', '4'],
          6 => ['1', '2', '3', '4'],
      ];
      
      if (array_key_exists($campus, $courseList)) {
          $courses = $courseList[$campus];
      }
      
      if (array_key_exists($campus, $yearList)) {
          $year = $yearList[$campus];
      }
      
      return view('pages.generate-validated', compact('pageConfigs', 'breadcrumbs', 'courses','year'));
      
    }
    public function validatedStudent(Request $request){

      if ($request->ajax()) {
        
        $course = $this->aes->decrypt($request->input('course'));
        $year = $this->aes->decrypt($request->input('year'));

        $schoolyr = date('Y');
        $current_month = date('n');
       if ($current_month >= 6 && $current_month <= 12) {
            $semester = 1; 
        } elseif ($current_month >= 1 && $current_month <= 5) {
            $semester = 2; 
        } elseif ($current_month >= 6 && $current_month <= 7) {
            $semester = 9; 
        }
        $schoolyr_start = ($semester === 1) ? $schoolyr : $schoolyr - 1;
     
        $connection = MedClientAddController::getCampusConnection();
     
        $search = DB::connection($connection)
          ->table('students as s')
          ->select('s.*','r.SchoolLevel','r.finalize','r.SchoolYear','r.Semester','r.StudentYear','c.accro')
          ->leftJoin('registration as r', 's.StudentNo', '=', 'r.StudentNo') 
          ->leftJoin('course as c', 'c.id', '=', 'r.Course')
          ->whereIn('r.SchoolLevel', ['Under Graduate', 'Masteral', 'Doctoral', 'Highschool','Cross Enrolment'])
          ->where('c.accro',  $course)
          ->where('r.StudentYear',  $year)
          ->where('s.notuse', 0)
          ->where('r.finalize', 1)
          ->where('r.SchoolYear', $schoolyr_start)
          ->where('r.Semester', $semester)
          ->where(function ($query) {
              $query->where('s.bor', '=' , '')
                  ->orWhereNull('s.bor');
          })
          ->distinct()
          ->get();

        return response()->json($search);
      }
    }
    public function generatedListPDF(Request $request){
      
      $course = $this->aes->decrypt($request->input('course'));
      $year = $this->aes->decrypt($request->input('year'));
    
        $schoolyr = date('Y');
        $current_month = date('n');
        $semester = ($current_month >= 8 && $current_month <= 12) ? 1 : 2;
        $schoolyr_start = ($semester === 1) ? $schoolyr : $schoolyr - 1;
    
       $connection = MedClientAddController::getCampusConnection();
    
        $today = Carbon::today();
    
        $result = DB::connection($connection)
          ->table('students as s')
          ->select('s.*','r.SchoolLevel','r.finalize','r.SchoolYear','r.Semester','r.StudentYear','c.accro')
          ->leftJoin('registration as r', 's.StudentNo', '=', 'r.StudentNo') 
          ->leftJoin('course as c', 'c.id', '=', 'r.Course')
          ->whereIn('r.SchoolLevel', ['Under Graduate', 'Masteral', 'Doctoral', 'Highschool','Cross Enrolment'])
          ->where('c.accro',  $course)
          ->where('r.StudentYear',  $year)
          ->where('s.notuse', 0)
          ->where('r.finalize', 1)
          ->where('r.SchoolYear', $schoolyr_start)
          ->where('r.Semester', $semester)
          ->where(function ($query) {
              $query->where('s.bor', '=' , '')
                  ->orWhereNull('s.bor');
          })
          ->distinct()
          ->orderBy('s.LastName')
          ->get();

    
        foreach ($result as $student) {
          if (!empty($student->BirthDate)) {
            $bdatetmp = explode(' ', $student->BirthDate);
            if (count($bdatetmp) === 3) {
              $newbday = $bdatetmp[2] . '-' . str_pad($bdatetmp[0], 2, "0", STR_PAD_LEFT) . '-' . str_pad($bdatetmp[1], 2, "0", STR_PAD_LEFT);
              $student->age = Carbon::parse($newbday)->diff($today)->y;
            } else {
              $student->age = null; 
            }
          } else {
              $student->age = null; 
          }
        }
    
        return Pdf::loadView('pages.generate-validated-form', compact('result'))->setPaper('a4')->stream();
    }
    
}

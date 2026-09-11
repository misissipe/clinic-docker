<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Collection;
use Illuminate\Pagination\Paginator;
use\App\Student;
use\App\HealthHistory;
use DataTables;
use\App\Providers;
use Carbon\Carbon;
use App\Http\Controllers\AESCipher;
use Haruncpi\LaravelIdGenerator\IdGenerator;


class MedClientAddController extends Controller
{
    public function index(Request $request){
        $pageConfigs = ['pageHeader' => true];
        $breadcrumbs = [
        ["link" => "/", "name" => "Home"],["name" => "Search"]
        ];

        // DB::connection('clinic')->table('medicalrecord')->first();
    
        return view('pages.student-information',['pageConfigs'=>$pageConfigs,'breadcrumbs'=>$breadcrumbs]);
    }
    public function search(Request $request){ 
        
        $schoolyr = date('Y');
        $current_month = date('n');
         if ($current_month >= 8 && $current_month <= 12) {
            $semester = 1; 
        } elseif ($current_month >= 1 && $current_month <= 5) {
            $semester = 2; 
        } elseif ($current_month >= 6 && $current_month <= 7) {
            $semester = 9; 
        }

        $schoolyr_start = ($semester === 1) ? $schoolyr : $schoolyr - 1;
    
        $campus_code = session('campus');
        $campuses = [1 => 'sg',2 => 'mcc',3 => 'to',4 => 'bn',5 => 'sj',6 => 'hn'];
        $connection = $campuses[$campus_code];

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
            ->whereIn('r.SchoolLevel', ['Under Graduate', 'Masteral', 'Doctoral', 'Highschool'])
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
    public function healthHistory(Request $request){
        $pageConfigs = ['pageHeader' => true];
        $breadcrumbs = [
            ["link" => "/", "name" => "Home"],
            ["link" => "/student-information", "name" => "Search"], 
            ["name" => "Medical and Social Health History"]
        ];
             
        $today = Carbon::today();
        $campus_code = session('campus');
        $campuses = [1 => 'sg',2 => 'mcc',3 => 'to',4 => 'bn',5 => 'sj',6 => 'hn'];
        $connection = $campuses[$campus_code];

        $healthHistory = DB::table('health_history')
            ->where('patientId', (new AESCipher)
            ->decrypt($request->id))->where('campus', session('campus'))
            ->first();
      
        $course = DB::connection($connection)->table('registration as r')
            ->select('c.id', 'c.course_title', 'c.accro', 's.*', 'r.StudentNo', 'r.Course', 'm.course_major', 'r.StudentYear', 'r.SchoolYear', 'r.Semester', 'r.SchoolLevel','r.finalize')
            ->join('students as s', 'r.StudentNo', '=', 's.StudentNo')
            ->join('course as c', 'c.id', '=', 'r.Course')
            ->join('major as m', 'm.id', '=', 's.Major')
            ->where('r.StudentNo', (new AESCipher)->decrypt($request->id))
            ->orderBy('r.SchoolYear', 'desc')
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
   
        if (empty($course->BirthDate)){
            return response()->json(["Error"=>1,"Message"=>"Error no Birth Date!"]);
        }else{
            $bdatetmp = explode(' ', $course->BirthDate);
            $newbday = $bdatetmp[2].'-'.str_pad($bdatetmp[0], 2, "0", STR_PAD_LEFT).'-'.str_pad($bdatetmp[1], 2, "1", STR_PAD_LEFT);
            $age = $today->diff($newbday)->y;

            if($course->Sex === 'F'){
                $gender = 'Female';
            } elseif($course->Sex === 'M'){
                $gender = 'Male';
            }
        } 

        // if (empty($healthHistory)) {
            return view('pages.medical-and-social-health-history', ['pageConfigs' => $pageConfigs,'breadcrumbs' => $breadcrumbs], compact('addYear','response','healthHistory','course','newbday','age','gender','r.finalize'));
        // } else {
        //     $response = DB::connection('mysql')->table('health_history')
        //         ->where('patientId', (new AESCipher)->decrypt($request->id))
        //         ->where('campus', session('campus'))
        //         ->first();
        
        //     return view('pages.medical-and-social-health-history', ['pageConfigs' => $pageConfigs,'breadcrumbs' => $breadcrumbs], compact('addYear','response','healthHistory','newbday','age','course','gender','r.finalize'));
        // }        
        //     return back();
    } 
    public function update(Request $request){
        $role = "Student";
        $check = DB::table('student_info')->where('StudentNo',(new AESCipher)->decrypt($request->patientId))->where('campus',session('campus'))->exists();

        if ($check) {
            $foundStudent = HealthHistory::where('patientId', (new AESCipher)->decrypt($request->patientId))
                ->where('campus', session('campus'))
                ->first();
        
            if ($foundStudent) {
                $update =  HealthHistory::where('patientId', (new AESCipher)->decrypt($request->patientId))
                    ->update([
                        'campus' => session('campus'),
                        'role' => $role, 
                        'family_his' => json_encode($request->family_his),
                        'othersFamhis' => $request->othersFamhis,
                        'personal_his' => json_encode($request->personal_his),
                        'sticksPerDay' => $request->sticksPerDay,
                        'forYears' => $request->forYears,
                        'shot' => $request->shot,
                        'beer' => $request->beer, 
                        'shotPer' => $request->shotPer,
                        'beerPer' => $request->beerPer, 
                        'past_illness' =>json_encode($request->past_illness),
                        'present_illness' => json_encode($request->present_illness),
                        'othersPreIll' => $request->othersPreIll,
                        'hospitalization' => $request->hospitalization,
                        'medicine_mnt' => $request->medicine_mnt,
                        'allergies' => $request->allergies,
                        'hos_detail' => $request->hos_detail,
                        'med_detail' => $request->med_detail,
                        'al_detail' => $request->al_detail,
                        'immunization_his' => json_encode($request->immunization_his),
                        'othersImmu' => $request->othersImmu,
                        'updated_at' => Carbon::now('Asia/Manila'),
                    ]);
        
                $updateStudent = DB::table('student_info')
                    ->where('StudentNo', (new AESCipher)->decrypt($request->patientId))
                    ->update([
                        'StudentYear' => $request->StudentYear,
                        'LastName' => $request->lastname,
                        'FirstName' => $request->firstname,
                        'MiddleName' => $request->middlename,
                        'courses' => $request->course,
                        'accro' => $request->accro,
                        'major' => $request->major,
                        'isActive' => $request->isActive,
                        'updated_at' => Carbon::now('Asia/Manila'),
                    ]);
        
                return response()->json(['status' => 200, 'success' => 'Updated Successfully!']);

            } elseif (empty($foundStudent)){
        
                   $healthhistory= [
                    'patientId' => (new AESCipher)->decrypt($request->patientId),
                    'campus' => session('campus'),
                    'role' => $role, 
                    'family_his' => json_encode($request->family_his),
                    'othersFamhis' => $request->othersFamhis,
                    'personal_his' => json_encode($request->personal_his),
                    'sticksPerDay' => $request->sticksPerDay,
                    'forYears' => $request->forYears,
                    'shot' => $request->shot,
                    'beer' => $request->beer, 
                    'shotPer' => $request->shotPer,
                    'beerPer' => $request->beerPer, 
                    'past_illness' =>json_encode($request->past_illness),
                    'present_illness' => json_encode($request->present_illness),
                    'othersPreIll' => $request->othersPreIll,
                    'hospitalization' => $request->hospitalization,
                    'medicine_mnt' => $request->medicine_mnt,
                    'allergies' => $request->allergies,
                    'hos_detail' => $request->hos_detail,
                    'med_detail' => $request->med_detail,
                    'al_detail' => $request->al_detail,
                    'immunization_his' =>json_encode($request->immunization_his),
                    'othersImmu' => $request->othersImmu,
                    'created_at' => Carbon::now('Asia/Manila'),
                ]; 

                $saveshistory = HealthHistory::insert($healthhistory);
        
                return response()->json(['status' => 200, 'success' => 'Saved Successfully!']);
            }else{
                return response()->json(['status' => 500, 'error' => 'Failed to Update Information!']);
            }
        } elseif(empty($check)) {
         
            $student = [
                'StudentNo' => (new AESCipher)->decrypt($request->patientId),
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
                'isActive' => $request->isActive,
                'created_at' => Carbon::now('Asia/Manila'),
                'created_by' => session('employee_id')
            ];
        
            $savestudent = Student::insert($student);

            if ($savestudent){
                $healthhistory = [
                    'patientId' => (new AESCipher)->decrypt($request->patientId),
                    'campus' => session('campus'),
                    'role' => $role, 
                    'family_his' => json_encode($request->family_his),
                    'othersFamhis' => $request->othersFamhis,
                    'personal_his' => json_encode($request->personal_his),
                    'sticksPerDay' => $request->sticksPerDay,
                    'forYears' => $request->forYears,
                    'shot' => $request->shot,
                    'beer' => $request->beer, 
                    'shotPer' => $request->shotPer,
                    'beerPer' => $request->beerPer, 
                    'past_illness' => json_encode($request->past_illness),
                    'present_illness' => json_encode($request->present_illness),
                    'othersPreIll' => $request->othersPreIll,
                    'hospitalization' => $request->hospitalization,
                    'medicine_mnt' => $request->medicine_mnt,
                    'allergies' => $request->allergies,
                    'hos_detail' => $request->hos_detail,
                    'med_detail' => $request->med_detail,
                    'al_detail' => $request->al_detail,
                    'immunization_his' => json_encode($request->immunization_his),
                    'othersImmu' => $request->othersImmu,
                    'created_at' => Carbon::now('Asia/Manila'),
                ];
            
                $saveshistory = HealthHistory::insert($healthhistory);      

                if ($savestudent && $saveshistory) {
                    return response()->json(['status' => 200, 'success' => 'Saved Successfully!']);
                } elseif (!$saveshistory) {
                    return response()->json(['status' => 500, 'error' => 'Failed to save health history information!']);
                }
            } else{
                return response()->json(['status' => 500, 'error' => 'Failed to save student information!']);
            }
        }     
        else{
            return response()->json(['status' => 500, 'error' => 'Failed to save student information!']);   
        }
    }
  }

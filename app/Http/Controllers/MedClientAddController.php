<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Collection;
use Illuminate\Pagination\Paginator;
use App\Student;
use App\HealthHistory;
use DataTables;
use App\Providers;
use Carbon\Carbon;
use Illuminate\Encryption\Encrypter;
use App\Http\Controllers\AESCipher;
use Haruncpi\LaravelIdGenerator\IdGenerator;


class MedClientAddController extends Controller
{
    protected $aes;
    public function __construct() {
        $this->aes = new AESCipher;
    }  
    public static function getCampusConnection()
    {
        $campus_code = session('campus');
        $campuses = [
            1 => 'sg',
            2 => 'mcc',
            3 => 'to',
            4 => 'bn',
            5 => 'sj',
            6 => 'hn'
        ];

        return $campuses[$campus_code];
    }     
   public static function getStudentCourse($connection, $studentNo, $schoolyr_start, $semester)
    {
        return DB::connection($connection)
            ->table('registration as r')
            ->select(
                'c.id','c.course_title','c.accro','s.*','r.StudentNo',
                'r.Course','m.course_major','r.StudentYear','r.SchoolYear','r.Semester',
                'r.SchoolLevel','r.finalize','r.StudentStatus'
            )
            ->join('students as s', 'r.StudentNo', '=', 's.StudentNo')
            ->join('course as c', 'c.id', '=', 'r.Course')
            ->join('major as m', 'm.id', '=', 's.Major')
            ->where('r.StudentNo', $studentNo)
            ->where('r.SchoolYear', $schoolyr_start)
            ->where('r.Semester', $semester)
            ->orderBy('r.SchoolYear', 'desc')
            ->first();
    }

    public function index(Request $request){
        $pageConfigs = ['pageHeader' => true];
        $breadcrumbs = [
        ["link" => "/", "name" => "Home"],["name" => "Search"]
        ];
    
        return view('pages.student-information',['pageConfigs'=>$pageConfigs,'breadcrumbs'=>$breadcrumbs]);
    }
    public function search(Request $request){ 
        
        $semester = $request->semester;
        $schoolyr = $request->yr;
        $connection = $this->getCampusConnection();

        $uniqueStudents = DB::connection($connection)
            ->table('students as s')
            ->select('s.*','r.SchoolLevel','r.finalize','r.SchoolYear','r.Semester','r.StudentYear','c.accro','r.StudentStatus')
            ->leftJoin('registration as r', 's.StudentNo', '=', 'r.StudentNo') 
            ->leftJoin('course as c', 'c.id', '=', 'r.Course')
            ->where(function ($query) use ($request) {
                $query->where('s.StudentNo', 'LIKE', '%' . $request->search . '%')
                    ->orWhere('s.LastName', 'LIKE', '%' . $request->search . '%')
                    ->orWhere('s.FirstName', 'LIKE', '%' . $request->search . '%');
            })
            ->whereIn('r.SchoolLevel', ['Under Graduate', 'Masteral', 'Doctoral', 'Highschool', 'Senior High','Cross Enrolment'])
            ->where('s.notuse', 0)
            ->where('r.finalize', 1)
            ->where('r.SchoolYear', $schoolyr)
            ->where('r.Semester', $semester)
            ->where(function ($query) {
                $query->where('s.bor', '=' , '')
                    ->orWhereNull('s.bor');
            })
            ->distinct()
            ->get();

        $result = $uniqueStudents->unique('StudentNo')->values();


        $encryptedResults = $result->map(function ($student) {
            $student->encryptedStudentNo = $this->aes->encrypt($student->StudentNo);
            return $student;
        });
        
        return response()->json($encryptedResults);
    }
    public function profilephoto($data = []){

        $ces_url = env('CES');
        $key = base64_decode(env('SHARED_CRYPT_KEY'));
        $encrypter = new Encrypter($key, 'AES-256-CBC');
        
        $connection = $this->getCampusConnection();
        $encrypted = $encrypter->encrypt($data['StudentNo']);
        $campus= $encrypter->encrypt($connection);
        $image = $ces_url . "/profile-photo?snum=".urlencode($encrypted)."&campus=".urlencode($campus);

        return $image;
    }
    public function healthHistory(Request $request){
        $pageConfigs = ['pageHeader' => true];
        $breadcrumbs = [
        ["link" => "/", "name" => "Home"],
        ["link" => "/student-information", "name" => "Search"], 
        ["name" => "Medical and Social Health History"]
        ];
                
        $today = Carbon::today();
        $schoolyr_start =  $request->yr;
        $semester = $request->sem; 

        if ($semester == '1'){
            $sem = 'First Semester';
        } elseif ($semester == '2'){
            $sem = 'Second Semester';
        } else{
            $sem = 'Summer';
        }
        
        $connection = $this->getCampusConnection();
        $studentNo  = $this->aes->decrypt($request->id);

        $course = static::getStudentCourse($connection, $studentNo,$schoolyr_start, $semester);

        // dd($course);

        $healthHistory = HealthHistory::where('patientId', $this->aes->decrypt($request->id))
            ->where('campus', session('campus'))
            ->first();

        $medicalrecord = DB::table('medicalcert')
            ->where('patientId', $this->aes->decrypt($request->id))
            ->where('campus', session('campus'))
            ->orderBy('id','asc')
            ->whereNotNull('bloodtype')
            ->whereNull('deleted_at')
            ->first();  


        $bloodtype = $medicalrecord->bloodtype ?? '';

        $syr = $schoolyr_start + 1;
        $addYear = $schoolyr_start . '-' . $syr;

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

        return view('pages.medical-and-social-health-history', ['pageConfigs' => $pageConfigs,'breadcrumbs' => $breadcrumbs], compact('addYear','response','healthHistory','course','newbday','age','gender','r.finalize','sem','addYear','semester','bloodtype'));
    } 
    public function update(Request $request){
        $role = "Student";
        $check = Student::where('StudentNo',$this->aes->decrypt($request->patientId))
            ->where('LastName',$request->lastname)
            ->where('FirstName', $request->firstname)
            ->where('MiddleName',$request->middlename)
            ->where('campus',session('campus'))
            ->exists(); 

        if (!empty($check)) {
            $foundStudent = HealthHistory::where('patientId', $this->aes->decrypt($request->patientId))
                ->where('campus', session('campus'))
                ->first();
        
            if (!empty($foundStudent)) {
                $update =  HealthHistory::where('patientId', $this->aes->decrypt($request->patientId))
                    ->where('campus', session('campus'))
                    ->update([
                        'campus' => session('campus'),
                        'role' => $role, 
                        'bloodtype' => $request->bloodtype,
                        'sticksPerDay' => $request->sticksPerDay,
                        'forYears' => $request->forYears,
                        'shot' => $request->shot,
                        'beer' => $request->beer, 
                        'shotPer' => $request->shotPer,
                        'beerPer' => $request->beerPer, 
                        'family_his' => json_encode($request->family_his),
                        'personal_his' => json_encode($request->personal_his),
                        'past_illness' =>json_encode($request->past_illness),
                        'present_illness' => json_encode($request->present_illness),
                        'othersFamhis' => $request->othersFamhis,
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
        
                $updateStudent = Student::where('StudentNo', (new AESCipher)->decrypt($request->patientId))
                    ->where('campus', session('campus'))
                    ->update([
                        'StudentNo' => $this->aes->decrypt($request->patientId),
                        'campus' => session('campus'),
                        'LastName' => $request->lastname,
                        'FirstName' => $request->firstname,
                        'MiddleName' => $request->middlename,
                        'Sex' => $request->gender,
                        'BirthDate' => $request->bday,
                        'courses' => $request->course,
                        'semester' => $request->sem,
                        'school_yr' => $request->sy,
                        'accro' => $request->accro,
                        'major' => $request->major,
                        'emailAdd' => $request->email,
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
                        'StudentStatus' => $request->StudentStatus,
                        'updated_at' => Carbon::now('Asia/Manila'),
                    ]);
        
                return response()->json(['status' => 200, 'success' => 'Updated Successfully!']);

            } elseif (empty($foundStudent)){
        
                $healthhistory= [
                    'patientId' => $this->aes->decrypt($request->patientId),
                    'campus' => session('campus'),
                    'role' => $role, 
                    'bloodtype' => $request->bloodtype,
                    'othersFamhis' => $request->othersFamhis,
                    'sticksPerDay' => $request->sticksPerDay,
                    'forYears' => $request->forYears,
                    'shot' => $request->shot,
                    'beer' => $request->beer, 
                    'shotPer' => $request->shotPer,
                    'beerPer' => $request->beerPer, 
                    'family_his' => json_encode($request->family_his),
                    'personal_his' => json_encode($request->personal_his),
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
                'StudentNo' => $this->aes->decrypt($request->patientId),
                'campus' => session('campus'),
                'LastName' => $request->lastname,
                'FirstName' => $request->firstname,
                'MiddleName' => $request->middlename,
                'Sex' => $request->gender,
                'BirthDate' => $request->bday,
                'courses' => $request->course,
                'semester' => $request->sem,
                'school_yr' => $request->sy,
                'accro' => $request->accro,
                'major' => $request->major,
                'emailAdd' => $request->email,
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
                'StudentStatus' => $request->StudentStatus,
                'created_at' => Carbon::now('Asia/Manila'),
                'created_by' => session('employee_id')
            ];
        
            $savestudent = Student::insert($student);

            if ($savestudent){
                $healthhistory = [
                    'patientId' => $this->aes->decrypt($request->patientId),
                    'campus' => session('campus'),
                    'role' => $role, 
                    'bloodtype' => $request->bloodtype,
                    'othersFamhis' => $request->othersFamhis,
                    'sticksPerDay' => $request->sticksPerDay,
                    'forYears' => $request->forYears,
                    'shot' => $request->shot,
                    'beer' => $request->beer, 
                    'shotPer' => $request->shotPer,
                    'beerPer' => $request->beerPer, 
                    'family_his' => json_encode($request->family_his),
                    'personal_his' => json_encode($request->personal_his),
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
                    return response()->json(['status' => 500, 'error' => 'Failed to save Health History Information!']);
                }
            } else{
                return response()->json(['status' => 500, 'error' => 'Failed to save Student Information!']);
            }
        }     
        else{
            return response()->json(['status' => 500, 'error' => 'Failed to save Student Information!']);   
        }
    }
  }

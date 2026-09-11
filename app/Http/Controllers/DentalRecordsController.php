<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Collection;
use Illuminate\Pagination\Paginator;
use App\Student;
use DataTables;
use App\Providers;
use Carbon\Carbon;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use App\Http\Controllers\AESCipher;
use App\Http\Controllers\MedClientAddController;
use Barryvdh\DomPDF\Facade\Pdf;

class DentalRecordsController extends Controller
{
    protected $aes;
    public function __construct(){
        $this->aes = new AESCipher;
    }
    public function index(){
        $pageConfigs = ['pageHeader' => true];
        $breadcrumbs = [
          ["link" => "/", "name" => "Home"],["name" => "Dental Records"]
        ];
        $today = Carbon::today();

        $year = $today->year;
        $monthNumber = date('n');
        $monthNames = [
            1 => 'January',
            2 => 'February',
            3 => 'March',
            4 => 'April',
            5 => 'May',
            6 => 'June',
            7 => 'July',
            8 => 'August',
            9 => 'September',
            10 => 'October',
            11 => 'November',
            12 => 'December'
        ];

        $month = $monthNames[$monthNumber];
       
        $today = Carbon::today();
        $records = DB::table('treatmentrecord as t')
            ->join('dentalchart as d', 't.patientId', '=', 'd.id')
            ->select('d.lastname','d.firstname', 'd.middlename','d.gender','d.birthdate','d.poscourse','t.*')
            ->whereMonth('t.date', $monthNumber)
            ->whereYear('t.date', $year)
            ->whereNull('t.deleted_at')
            ->orderBy('t.date', 'desc')
            ->where('t.campus',session('campus'))
            ->get();

        $dentalcheckup = DB::table('treatmentrecord')->whereJsonContains('remarks', 'Consultation')->whereMonth('date', $monthNumber)->whereYear('date', $year)->where('campus',session('campus'))->count();
        $cavityfilling = DB::table('treatmentrecord')->whereJsonContains('remarks', 'Oral Restoration')->whereMonth('date', $monthNumber)->whereYear('date', $year)->where('campus',session('campus'))->count();
        $oralprophylaxis = DB::table('treatmentrecord')->whereJsonContains('remarks', 'Oral Prophylaxis')->whereMonth('date', $monthNumber)->whereYear('date', $year)->where('campus',session('campus'))->count();
        $toothextraction = DB::table('treatmentrecord')->whereJsonContains('remarks', 'Tooth Extraction')->whereMonth('date', $monthNumber)->whereYear('date', $year)->where('campus',session('campus'))->count();
        $otcmedicine = DB::table('treatmentrecord')->whereJsonContains('remarks', 'OTC Medicine')->whereMonth('date', $monthNumber)->whereYear('date', $year)->where('campus',session('campus'))->count();
        $totalstudent = DB::table('treatmentrecord')->where('role', 'Student')->whereMonth('date', $monthNumber)->whereYear('date', $year)->where('campus',session('campus'))->count();
        $totalemployee = DB::table('treatmentrecord')->where('role', 'Employee')->whereMonth('date', $monthNumber)->whereYear('date', $year)->where('campus',session('campus'))->count();

        return view('pages.records-of-visit',['pageConfigs'=>$pageConfigs,'breadcrumbs'=>$breadcrumbs],compact('records','month','oralprophylaxis','dentalcheckup','cavityfilling','toothextraction','otcmedicine','totalstudent','totalemployee'));
    }

    public function allRecords(Request $request) {
        $pageConfigs = ['pageHeader' => true];
        $breadcrumbs = [
            ["link" => "/", "name" => "Home"],
            ["name" => "Dental Records"]
        ];

        if ($request->ajax()) {
            $monthSearch = $request->input('monthSearch');
            $year = $request->input('year');
            
            $search = DB::table('treatmentrecord as t')
                ->select('t.*','d.id','d.lastname','d.firstname','d.middlename','d.birthdate','d.poscourse')
                ->join('dentalchart as d','d.id','=','t.patientId')
                ->whereMonth('t.date', $monthSearch)
                ->whereYear('t.date', $year)
                ->whereNull('t.deleted_at')
                ->where('t.campus',session('campus'))
                ->get();

            return response()->json($search);
        }
    }
    public function resultRecords(Request $request)
    {
        $result = DB::table('dentalchart')
            ->where('id', $request->id)
            ->where('campus',session('campus'))
            ->get();
        
        return response()->json($result);    
    }
    public function total(Request $request)
    {
        $pageConfigs = ['pageHeader' => true];
        $breadcrumbs = [
          ["link" => "/", "name" => "Home"],["name" => "Total Patient"]
        ];

        return view('pages.dental-total-patient',['pageConfigs'=>$pageConfigs,'breadcrumbs'=>$breadcrumbs]);
    }
    public function displaytotal(Request $request) 
        {
        $year = $request->input('year');
        $months = [
            'January', 'February', 'March', 'April', 'May', 'June', 
            'July', 'August', 'September', 'October', 'November', 'December',
        ];
    
        $studentCount = [];
        $employeeCount = [];
        $dependentCount = [];
        $totalCount = [];
    
        foreach (range(1, 12) as $monthIndex) {

            $studentCount[] = DB::connection('mysql')->table('treatmentrecord')
                ->where('role', 'Student')
                ->whereYear('date', '=', $year)
                ->whereMonth('date', '=', $monthIndex)
                ->where('campus', session('campus'))
                ->select(DB::raw('SUM(JSON_LENGTH(remarks)) as total'))
                ->value('total') ?? 0;
    
            $employeeCount[] = DB::connection('mysql')->table('treatmentrecord')
                ->where('role', 'Employee')
                ->whereYear('date', $year)
                ->whereMonth('date', $monthIndex)
                ->where('campus', session('campus'))
                 ->select(DB::raw('SUM(JSON_LENGTH(remarks)) as total'))
                 ->value('total') ?? 0;
    
            $dependentCount[] = DB::connection('mysql')->table('treatmentrecord')
                ->where('role', 'Dependent')
                ->whereYear('date', $year)
                ->whereMonth('date', $monthIndex)
                ->where('campus', session('campus'))
                 ->select(DB::raw('SUM(JSON_LENGTH(remarks)) as total'))
                ->value('total') ?? 0;
    
            $totalCount[] = DB::connection('mysql')->table('treatmentrecord')
                ->whereYear('date', $year)
                ->whereMonth('date', $monthIndex)
                ->where('campus', session('campus'))
                ->select(DB::raw('SUM(JSON_LENGTH(remarks)) as total'))
                ->value('total') ?? 0;
        }
    
        return response()->json([
            'studentCount' => $studentCount,
            'employeeCount' => $employeeCount,
            'dependentCount' => $dependentCount,
            'totalCount' => $totalCount,
            'month' => $months,
        ]);
    }

    public function RVgeneratedPDF(Request $request)
    {
        $monthSearch = $request->input('monthSearch');
        $year = $request->input('year');
        $monthName = Carbon::create()->month($monthSearch)->format('F');
                 
        $strDate = $year."-".$monthSearch;
              
        $view = DB::connection('mysql')
            ->table('treatmentrecord as t')
            ->select('t.*','d.id','d.lastname','d.firstname','d.middlename','d.birthdate','d.poscourse')
            ->join('dentalchart as d','d.id','=','t.patientId')
            ->where('t.date', "LIKE",  $strDate."%")
            ->whereNull('t.deleted_at')
            ->where('t.campus',session('campus'))
            ->orderBy('t.date','asc')
            ->get();

        return Pdf::loadView('pages.dental-RV-form',compact('view','monthName'))->setPaper('a4', 'landscape')->stream();
    }

#Patient Treatment Record
    public function treatmentRec()
    {
        $pageConfigs = ['pageHeader' => true];
        $breadcrumbs = [
        ["link" => "/", "name" => "Home"],
        ["name" => "Treatment Records"]
        ];

        return view('pages.treatment-records',['pageConfigs'=>$pageConfigs,'breadcrumbs'=>$breadcrumbs]);
    }
    public function search(Request $request)
    {
        try{

            $search = $request->input('search');
            $role = $request->get('role');
            
            $result = DB::table('dentalchart')
                ->where('role',$role)
                ->where(function ($query) use ($request) {
                    $query->where('id', 'like', '%' . $request->search . '%')
                        ->orWhere('lastname', 'LIKE', '%' . $request->search . '%')
                        ->orWhere('firstname', 'LIKE', '%' . $request->search . '%')
                        ->orWhere('middlename', 'LIKE', '%' . $request->search . '%');
                })
                ->where('campus',session('campus'))
                ->get();
        
            $encryptedResults = $result->map(function ($patient) {
                $patient->encryptedPatientNo = $this->aes->encrypt($patient->id);
                return $patient;
            });
         
            $response = [
                'role' => $role,
                'data' => $encryptedResults,
            ];
        
            return response()->json($response);
           } catch (\Throwable $th) {
             dd('error',$th);
           }
    } 
    public function treatmentList(Request $request)
    {
        $pageConfigs = ['pageHeader' => true];
        $breadcrumbs = [
            ["link" => "/", "name" => "Home"],
            ["link" => "/patient-view-record", "name" => "Search"], 
            ["name" => "Patient Treatment Record"]
        ];
        $role = $request->get('role');   

        $existingTreatment = DB::table('treatmentrecord')
            ->where('patientId', $this->aes->decrypt($request->id))
            ->where('campus',session('campus'))
            ->where('role',$role)
            ->whereNull('deleted_at')
            ->first();
        
        if (empty($existingTreatment)) {

            $check =  DB::table('dentalchart')->where('id',$this->aes->decrypt($request->id))->where('campus',session('campus'))->where('role',$role)->first();

            $error_message = 'No record found ';
            $namePatient =  $check->firstname . ' ' . substr($check->middlename, 0, 1) . '. ' . ' ' . $check->lastname;
        
            session()->flash('error', $error_message);
            session()->flash('patient',$namePatient);
            return redirect()->route('returntosearch')->with(['error', $error_message],['patient',$namePatient]);
        } else{
        $name = DB::table('dentalchart')->where('id', $this->aes->decrypt($request->id))->where('campus',session('campus'))->where('role',$role)->first();

        $today = Carbon::today();
        $dateOfBirth = $name->birthdate;
        
        if (strpos($dateOfBirth, '-') !== false) {
            $formattedDate = $dateOfBirth;
        } else {
            $dateParts = explode(' ', $dateOfBirth);
            $formattedDate = $dateParts[2] . '-' . str_pad($dateParts[0], 2, "0", STR_PAD_LEFT) . '-' . str_pad($dateParts[1], 2, "0", STR_PAD_LEFT);
        }
        
        $age = $today->diff($formattedDate)->y;
        
        $data = DB::table('treatmentrecord')
                ->where('patientId', $this->aes->decrypt($request->id))
                ->where('campus',session('campus'))
                 ->where('role',$role)
                ->first();
        

               
        $view = DB::table('treatmentrecord as t')
            ->select('t.*')
            ->addSelect([
                'lastname' => DB::table('dentalchart as s')
                    ->select('s.lastname')
                    ->whereColumn('s.id', 't.patientId')
                    ->where('s.campus', session('campus'))
                    ->limit(1),

                'firstname' => DB::table('dentalchart as s')
                    ->select('s.firstname')
                    ->whereColumn('s.id', 't.patientId')
                    ->where('s.campus', session('campus'))
                    ->limit(1),

                'middlename' => DB::table('dentalchart as s')
                    ->select('s.middlename')
                    ->whereColumn('s.id', 't.patientId')
                    ->where('s.campus', session('campus'))
                    ->limit(1),

                'gender' => DB::table('dentalchart as s')
                    ->select('s.gender')
                    ->whereColumn('s.id', 't.patientId')
                    ->where('s.campus', session('campus'))
                    ->limit(1),
            ])
            ->where('t.role', $role)
            ->where('t.patientId', $this->aes->decrypt($request->id))
            ->where('t.campus', session('campus'))
            ->whereNull('t.deleted_at')
            ->orderBy('t.date', 'desc')
            ->get();

               


        return view('pages.treatment-record-list', ['pageConfigs' => $pageConfigs, 'breadcrumbs' => $breadcrumbs], compact('age','view', 'name', 'request','data'));
        }
    }
    public function resultDental(Request $request)
    {
        $result = DB::table('treatmentrecord as t')
            ->join('dentalchart as d', 't.patientId', '=', 'd.id')
            ->select('d.*', 't.*')
            ->where('t.patientId', $request->patientId)
            ->where('t.campus',session('campus'))
            ->get();

        return response()->json($result);
    }
    public function modaltreatmentRecord(Request $request){
    
        $details = DB::table('treatmentrecord')
            ->where('id', $request->id)
            ->where('campus',session('campus'))
            ->first();
    
        return response()->json($details);
    }
    public function deleteRecord(Request $request){

        DB::table('treatmentrecord')
            ->where('id', $request->id)
            ->update([
                'deleted_at' =>  Carbon::now('Asia/Manila'),
            ]);

        return response()->json(['message' => 'Deleted successfully']);
    }
    public function generateTreatmentPDF(Request $request){

        $today = Carbon::today();
        $currentMonth = date('n');
        $schoolYearStartMonth = 8;

        $monthSearch = $request->input('monthSearch');
        $year = $request->input('year');
        $monthName = Carbon::create()->month($monthSearch)->format('F');
                 
        $strDate = $year."-".$monthSearch;

        $name = DB::table('dentalchart')
         ->where('id',$this->aes->decrypt($request->id))
         ->where('campus',session('campus'))
         ->first();
              
        $view = DB::table('treatmentrecord')
            ->where('patientId',$this->aes->decrypt($request->id))
            ->whereNull('deleted_at')
            ->where('campus',session('campus'))
            ->orderBy('date','asc')
            ->get();

        if($name->role === 'Student'){
            $bdatetmp = explode(' ', $name->birthdate);
            $newbday = $bdatetmp[2].'-'.str_pad($bdatetmp[0], 2, "0", STR_PAD_LEFT).'-'.str_pad($bdatetmp[1], 2, "1", STR_PAD_LEFT);
            $age = $today->diff($newbday)->y;
        } else if($name->role === 'Employee'){
            $dateofbirth =$name->birthdate;
            $age = $today->diff($dateofbirth)->y;
        }
            
        return Pdf::loadView('pages.treatment-record-form',compact('view','info','addYear','request','check','age','name'))->stream();
    }
// For denatal Assessment Questionnaire
 public function indexAssessmentStudent()
    {
        $pageConfigs = ['pageHeader' => true];
        $breadcrumbs = [
            ["link" => "/", "name" => "Home"],
            ["name" => "Search"]
          ];


        return view('pages.assessment-student',['pageConfigs'=>$pageConfigs,'breadcrumbs'=>$breadcrumbs],compact('appointments'));
    }
    public function searchStudent(Request $request){ 
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
     public function indexAssessmentEmployee()
    {
        $pageConfigs = ['pageHeader' => true];
        $breadcrumbs = [
            ["link" => "/", "name" => "Home"],
            ["name" => "Search"]
          ];


        return view('pages.assessment-student',['pageConfigs'=>$pageConfigs,'breadcrumbs'=>$breadcrumbs],compact('appointments'));
    }
     public function indexAssessmentDependent()
    {
        $pageConfigs = ['pageHeader' => true];
        $breadcrumbs = [
            ["link" => "/", "name" => "Home"],
            ["name" => "Search"]
          ];


        return view('pages.assessment-student',['pageConfigs'=>$pageConfigs,'breadcrumbs'=>$breadcrumbs],compact('appointments'));
    }
     public function indexQuestionnaire(Request $request)
    {
        $pageConfigs = ['pageHeader' => true];
        $breadcrumbs = [
            ["link" => "/", "name" => "Home"],
            ["name" => "Search"]
          ];

        $role = $request->role;

        if ($role === 'Student')
        {
          $connection = MedClientAddController::getCampusConnection();

          $data = DB::connection($connection)->table('registration as r')
            ->select('c.id', 'c.course_title', 'c.accro', 's.*', 'r.StudentNo', 'r.Course', 'm.course_major', 'r.StudentYear', 'r.SchoolYear')
            ->join('students as s', 'r.StudentNo', '=', 's.StudentNo')
            ->join('course as c', 'c.id', '=', 'r.Course')
            ->join('major as m', 'm.id', '=', 's.Major')
            ->where('r.StudentNo', $this->aes->decrypt($request->StudentId))
            ->orderBy('r.SchoolYear', 'desc')
            ->first();


            $today = Carbon::today();

            $bdatetmp = explode(' ', $data->BirthDate);
            $newbday = $bdatetmp[2].'-'.str_pad($bdatetmp[0], 2, "0", STR_PAD_LEFT).'-'.str_pad($bdatetmp[1], 2, "1", STR_PAD_LEFT);
            $age = $today->diff($newbday)->y;
        
            if($data->Sex === 'F'){
                $gender = 'Female';
            }else if($data->Sex === 'M'){
                $gender = 'Male';
            }
        }
          
        return view('pages.assessment-questionnaire',compact('data','age','gender','role'),['pageConfigs'=>$pageConfigs,'breadcrumbs'=>$breadcrumbs],compact('appointments'));
    }
}

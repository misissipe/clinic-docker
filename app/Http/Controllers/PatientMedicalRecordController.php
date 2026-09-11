<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Collection;
use Illuminate\Pagination\Paginator;
use Illuminate\Validation\ValidationException;
use App\Product;
use App\Inventory;
use App\Medical;
use App\Student;
use App\Employee;
use App\Stocks;
use DataTables;
use App\Providers;
use Carbon\Carbon;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Barryvdh\DomPDF\Facade\Pdf;

class PatientMedicalRecordController extends Controller
{
    protected $aes;

    public function __construct(){
        $this->aes = new AESCipher;
    }
    public function index(){
      $pageConfigs = ['pageHeader' => true];
      $breadcrumbs = [
        ["link" => "/", "name" => "Home"],["name" => "Add New"]

      ];
      return view('pages.patient-monitoring-search',['pageConfigs'=>$pageConfigs,'breadcrumbs'=>$breadcrumbs]);
    }

    public function illnessSummary(Request $request)
    {
      $pageConfigs = ['pageHeader' => true];
      $breadcrumbs = [
        ['link' => '/', 'name' => 'Home'],
        ['name' => 'Patient Illness Summary'],
      ];

      $years = DB::table('medicalrecord')
        ->where('campus', session('campus'))
        ->whereNull('deleted_at')
        ->whereNotNull('date')
        ->select(DB::raw('YEAR(date) as year'))
        ->distinct()
        ->orderBy('year', 'desc')
        ->pluck('year');

      $selectedYear = $request->get('year');
      $tableSearch = trim($request->get('search', ''));
      $perPage = (int) $request->get('per_page', 10);
      if (!in_array($perPage, [10, 25, 50, 100], true)) {
        $perPage = 10;
      }
      $illnesses = null;
      $totalRecords = 0;

      if ($selectedYear !== null && $selectedYear !== '') {
        $request->validate([
          'year' => 'required|integer|min:1900|max:' . (date('Y') + 1),
        ]);

        $findings = DB::table('medicalrecord')
          ->where('campus', session('campus'))
          ->whereYear('date', $selectedYear)
          ->whereNull('deleted_at')
          ->whereNotNull('findings')
          ->whereRaw("TRIM(findings) <> ''")
          ->select('findings', 'date')
          ->get();

        $categories = [
          'Cough' => ['cough'],
          'Colds' => ['cold', 'colds'],
          'Fever' => ['fever'],
          'Epigastric Pain' => ['epigastric pain'],
          'Abdominal Pain' => ['abdominal pain'],
          'Dysmenorrhea' => ['dysmenorrhea', 'dysmenorrhoea'],
          'Wounds' => ['wound', 'wounds'],
          'Skin Rashes' => ['skin rash', 'skin rashes'],
          'Headache' => ['headache', 'head ache'],
          'Chest Pain' => ['chest pain'],
          'Insomnia' => ['insomnia'],
          'Joint Pains' => ['joint pain', 'joint pains'],
          'Dizziness' => ['dizziness', 'dizzy'],
          'Indigestion' => ['indigestion'],
          'Swollen Feet' => ['swollen feet', 'swollen foot', 'swollen fest'],
          'Weight Loss' => ['weight loss'],
          'Nausea/Vomiting' => ['nausea', 'nuesea', 'vomiting', 'nausea/vomiting'],
          'Sore Throat' => ['sore throat'],
          'Frequent Urination' => ['frequent urination'],
          'Difficulty of Breathing' => ['difficulty of breathing', 'difficulty breathing'],
          'Boil' => ['boil', 'boils'],
          'Stye' => ['stye', 'styes'],
        ];

        $summary = collect($categories)->map(function ($terms, $illness) use ($findings) {
          $months = array_fill(1, 12, 0);
          $total = 0;

          foreach ($findings as $record) {
            $normalized = strtolower((string) $record->findings);
            $matched = false;
            foreach ($terms as $term) {
              if (strpos($normalized, $term) !== false) {
                $matched = true;
                break;
              }
            }

            if ($matched) {
              $month = (int) date('n', strtotime($record->date));
              if ($month >= 1 && $month <= 12) $months[$month]++;
              $total++;
            }
          }

          return (object) ['illness' => $illness, 'months' => $months, 'total' => $total];
        })->values();

        $totalRecords = $summary->sum('total');

        if ($tableSearch !== '') {
          $summary = $summary->filter(function ($row) use ($tableSearch) {
            return stripos($row->illness, $tableSearch) !== false;
          })->values();
        }

        $currentPage = \Illuminate\Pagination\LengthAwarePaginator::resolveCurrentPage();
        $illnesses = new \Illuminate\Pagination\LengthAwarePaginator(
          $summary->slice(($currentPage - 1) * $perPage, $perPage)->values(),
          $summary->count(),
          $perPage,
          $currentPage,
          ['path' => $request->url(), 'query' => $request->query()]
        );
      }

      return view('pages.patient-illness-summary', compact(
        'pageConfigs', 'breadcrumbs', 'years', 'selectedYear', 'illnesses', 'totalRecords', 'tableSearch', 'perPage'
      ));
    }

    public function indexRecord(Request $request){
      $pageConfigs = ['pageHeader' => true];
      $breadcrumbs = [
        ["link" => "/", "name" => "Home"],["name" => "Add New"]
      ];
      $year = date('Y');
      
      $today = Carbon::today();
      $role = $request->role;

      $patientId = (new AESCipher)->decrypt($request->id);
      $healthhistory = DB::table('health_history')
        ->where('patientId', $patientId)
        ->where('campus', session('campus'))
        ->orderByDesc('id')
        ->first();

      $bloodType = trim($healthhistory->bloodtype ?? '');

      if ($bloodType === '') {
        $bloodType = (string) Medical::where('patientId', $patientId)
          ->where('role', $role)
          ->where(function ($query) {
            $query->where('campus', session('campus'))
              ->orWhereNull('campus')
              ->orWhere('campus', '');
          })
          ->whereNotNull('blood_type')
          ->where('blood_type', '!=', '')
          ->whereNull('deleted_at')
          ->orderByDesc('date')
          ->orderByDesc('id')
          ->value('blood_type');
      }

      if($role === 'Student'){
        $name = Student::where('StudentNo', (new AESCipher)->decrypt($request->id))->where('campus',session('campus'))->first();
       
        $data = DB::table('medicalrecord as m')
                ->select('m.*','s.LastName','s.FirstName','s.MiddleName','s.Sex','s.StudentNo','s.BirthDate')
                ->join('student_info as s','m.patientId','=','s.StudentNo')
                ->where('s.StudentNo',(new AESCipher)->decrypt($request->id))
                  ->where('m.role',$role)
                ->where('s.campus',session('campus'))
                ->first();

        $bdatetmp = explode(' ', $name->BirthDate);
        $newbday = $bdatetmp[2].'-'.str_pad($bdatetmp[0], 2, "0", STR_PAD_LEFT).'-'.str_pad($bdatetmp[1], 2, "1", STR_PAD_LEFT);
        $age = $today->diff($newbday)->y;

      } elseif($role === 'Employee'){

        $name = Employee::where('id', (new AESCipher)->decrypt($request->id))->where('campus',session('campus'))->first();

        $data = DB::table('medicalrecord as m')
                ->select('m.*','e.id','e.LastName','e.FirstName','e.MiddleName','e.Sex','e.AgencyNumber','e.DateOfBirth')
                ->join('employee_info as e','m.patientId','=','e.id')
                  ->where('m.role',$role)
                ->where('e.id',(new AESCipher)->decrypt($request->id))
                ->where('e.campus',session('campus'))
                ->first();

        $dateofbirth =$name->DateOfBirth;
        $age = $today->diff($dateofbirth)->y;

        if (!empty($data)){
          $hhId = (new AESCipher)->encrypt($data->AgencyNumber) ;
        }
      } elseif($role === 'Dependent'){

        $name = DB::table('dependent_info')->where('id', (new AESCipher)->decrypt($request->id))->where('campus',session('campus'))->first();

        $data = DB::table('medicalrecord as m')
                ->select('m.*','d.id','d.LastName','d.FirstName','d.MiddleName','d.Gender','d.id','d.BirthDate')
                ->join('dependent_info as d','m.patientId','=','d.id')
                ->where('m.role',$role)
                ->where('d.id',(new AESCipher)->decrypt($request->id))
                ->where('d.campus',session('campus'))
                ->first();

        $dateofbirth =$name->BirthDate;
        $age = $today->diff($dateofbirth)->y;

        if (!empty($data)){
          $hhId = (new AESCipher)->encrypt($data->id) ;
        }
      }

      $currentMonth = date('n');
      $schoolYearStartMonth = 8;

      if ($currentMonth >= $schoolYearStartMonth) {
        $schoolYear = date('Y');
      } else {
        $schoolYear = date('Y') - 1;
      }

      $nextSchoolYear = $schoolYear + 1;
      $addYear = $schoolYear . '-' . $nextSchoolYear;
 
      $id = (new AESCipher)->decrypt($request->id);
     
      $view = Medical::where('patientId', (new AESCipher)->decrypt($request->id))
          ->where(function ($query) {
            $query->where('campus', session('campus'))
              ->orWhereNull('campus')
              ->orWhere('campus', '');
          })
          ->where('role',$role)
          ->whereNull('deleted_at')
          ->orderBy('date', 'desc')
          ->get();

          // dd( $view);

             
     return view('pages.patient-monitoring-record',['pageConfigs'=>$pageConfigs,'breadcrumbs'=>$breadcrumbs], compact('healthhistory','bloodType','addYear','view', 'name', 'request','data','role','year','age','today','id'));
   
    }
    public function indexRecordSG(Request $request){
      $pageConfigs = ['pageHeader' => true];
      $breadcrumbs = [
        ["link" => "/", "name" => "Home"],["name" => "Add New"]
      ];
      $year = date('Y');
      
      $today = Carbon::today();
      $role = $request->role;

      $patientId = (new AESCipher)->decrypt($request->id);
      $healthhistory = DB::table('health_history')
        ->where('patientId', $patientId)
        ->where('campus', session('campus'))
        ->orderByDesc('id')
        ->first();

      $bloodType = trim($healthhistory->bloodtype ?? '');

      if ($bloodType === '') {
        $bloodType = (string) Medical::where('patientId', $patientId)
          ->where('role', $role)
          ->where(function ($query) {
            $query->where('campus', session('campus'))
              ->orWhereNull('campus')
              ->orWhere('campus', '');
          })
          ->whereNotNull('blood_type')
          ->where('blood_type', '!=', '')
          ->whereNull('deleted_at')
          ->orderByDesc('date')
          ->orderByDesc('id')
          ->value('blood_type');
      }

      if($role === 'Student'){
        $name = Student::where('StudentNo', (new AESCipher)->decrypt($request->id))->where('campus',session('campus'))->first();
       
        $data = DB::table('medicalrecord as m')
                ->select('m.*','s.LastName','s.FirstName','s.MiddleName','s.Sex','s.StudentNo','s.BirthDate')
                ->join('student_info as s','m.patientId','=','s.StudentNo')
                ->where('s.StudentNo',(new AESCipher)->decrypt($request->id))
                  ->where('m.role',$role)
                ->where('s.campus',session('campus'))
                ->first();

        $bdatetmp = explode(' ', $name->BirthDate);
        $newbday = $bdatetmp[2].'-'.str_pad($bdatetmp[0], 2, "0", STR_PAD_LEFT).'-'.str_pad($bdatetmp[1], 2, "1", STR_PAD_LEFT);
        $age = $today->diff($newbday)->y;

      } elseif($role === 'Employee'){

        $name = Employee::where('id', (new AESCipher)->decrypt($request->id))->where('campus',session('campus'))->first();

        $data = DB::table('medicalrecord as m')
                ->select('m.*','e.id','e.LastName','e.FirstName','e.MiddleName','e.Sex','e.AgencyNumber','e.DateOfBirth')
                ->join('employee_info as e','m.patientId','=','e.id')
                  ->where('m.role',$role)
                ->where('e.id',(new AESCipher)->decrypt($request->id))
                ->where('e.campus',session('campus'))
                ->first();

        $dateofbirth =$name->DateOfBirth;
        $age = $today->diff($dateofbirth)->y;

        if (!empty($data)){
          $hhId = (new AESCipher)->encrypt($data->AgencyNumber) ;
        }
      } elseif($role === 'Dependent'){

        $name = DB::table('dependent_info')->where('id', (new AESCipher)->decrypt($request->id))->where('campus',session('campus'))->first();

        $data = DB::table('medicalrecord as m')
                ->select('m.*','d.id','d.LastName','d.FirstName','d.MiddleName','d.Gender','d.id','d.BirthDate')
                ->join('dependent_info as d','m.patientId','=','d.id')
                ->where('m.role',$role)
                ->where('d.id',(new AESCipher)->decrypt($request->id))
                ->where('d.campus',session('campus'))
                ->first();

        $dateofbirth =$name->BirthDate;
        $age = $today->diff($dateofbirth)->y;

        if (!empty($data)){
          $hhId = (new AESCipher)->encrypt($data->id) ;
        }
      }

      $currentMonth = date('n');
      $schoolYearStartMonth = 8;

      if ($currentMonth >= $schoolYearStartMonth) {
        $schoolYear = date('Y');
      } else {
        $schoolYear = date('Y') - 1;
      }

      $nextSchoolYear = $schoolYear + 1;
      $addYear = $schoolYear . '-' . $nextSchoolYear;
 
      $id = (new AESCipher)->decrypt($request->id);
     
      $view = Medical::where('patientId', (new AESCipher)->decrypt($request->id))
          ->where(function ($query) {
            $query->where('campus', session('campus'))
              ->orWhereNull('campus')
              ->orWhere('campus', '');
          })
          ->where('role',$role)
          ->whereNull('deleted_at')
          ->orderBy('date', 'desc')
          ->get();

          // dd( $view);

             
     return view('pages.patient-monitoring-record-SG',['pageConfigs'=>$pageConfigs,'breadcrumbs'=>$breadcrumbs], compact('healthhistory','bloodType','addYear','view', 'name', 'request','data','role','year','age','today','id'));
   
    }
    public function autocomplete(Request $request){
      $role = $request->get('role');
      
      if ($role === 'Student') {
        $result = Student::where('campus', session('campus'))
          ->where(function ($query) use ($request) {
            $query->where('StudentNo', 'like', '%' . $request->search . '%')
                ->orWhere('LastName', 'LIKE', '%' . $request->search . '%')
                ->orWhere('FirstName', 'LIKE', '%' . $request->search . '%');
            })
          ->orderBy('LastName', 'asc')
          ->get();

        $encryptedResults = $result->map(function ($student) {
            $student->encryptedStudentNo = (new AESCipher)->encrypt($student->StudentNo);
            return $student;
        });
        
        $response = [
            'role' => $request->get('role'),
            'data' => $encryptedResults,
        ];
    
        return response()->json($response);
      } elseif ($role === 'Employee') {
        $result = Employee::where('campus', session('campus'))
          ->where(function ($query) use ($request) {
            $query->where('AgencyNumber', 'like', '%' . $request->search . '%')
                ->orWhere('LastName', 'LIKE', '%' . $request->search . '%')
                ->orWhere('FirstName', 'LIKE', '%' . $request->search . '%');
            })
          ->orderBy('LastName', 'asc')
          ->get();
    
          $encryptedResults = $result->map(function ($employee) {
          $employee->encryptedEmployeeNo = (new AESCipher)->encrypt($employee->id);
          return $employee;
        });

        $response = [
            'role' => $request->get('role'),
            'data' => $encryptedResults,
        ];
      
        return response()->json($response);
      }elseif ($role === 'Dependent') {
        $result = DB::table('dependent_info')->where('campus', session('campus'))
        ->where('services','Medical')
          ->where(function ($query) use ($request) {
            $query->where('id', 'like', '%' . $request->search . '%')
                ->orWhere('LastName', 'LIKE', '%' . $request->search . '%')
                ->orWhere('FirstName', 'LIKE', '%' . $request->search . '%');
            })
          ->orderBy('LastName', 'asc')
          ->get();
    
          $encryptedResults = $result->map(function ($dependent) {
          $dependent->encryptedDependentNo = (new AESCipher)->encrypt($dependent->id);
          return $dependent;
        });

        $response = [
            'role' => $request->get('role'),
            'data' => $encryptedResults,
        ];
      
        return response()->json($response);
      } else {
        $data = [];
        return response()->json($data);
      }     
    }
#insert record
    public function patientRecord(Request $request){
      try {
        $request->validate([
          'purpose' => 'required|array|min:1',
          'findings' => 'required|string',
          'date' => 'required|date',
          'time' => 'required',
        ]);
        $hhId = $request->hhId;
        $patientId = $request->patientId;
        $findings = $request->findings;
        $recommendation = $request->recommendation;
        $weight = $request->weight;
        $height = $request->height;
        $blood_type = $request->bloodType;
        $temp = $request->temperature;
        $pulse = $request->pulse;
        $res_rate = $request->respiratoryRate;
        $bp = $request->bloodPressure;
        $purpose = json_encode($request->purpose);
        $role = $request->role;

        $existingRecord = Medical::where('patientId', $patientId)
          ->where('findings', $findings) 
          ->where('recommendation', $recommendation)  
          ->where('weight', $weight)
          ->where('height', $height)
          ->where('blood_type', $blood_type)
          ->where('temp', $temp)
          ->where('pulse', $pulse)
          ->where('res_rate', $res_rate)
          ->where('bp', $bp)
          ->where('campus',session('campus'))
          ->latest('patientId', $patientId)
          ->exists();

        if($role == 'Student'){
          $positioncourse = $request->course;
        }elseif($role == 'Employee'){
           $positioncourse = $request->position;
        }elseif($role == 'Dependent'){
           $positioncourse = $request->dependent;
        }

        if ($existingRecord) {
            return response()->json(["Error" => 1, "Message" => "Record already exists."]);
        } else{
      
          if (in_array("OTC Medicine", $request->purpose)) {
   
            $patientId = $request -> patientId;
            $role = $request->get('role');
            
            $record = DB::table('medicalrecord')->insert([
              'patientId' =>  $patientId,
              'campus' => session('campus'),
              'role' => $role,
              'positioncourse' => $positioncourse,
              'age' =>   $request->age ,
              'gender' =>   $request->gender ,
              'purpose' =>   $purpose ,
              'date' =>  $request->date ,
              'time' =>  $request->time ,
              'findings' => $request->findings,
              'weight' => $request->weight,
              'height' => $request->height,
              'blood_type' => $request->bloodType,
              'temp' => $request->temperature, 
              'pulse' => $request->pulse,
              'res_rate' => $request->respiratoryRate,
              'bp' => $request->bloodPressure,
              'remarks' => $request->remarks,
              'specify' => $request->specify,
              'status' => 'For Doctor',
              'reqlabres' => $request->reqlabres,
              'recommendation' => $request->recommendation,
              'OTCmedpcs' => json_encode($request->OTCmedpcs), 
              'OTCmedDescript' => json_encode($request->OTCmedDescript),
              'deleted_at' => null,
              'created_at' =>  Carbon::now('Asia/Manila'),
            ]);

            $new =  (new AESCipher)->encrypt($request->patientId);
            $purpose = json_encode($request->purpose);

            $ne = Medical::where('patientId', $request->patientId)->where('campus',session('campus'))->latest('id')->first();
            
            if($record === true) {
              return response()->json(['status' => 200,'success'   => 'Saved Successfully!','newId' =>   $new,'recId' =>   $ne->id,'role' => $role,'purpose' => $purpose,'hhId' => $hhId  ]);
            } else {
              return response()->json(["Error"=>1,"Message"=>"Error Saving Data!"]);
            }  
          }else{
            $patientId = $request -> patientId;
            $role = $request->get('role');
            
            $record = DB::table('medicalrecord')->insert([
                'patientId' =>  $patientId,
                'campus' => session('campus'),
                'role' => $role,
                'positioncourse' => $positioncourse,
                'age' =>   $request->age ,
                'gender' =>   $request->gender ,
                'purpose' =>    $purpose ,
                'date' =>  $request->date ,
                'time' =>  $request->time ,
                'findings' => $request->findings,
                'weight' => $request->weight,
                'height' => $request->height,
                'blood_type' => $request->bloodType,
                'temp' => $request->temperature,
                'pulse' => $request->pulse,
                'res_rate' => $request->respiratoryRate,
                'bp' => $request->bloodPressure,
                'remarks' => $request->remarks,
                'specify' => $request->specify,
                'status' => 'For Doctor',
                'reqlabres' => $request->reqlabres,
                'recommendation' => $request->recommendation,
                'deleted_at' => null,
                'created_at' =>  Carbon::now('Asia/Manila'),
              ]);
    
              $new =  (new AESCipher)->encrypt($request->patientId);
              $purpose = json_encode($request->purpose);
  
              $ne = Medical::where('patientId', $request->patientId)->where('campus',session('campus'))->latest('id')->first();
             
              if($record === true) {
                return response()->json(['status' => 200,'success'   => 'Saved Successfully!','newId' =>   $new,'recId' =>   $ne->id,'role' => $role,'purpose' => $purpose,'hhId' => $hhId   ]);
              } else {
                return response()->json(["Error"=>1,"Message"=>"Error Saving Data!"]);
              }
          }
        }
        } catch (\Throwable $th) {
              dd('err',$th);
        }
        return back();  
    }
  public function searchItems(Request $request){

    $OTCmedDescript = $request->get('OTCmedDescript');

    $data = Stocks::where('item_name', 'LIKE', '%' . $OTCmedDescript . '%')
            ->where('item_quantity', '>', 0)
            ->where('campus',session('campus'))
            ->whereNull('deleted_at')
            ->orderBy('item_name', 'asc')
            ->where(function($query) {
              $query->whereNull('expiration_date')
                    ->orWhere('expiration_date', '>=', Carbon::today());
              })
            ->get();

    return response()->json($data);

  }

  public function doctorConsultation($record)
  {
    $pageConfigs = ['pageHeader' => true];
    $breadcrumbs = [
      ['link' => '/', 'name' => 'Home'],
      ['name' => 'Add New'],
    ];

    $medical = Medical::where('id', $record)->where('campus', session('campus'))->firstOrFail();
    $patient = $this->patientForRecord($medical);
    $doctor = DB::table('doctors')
      ->where('campus', session('campus'))
      ->where('specialization', 'physician')
      ->whereNull('deleted_at')
      ->first();

    return view('pages.doctor-consultation', ['pageConfigs' => $pageConfigs, 'breadcrumbs' => $breadcrumbs], compact('medical', 'patient', 'doctor'));
  }

  public function doctorConsultations(Request $request)
  {
    $search = trim($request->get('search', ''));

    $consultations = DB::table('medicalrecord as m')
      ->leftJoin('student_info as s', function ($join) {
        $join->on('m.patientId', '=', 's.StudentNo')->where('m.role', '=', 'Student');
      })
      ->leftJoin('employee_info as e', function ($join) {
        $join->on('m.patientId', '=', 'e.id')->where('m.role', '=', 'Employee');
      })
      ->leftJoin('dependent_info as d', function ($join) {
        $join->on('m.patientId', '=', 'd.id')->where('m.role', '=', 'Dependent');
      })
      ->select(
        'm.*',
        DB::raw("COALESCE(s.FirstName, e.FirstName, d.FirstName, '') as patient_first_name"),
        DB::raw("COALESCE(s.MiddleName, e.MiddleName, d.MiddleName, '') as patient_middle_name"),
        DB::raw("COALESCE(s.LastName, e.LastName, d.LastName, '') as patient_last_name")
      )
      ->where('m.status', 'For Doctor')
      ->whereNull('m.deleted_at')
      ->where(function ($query) {
        $query->where('m.campus', session('campus'))
          ->orWhereNull('m.campus')
          ->orWhere('m.campus', '');
      });

    if ($search !== '') {
      $consultations->where(function ($query) use ($search) {
        $query->where('m.patientId', 'like', "%{$search}%")
          ->orWhere('s.FirstName', 'like', "%{$search}%")
          ->orWhere('s.LastName', 'like', "%{$search}%")
          ->orWhere('e.FirstName', 'like', "%{$search}%")
          ->orWhere('e.LastName', 'like', "%{$search}%")
          ->orWhere('d.FirstName', 'like', "%{$search}%")
          ->orWhere('d.LastName', 'like', "%{$search}%");
      });
    }

    $consultations = $consultations->orderBy('m.date', 'asc')
      ->orderBy('m.time', 'asc')
      ->paginate(12)
      ->appends(['search' => $search]);

    return view('pages.doctor-consultations', compact('consultations', 'search'));
  }

  public function saveDoctorConsultation(Request $request, $record)
  {
    $this->validateDoctorConsultation($request);
    $medical = Medical::where('id', $record)->where('campus', session('campus'))->firstOrFail();
    $this->persistDoctorConsultation($medical, $request);

    if ($request->expectsJson()) {
      return response()->json([
        'message' => 'Doctor consultation saved successfully.',
      ]);
    }

    return back()->with('success', 'Doctor consultation saved successfully.');
  }

  public function consultationRecords(Request $request)
  {
    $search = trim($request->get('search', ''));
    $medicineSummary = DB::table('doctor_consultation')
      ->select(
        'patientId',
        DB::raw("GROUP_CONCAT(CONCAT(medicine_name, ' (Qty: ', quantity, ')') SEPARATOR ', ') as prescribed_medicines")
      )
      ->whereNull('deleted_at')
      ->groupBy('patientId');

    $consultations = DB::table('medicalrecord as m')
      ->leftJoin('student_info as s', function ($join) {
        $join->on('m.patientId', '=', 's.StudentNo')->where('m.role', '=', 'Student');
      })
      ->leftJoin('employee_info as e', function ($join) {
        $join->on('m.patientId', '=', 'e.id')->where('m.role', '=', 'Employee');
      })
      ->leftJoin('dependent_info as d', function ($join) {
        $join->on('m.patientId', '=', 'd.id')->where('m.role', '=', 'Dependent');
      })
      ->leftJoinSub($medicineSummary, 'dc', function ($join) {
        $join->on('m.id', '=', 'dc.patientId');
      })
      ->select(
        'm.*',
        'dc.prescribed_medicines',
        DB::raw("COALESCE(s.FirstName, e.FirstName, d.FirstName, '') as patient_first_name"),
        DB::raw("COALESCE(s.MiddleName, e.MiddleName, d.MiddleName, '') as patient_middle_name"),
        DB::raw("COALESCE(s.LastName, e.LastName, d.LastName, '') as patient_last_name")
      )
      ->where('m.status', 'For Nurse')
      ->whereNull('m.deleted_at')
      ->where(function ($query) {
        $query->where('m.campus', session('campus'))
          ->orWhereNull('m.campus')
          ->orWhere('m.campus', '');
      });

    if ($search !== '') {
      $consultations->where(function ($query) use ($search) {
        $query->where('m.patientId', 'like', "%{$search}%")
          ->orWhere('s.FirstName', 'like', "%{$search}%")
          ->orWhere('s.LastName', 'like', "%{$search}%")
          ->orWhere('e.FirstName', 'like', "%{$search}%")
          ->orWhere('e.LastName', 'like', "%{$search}%")
          ->orWhere('d.FirstName', 'like', "%{$search}%")
          ->orWhere('d.LastName', 'like', "%{$search}%");
      });
    }

    $consultations = $consultations->orderBy('m.date', 'asc')
      ->orderBy('m.time', 'asc')
      ->paginate(12)
      ->appends(['search' => $search]);

    return view('pages.consultation-records', compact('consultations', 'search'));
  }

  public function prescriptionPdf(Request $request, $record)
  {
    $this->validateDoctorConsultation($request);
    $medical = Medical::where('id', $record)->where('campus', session('campus'))->firstOrFail();

    $patient = $this->patientForRecord($medical);
    $doctor = DB::table('doctors')
      ->where('campus', session('campus'))
      ->where('specialization', 'physician')
      ->whereNull('deleted_at')
      ->first();

    $medicines = [];
    foreach (($request->medicine_name ?: []) as $index => $name) {
      if (trim($name) === '') continue;

      $dose = trim($request->medicine_dose[$index] ?? '');
      $doseUnit = trim($request->medicine_dose_unit[$index] ?? '');

      $medicines[] = [
        'name' => $name,
        'dose' => trim($dose . ' ' . $doseUnit),
        'route' => $request->medicine_route[$index] ?? '',
        'frequency' => $request->medicine_frequency[$index] ?? '',
        'duration' => $request->medicine_duration[$index] ?? '',
      ];
    }

    return Pdf::loadView('pages.doctor-prescription-pdf', [
      'medical' => $medical,
      'patient' => $patient,
      'doctor' => $doctor,
      'medicines' => $medicines,
      'instructions' => $request->patient_instructions,
    ])->setPaper('A5', 'portrait')->stream('prescription-' . $medical->id . '.pdf');
  }

  public function savedPrescriptionPdf($record)
  {
    $medical = Medical::where('id', $record)->where('campus', session('campus'))->firstOrFail();
    $patient = $this->patientForRecord($medical);
    $doctor = DB::table('doctors')
      ->where('campus', session('campus'))
      ->where('specialization', 'physician')
      ->whereNull('deleted_at')
      ->first();

    $savedMedicines = DB::table('doctor_consultation')
      ->where('patientId', $medical->id)
      ->whereNull('deleted_at')
      ->orderBy('id')
      ->get();

    $medicines = $savedMedicines->map(function ($medicine) {
      return [
        'name' => $medicine->medicine_name,
        'dose' => $medicine->dose,
        'route' => $medicine->route,
        'frequency' => $medicine->frequency,
        'duration' => $medicine->duration,
      ];
    })->all();

    $instructions = optional($savedMedicines->first())->instruction;

    return Pdf::loadView('pages.doctor-prescription-pdf', compact(
      'medical',
      'patient',
      'doctor',
      'medicines',
      'instructions'
    ))->setPaper('A5', 'portrait')->stream('prescription-' . $medical->id . '.pdf');
  }

  public function nurseTreatment($record)
  {
    $medical = Medical::where('id', $record)->where('campus', session('campus'))->firstOrFail();
    $patient = $this->patientForRecord($medical);
    $doctorConsultations = DB::table('doctor_consultation')
      ->where('patientId', $medical->id)
      ->whereNull('deleted_at')
      ->orderBy('id')
      ->get();

    return view('pages.nurse-treatment', compact('medical', 'patient', 'doctorConsultations'));
  }

  public function saveNurseTreatment(Request $request, $record)
  {
    $request->validate([
      'purpose' => 'required|array|min:1',
      'recommendation' => 'required|string',
    ]);

    $medical = Medical::where('id', $record)->where('campus', session('campus'))->firstOrFail();
    $purposes = $request->purpose;
    if ($request->has_medicine && !in_array('OTC Medicine', $purposes)) {
      $purposes[] = 'OTC Medicine';
    }

    $medical->purpose = json_encode(array_values(array_unique($purposes)));
    $medical->recommendation = $request->recommendation;
    $medical->status = 'Active';
    $medical->save();

    return redirect()->route('medical.consultation-records')
      ->with('success', 'Patient treatment record completed successfully.');
  }

  private function patientForRecord(Medical $medical)
  {
    if ($medical->role === 'Student') {
      return Student::where('StudentNo', $medical->patientId)->where('campus', session('campus'))->firstOrFail();
    }

    if ($medical->role === 'Employee') {
      return Employee::where('id', $medical->patientId)->where('campus', session('campus'))->firstOrFail();
    }

    return DB::table('dependent_info')->where('id', $medical->patientId)->where('campus', session('campus'))->first();
  }

  private function validateDoctorConsultation(Request $request)
  {
    $request->validate([
      'recommendation' => 'required|string',
      'medicine_name.*' => 'nullable|string',
      'medicine_quantity.*' => 'nullable|integer|min:1',
      'medicine_stock_id.*' => 'nullable|integer',
      'medicine_dose.*' => 'nullable|string',
      'medicine_dose_unit.*' => 'nullable|string|in:Tablet,Capsule,Milligram,Gram,Milliliter,Teaspoon,Tablespoon,Drop,Puff,Unit',
      'medicine_route.*' => 'nullable|string',
      'medicine_frequency.*' => 'nullable|string',
      'medicine_duration.*' => 'nullable|string',
      'patient_instructions' => 'nullable|string',
    ]);
  }

  private function persistDoctorConsultation(Medical $medical, Request $request)
  {
    $consultations = [];
    $inventoryDeductions = [];

    foreach (($request->medicine_name ?: []) as $index => $enteredName) {
      $medicineName = trim($enteredName);
      if ($medicineName === '') continue;

      $dose = trim($request->medicine_dose[$index] ?? '');
      $doseUnit = trim($request->medicine_dose_unit[$index] ?? '');

      $consultations[] = [
        'patientId' => $medical->id,
        'quantity' => (int) ($request->medicine_quantity[$index] ?? 1),
        'medicine_name' => $medicineName,
        'dose' => trim($dose . ' ' . $doseUnit),
        'route' => $request->medicine_route[$index] ?? '',
        'frequency' => $request->medicine_frequency[$index] ?? '',
        'duration' => $request->medicine_duration[$index] ?? '',
        'instruction' => $request->patient_instructions ?? '',
        'created_at' => now(),
      ];

      $inventoryDeductions[] = [
        'stock_id' => $request->medicine_stock_id[$index] ?? null,
        'medicine_name' => $medicineName,
        'quantity' => (int) ($request->medicine_quantity[$index] ?? 1),
      ];
    }

    DB::transaction(function () use ($medical, $request, $consultations, $inventoryDeductions) {
      $shouldDeductInventory = $medical->status === 'For Doctor';

      if ($shouldDeductInventory) {
        foreach ($inventoryDeductions as $deduction) {
          if (!$deduction['stock_id']) {
            throw ValidationException::withMessages([
              'medicine_name' => "Please select {$deduction['medicine_name']} from the inventory search results.",
            ]);
          }

          $stock = Stocks::where('id', $deduction['stock_id'])
            ->where('campus', session('campus'))
            ->whereNull('deleted_at')
            ->lockForUpdate()
            ->first();

          if (!$stock || $stock->item_quantity < $deduction['quantity']) {
            throw ValidationException::withMessages([
              'medicine_quantity' => "Insufficient inventory for {$deduction['medicine_name']}.",
            ]);
          }

          $latestInventory = Inventory::where('stockId', $stock->id)
            ->where('campus', session('campus'))
            ->whereNull('deleted_at')
            ->orderByDesc('id')
            ->lockForUpdate()
            ->first();
          $currentStock = $latestInventory ? $latestInventory->remaining_stock : $stock->item_quantity;

          if ($currentStock < $deduction['quantity']) {
            throw ValidationException::withMessages([
              'medicine_quantity' => "Insufficient inventory for {$deduction['medicine_name']}.",
            ]);
          }

          $remainingStock = $currentStock - $deduction['quantity'];
          $stock->item_quantity = $remainingStock;
          $stock->save();

          DB::table('inventory')->insert([
            'patientId' => $medical->patientId,
            'stockId' => $stock->id,
            'lotno' => $stock->lotno,
            'item_stock' => $currentStock,
            'stock_less' => $deduction['quantity'],
            'remaining_stock' => $remainingStock,
            'added_stock' => 0,
            'campus' => session('campus'),
            'date' => $medical->date ?: now()->toDateString(),
            'added_by' => (new AESCipher)->decrypt(session('employee_id')),
            'created_at' => now(),
            'updated_at' => now(),
          ]);
        }
      }

      DB::table('doctor_consultation')
        ->where('patientId', $medical->id)
        ->whereNull('deleted_at')
        ->update(['deleted_at' => now()]);

      if (!empty($consultations)) {
        DB::table('doctor_consultation')->insert($consultations);
      }

      $purposes = json_decode($medical->purpose, true) ?: [];
      if (!empty($consultations) && !in_array('OTC Medicine', $purposes)) {
        $purposes[] = 'OTC Medicine';
      }

      Medical::where('id', $medical->id)
        ->where('campus', session('campus'))
        ->update([
          'recommendation' => $request->recommendation,
          'purpose' => json_encode(array_values(array_unique($purposes))),
          'status' => 'For Nurse',
        ]);

      $medical->status = 'For Nurse';
      $medical->recommendation = $request->recommendation;
      $medical->purpose = json_encode(array_values(array_unique($purposes)));
    });
  }
}

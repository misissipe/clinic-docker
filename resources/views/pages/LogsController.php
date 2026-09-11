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
use DataTables;
use\App\Providers;
use Carbon\Carbon;
use App\Http\Controllers\AESCipher;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Barryvdh\DomPDF\Facade\Pdf;

class LogsController extends Controller
{
    protected $aes;
    public function __construct() {
        $this->aes = new AESCipher;
    }
    public function medicalService(Request $request, $purpose, $viewName)
    {
    $pageConfigs = ['pageHeader' => true];
    $breadcrumbs = [
        ["link" => "/", "name" => "Home"], ["name" => $purpose]
    ];

    $today = Carbon::today();
    $year = $today->year;
    $monthNumber = date('n');
    $monthNames = [
        1 => 'January', 2 => 'February', 3 => 'March',
        4 => 'April', 5 => 'May', 6 => 'June',
        7 => 'July', 8 => 'August', 9 => 'September',
        10 => 'October', 11 => 'November', 12 => 'December'
    ];
    $month = $monthNames[$monthNumber];

    $totalS = DB::table('medicalrecord as m')
        ->select('m.*', 's.*')
        ->join('student_info as s', function ($join) {
        $join->on('s.StudentNo', '=', 'm.patientId')
             ->on('s.campus', '=', 'm.campus');
        })
        ->whereJsonContains('purpose', $purpose)
        ->whereMonth('m.date', $monthNumber)
        ->whereYear('m.date', $year)
        ->whereNull('m.deleted_at')
        ->where('m.campus', session('campus'))
        ->get();

    $totalE = DB::table('medicalrecord as m')
    ->select('m.*', 'e.*')
    ->join('employee_info as e', function ($join) {
        $join->on('e.id', '=', 'm.patientId')
             ->on('e.campus', '=', 'm.campus');
    })
    ->where('m.campus', session('campus'))
    ->whereJsonContains('purpose', $purpose)
    ->whereMonth('m.date', $monthNumber)
    ->whereYear('m.date', $year)
    ->whereNull('m.deleted_at')
    ->get();

    return view($viewName, [
        'pageConfigs' => $pageConfigs,
        'breadcrumbs' => $breadcrumbs,
        'totalS' => $totalS,
        'totalE' => $totalE,
        'month' => $month
    ]);
}

public function woundDressing(Request $request) {
    return $this->medicalService($request, 'Wound Dressing', 'pages.medical-wound-dressing');
}

public function bloodPressure(Request $request) {
    return $this->medicalService($request, 'Blood Pressure', 'pages.medical-blood-pressure');
}

public function provision(Request $request) {
    return $this->medicalService($request, 'Provision of Comfort', 'pages.medical-provision-of-comfort');
}

public function certificate(Request $request) {
    return $this->medicalService($request, 'Issuance of Certificate', 'pages.medical-issuance-of-certificate');
}

public function slip(Request $request) {
    return $this->medicalService($request, 'Referral', 'pages.medical-issuance-of-slip');
}

public function OTCmed(Request $request) {
    return $this->medicalService($request, 'OTC Medicine', 'pages.medical-OTC-medicine');
}

public function others(Request $request) {
    return $this->medicalService($request, 'Other Concerns', 'pages.medical-other-concern');
}

public function physicalAssessmet(Request $request) {
    return $this->medicalService($request, 'Physical Assessment', 'pages.medical-physical-assessment');
}


public function medicalServicelogbook(Request $request, $purpose, $viewName)
{

}

public function recordsOfvisit(Request $request){

    $pageConfigs = ['pageHeader' => true];
    $breadcrumbs = [ 
        ["link" => "/", "name" => "Home"],
        ["name" => "Record of Visit"]
    ];

    $today = Carbon::today();
    $year = $today -> year;
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
        12 => 'December'];
    $month = $monthNames[$monthNumber];

    $data = DB::table('medicalrecord as m')
    ->select(
        'm.*',
        's.LastName as studentLastName',
        's.FirstName as studentFirstName',
        's.MiddleName as studentMiddleName',
        's.Sex as studentSex', 
        's.accro as studentaccro',
        's.StudentYear as studentStudentYear',
        's.brgy as studentbrgy',
        's.city as studentcity',
        's.province as studentprovince',
        'e.LastName as employeeLastName',
        'e.FirstName as employeeFirstName',
        'e.MiddleName as employeeMiddleName',
        'e.Sex as employeeSex',
        'e.EmploymentStatus as employeeEmploymentStatus',
        'e.RBarangay as employeeRBarangay',
        'e.citymunDesc as employeecitymunDesc',
        'e.provDesc as employeeprovDesc'
    )
    ->leftJoin('student_info as s', function ($join) {
        $join->on('m.patientId', '=', 's.StudentNo')
            ->where('s.campus', session('campus'));
    })
    ->leftJoin('employee_info as e', function ($join) {
        $join->on('m.patientId', '=', 'e.id')
            ->where('e.campus', session('campus'));
    })
    ->where('m.campus', session('campus'))
    ->whereMonth('m.date', $monthNumber)
    ->whereYear('m.date', $year)
    ->whereNull('m.deleted_at')
    ->get();


    return view('pages.medical-record-of-visit',['pageConfigs'=>$pageConfigs,'breadcrumbs'=>$breadcrumbs],compact('month','data'));
} 
    public function recordsforVisit(Request $request) {
        $pageConfigs = ['pageHeader' => true];
        $breadcrumbs = [
            ["link" => "/", "name" => "Home"],
            ["name" => "Record of Visit"]
        ];

        $monthSearch = $request->input('monthSearch');
        $year = $request->input('year');
        $date_range = $request->input('date_range');   
        [$start_day, $end_day] = explode('-', $date_range);

        $search = DB::table('medicalrecord as m')
            ->select(
                'm.*',
                's.LastName as studentLastName',
                's.FirstName as studentFirstName',
                's.MiddleName as studentMiddleName',
                's.Sex as studentSex', 
                's.accro as studentaccro' ,
                's.StudentYear as studentStudentYear',
                's.brgy as studentbrgy',
                's.city as studentcity',
                's.province as studentprovince',
                'e.LastName as employeeLastName',
                'e.FirstName as employeeFirstName',
                'e.MiddleName as employeeMiddleName',
                'e.Sex as employeeSex',
                'e.EmploymentStatus as employeeEmploymentStatus' ,
                'e.RBarangay as employeeRBarangay',
                'e.citymunDesc as employeecitymunDesc',
                'e.provDesc as employeeprovDesc'
            )
          ->leftJoin('student_info as s', 'm.patientId', '=', 's.StudentNo')
            ->leftJoin('employee_info as e', 'm.patientId', '=', 'e.id')
            ->where(function ($query) {
                    $query->where('e.campus', session('campus'))
                        ->orWhere('s.campus', session('campus'));
                })
            ->whereBetween(DB::raw('DAY(m.date)'), [(int)$start_day, (int)$end_day])
            ->whereMonth('m.date', $monthSearch)
            ->whereYear('m.date', $year)
            ->whereNull('m.deleted_at')
            ->where('m.campus', session('campus'))
            ->get();

        return response()->json($search);
    }
    
    public function recordsforWound(Request $request) {
        $pageConfigs = ['pageHeader' => true];
        $breadcrumbs = [
            ["link" => "/", "name" => "Home"],
            ["name" => "Wound Dressing"]
        ];

        $role = $request->get('role');
        $monthSearch = $request->input('monthSearch');
        $year = $request->input('year');

        $strDate = $year."-".$monthSearch;

        $search = DB::table('medicalrecord as m')
            ->select(
                'm.*',
                's.LastName as studentLastName',
                's.FirstName as studentFirstName',
                's.MiddleName as studentMiddleName',
                's.Sex as studentSex', 
                's.accro as studentaccro' ,
                's.StudentYear as studentStudentYear',
                's.brgy as studentbrgy',
                's.city as studentcity',
                's.province as studentprovince',
                'e.LastName as employeeLastName',
                'e.FirstName as employeeFirstName',
                'e.MiddleName as employeeMiddleName',
                'e.Sex as employeeSex',
                'e.EmploymentStatus as employeeEmploymentStatus' ,
                'e.RBarangay as employeeRBarangay',
                'e.citymunDesc as employeecitymunDesc',
                'e.provDesc as employeeprovDesc'
            )
            ->leftJoin('student_info as s', 'm.patientId', '=', 's.StudentNo')
            ->leftJoin('employee_info as e', 'm.patientId', '=', 'e.id')
            ->where(function ($query) {
                    $query->where('e.campus', session('campus'))
                        ->orWhere('s.campus', session('campus'));
                })
            ->where('m.date', "LIKE",  $strDate."%")
            ->whereJsonContains('Purpose','Wound Dressing')
            ->where('m.role',$role)
            ->whereNull('m.deleted_at')
            ->where('m.campus', session('campus'))
            ->get();

            return response()->json($search);
    }
    
    public function recordsforBp(Request $request) {
      $pageConfigs = ['pageHeader' => true];
      $breadcrumbs = [
          ["link" => "/", "name" => "Home"],
          ["name" => "Blood Pressure"]
      ];

      $role = $request->get('role');
      $monthSearch = $request->input('monthSearch');
      $year = $request->input('year');

      $strDate = $year."-".$monthSearch;

      $search = DB::table('medicalrecord as m')
        ->select(
            'm.*',
            's.LastName as studentLastName',
            's.FirstName as studentFirstName',
            's.MiddleName as studentMiddleName',
            's.Sex as studentSex', 
            's.accro as studentaccro' ,
            's.StudentYear as studentStudentYear',
            's.brgy as studentbrgy',
            's.city as studentcity',
            's.province as studentprovince',
            'e.LastName as employeeLastName',
            'e.FirstName as employeeFirstName',
            'e.MiddleName as employeeMiddleName',
            'e.Sex as employeeSex',
            'e.EmploymentStatus as employeeEmploymentStatus' ,
            'e.RBarangay as employeeRBarangay',
            'e.citymunDesc as employeecitymunDesc',
            'e.provDesc as employeeprovDesc'
        )
        ->leftJoin('student_info as s', 'm.patientId', '=', 's.StudentNo')
            ->leftJoin('employee_info as e', 'm.patientId', '=', 'e.id')
            ->where(function ($query) {
                    $query->where('e.campus', session('campus'))
                        ->orWhere('s.campus', session('campus'));
                })
        ->where('m.date', "LIKE",  $strDate."%")
            ->whereJsonContains('purpose','Blood Pressure')
        ->where('m.role',$role)
        ->whereNull('m.deleted_at')
        ->where('m.campus', session('campus'))
        ->get();
    
        return response()->json($search);
    }
  
    public function recordsforProvision(Request $request) {
        $pageConfigs = ['pageHeader' => true];
        $breadcrumbs = [
            ["link" => "/", "name" => "Home"],
            ["name" => "Provision of Comfort"]
        ];
     
        $role = $request->get('role');
        $monthSearch = $request->input('monthSearch');
        $year = $request->input('year');
              
        $strDate = $year."-".$monthSearch;
     
        if ($role === 'Student') {
          if ($request->ajax()) {
            $search = DB::table('medicalrecord as m')
                ->select('m.*', 's.*')
                ->join('student_info as s', 's.StudentNo', '=', 'm.patientId')
                ->where('m.date', "LIKE",  $strDate."%")
                ->whereJsonContains('Purpose','Provision of Comfort')
                ->whereNull('m.deleted_at')
                ->where('m.campus', session('campus'))
                ->get();
            
            return response()->json($search);
          }
        }
        elseif ($role === 'Employee') {
          if ($request->ajax()) {
            $search = DB::table('medicalrecord as m')
                ->select('m.*', 's.*')
                ->join('employee as e', 'e.id', '=', 'm.patientId')
                ->where('m.date', "LIKE",  $strDate."%")
                ->whereJsonContains('Purpose','Provision of Comfort')
                ->whereMonth('m.date', $monthNumber)
                ->whereNull('m.deleted_at')
                ->where('m.campus', session('campus'))
                ->get();
        
              return response()->json($search);
          }
        } 
      }
    
    public function recordsforCertificate(Request $request) {
      $pageConfigs = ['pageHeader' => true];
      $breadcrumbs = [
          ["link" => "/", "name" => "Home"],
          ["name" => "Issuance of Certificate"]
      ];
  
      $role = $request->get('role');
        
      if ($role === 'Student') {
        if ($request->ajax()) {
            $monthSearch = $request->input('monthSearch'); 
            $year = $request->input('year');               
            $date_range = $request->input('date_range');   


            [$start_day, $end_day] = explode('-', $date_range);

            $strDate = $year . "-" . str_pad($monthSearch, 2, '0', STR_PAD_LEFT);

            $search = DB::table('medicalrecord as m')
                ->select('m.*', 's.*')
                ->join('student_info as s', 's.StudentNo', '=', 'm.patientId')
                ->where('m.date', 'like', $strDate . '%') 
                ->whereJsonContains('Purpose',  'Issuance of Certificate')
                ->whereBetween(DB::raw('DAY(m.date)'), [(int)$start_day, (int)$end_day]) 
                ->whereNull('m.deleted_at')
                ->where('m.campus', session('campus'))
                ->get();

            return response()->json($search);
        }
      }
      elseif ($role === 'Employee') {
        if ($request->ajax()) {
            $monthSearch = $request->input('monthSearch');
            $year = $request->input('year');
            $date_range = $request->input('date_range');

            [$start_day, $end_day] = explode('-', $date_range);
            
            $strDate = $year."-".$monthSearch;
              
            $search = DB::table('medicalrecord as m')
                ->select('m.*', 'e.*')
                ->join('employee_info as e', 'e.id', '=', 'm.patientId')
                ->where('m.date', "LIKE",  $strDate."%")
                ->whereJsonContains('Purpose','Issuance of Certificate')
                ->whereNull('m.deleted_at')
                ->where('m.campus', session('campus'))
                ->get();
  
            return response()->json($search);
        }
      } 
    }

    public function recordsforSlip(Request $request) {
      $pageConfigs = ['pageHeader' => true];
      $breadcrumbs = [
          ["link" => "/", "name" => "Home"],
          ["name" => "Issuance of Slip"]
      ];

      $role = $request->get('role');
        
      if ($role === 'Student') {
        if ($request->ajax()) {
            $monthSearch = $request->input('monthSearch');
            $year = $request->input('year');
            
            $strDate = $year."-".$monthSearch;
              
            $search = DB::table('medicalrecord as m')
                ->select('m.*', 's.*')
                ->join('student_info as s', 's.StudentNo', '=', 'm.patientId')
                ->where('m.date', "LIKE",  $strDate."%")
                ->whereJsonContains('Purpose','Referral')
                ->whereNull('m.deleted_at')
                ->where('s.campus', session('campus'))
                ->get();
  
            return response()->json($search);
        }
      }
      elseif ($role === 'Employee') {
        if ($request->ajax()) {
            $monthSearch = $request->input('monthSearch');
            $year = $request->input('year');
            
            $strDate = $year."-".$monthSearch;
              
            $search = DB::table('medicalrecord as m')
                ->select('m.*', 'e.*')
                ->join('employee_info as e', 'e.id', '=', 'm.patientId')
                ->where('m.date', "LIKE",  $strDate."%")
                ->whereJsonContains('Purpose','Referral')
                ->whereNull('m.deleted_at')
                ->where('e.campus', session('campus'))
                ->get();
  
            return response()->json($search);
        }
      } 
    }
      
    public function recordsforOTCMed(Request $request) {
        $pageConfigs = ['pageHeader' => true];
        $breadcrumbs = [
            ["link" => "/", "name" => "Home"],
            ["name" => "Over-The-Counter Medicine"]
        ];
    
        $role = $request->get('role');
        
        if ($role === 'Student') {
            if ($request->ajax()) {
                $monthSearch = $request->input('monthSearch');
                $year = $request->input('year');
                
                $strDate = $year."-".$monthSearch;
              
                $search = DB::connection('mysql')
                    ->table('medicalrecord as m')
                    ->select('m.*', 's.*')
                    ->join('student_info as s', 's.StudentNo', '=', 'm.patientId')
                    ->where('m.date', "LIKE",  $strDate."%")
                    ->whereJsonContains('Purpose','OTC Medicine')
                    ->whereNull('m.deleted_at')
                    ->where('m.campus', session('campus'))
                    ->get();
      
                return response()->json($search);
            }
    
        }
        elseif ($role === 'Employee') {
            if ($request->ajax()) {
                $monthSearch = $request->input('monthSearch');
                $year = $request->input('year');
                
                $strDate = $year."-".$monthSearch;
              
                $search = DB::table('medicalrecord as m')
                    ->select('m.*', 'e.*')
                    ->join('employee_info as e', 'e.id', '=', 'm.patientId')
                    ->where('m.date', "LIKE",  $strDate."%")
                    ->whereJsonContains('Purpose','OTC Medicine')
                    ->whereNull('m.deleted_at')
                     ->where('e.campus', session('campus'))
                    ->get();
      
                return response()->json($search);
            }
    
        } 
    }
  
    public function recordsforOthers(Request $request) {
        $pageConfigs = ['pageHeader' => true];
        $breadcrumbs = [
            ["link" => "/", "name" => "Home"],
            ["name" => "Other Concern"]
        ];

        $role = $request->get('role');
        
        if ($role === 'Student') {
            if ($request->ajax()) {
                $monthSearch = $request->input('monthSearch');
                $year = $request->input('year');
                
                $strDate = $year."-".$monthSearch;
              
                $search = DB::table('medicalrecord as m')
                    ->select('m.*', 's.*')
                    ->join('student_info as s', 's.StudentNo', '=', 'm.patientId')
                    ->where('m.date', "LIKE",  $strDate."%")
                    ->whereJsonContains('Purpose','Other Concerns')
                    ->whereNull('m.deleted_at')
                    ->where('m.campus', session('campus'))
                    ->get();
      
                return response()->json($search);
            }
        }
        elseif ($role === 'Employee') {
            if ($request->ajax()) {
                $monthSearch = $request->input('monthSearch');
                $year = $request->input('year');
                
                $strDate = $year."-".$monthSearch;
              
                $search = DB::table('medicalrecord as m')
                    ->select('m.*', 'e.*')
                    ->join('employee_info as e', 'e.id', '=', 'm.patientId')
                    ->where('m.date', "LIKE",  $strDate."%")
                    ->whereJsonContains('Purpose','Other Concerns')
                    ->whereNull('m.deleted_at')
                    ->where('m.campus', session('campus'))
                    ->get();
      
                return response()->json($search);
            }
        } 
    }

    
    public function recordsforPhysical(Request $request) {
        $pageConfigs = ['pageHeader' => true];
        $breadcrumbs = [
            ["link" => "/", "name" => "Home"],
            ["name" => "Physical Assessment"]
        ];

        $role = $request->get('role');
    
        if ($role === 'Student') {
            if ($request->ajax()) {
                $monthSearch = $request->input('monthSearch');
                $year = $request->input('year');

                $strDate = $year."-".$monthSearch;
        
                $search = DB::table('medicalrecord as m')
                    ->select('m.*', 's.*')
                    ->join('student_info as s', 's.StudentNo', '=', 'm.patientId')
                    ->where('m.date', "LIKE",  $strDate."%")
                    ->whereJsonContains('Purpose','Physical Assessment')
                    ->whereNull('m.deleted_at')
                    ->where('m.campus', session('campus'))
                    ->get();
    
                return response()->json($search);
            }
        }
        elseif ($role === 'Employee') {
            if ($request->ajax()) {
                $monthSearch = $request->input('monthSearch');
                $year = $request->input('year');

                $strDate = $year."-".$monthSearch;
        
                $search = DB::table('medicalrecord as m')
                    ->select('m.*', 'e.*')
                    ->join('employee_info as e', 'e.id', '=', 'm.patientId')
                    ->where('m.date', "LIKE",  $strDate."%")
                    ->whereJsonContains('Purpose','Physical Assessment')
                    ->whereNull('m.deleted_at')
                    ->where('m.campus', session('campus'))
                    ->get();
    
                return response()->json($search);
            }
        }
    }

    public function RVgeneratePDF(Request $request)
    {
        $year = $request->year;
        $month = $request->monthSearch;
        $monthName = Carbon::create()->month($month)->format('F');
        $date_range = $request->date_range;
        [$start_day, $end_day] = explode('-', $date_range);

        ini_set('max_execution_time', 300);
        ini_set('memory_limit', '1024M');


        $view = DB::table('medicalrecord as m')
            ->select(
                'm.*',
                's.LastName as studentLastName',
                's.FirstName as studentFirstName',
                's.MiddleName as studentMiddleName',
                's.Sex as studentSex', 
                's.accro as studentaccro' ,
                's.StudentYear as studentStudentYear',
                's.brgy as studentbrgy',
                's.city as studentcity',
                's.province as studentprovince',
                'e.LastName as employeeLastName',
                'e.FirstName as employeeFirstName',
                'e.MiddleName as employeeMiddleName',
                'e.Sex as employeeSex',
                'e.EmploymentStatus as employeeEmploymentStatus' ,
                'e.RBarangay as employeeRBarangay',
                'e.citymunDesc as employeecitymunDesc',
                'e.provDesc as employeeprovDesc'
            )
            ->leftJoin('student_info as s', 'm.patientId', '=', 's.StudentNo')
            ->leftJoin('employee_info as e', 'm.patientId', '=', 'e.id')
            ->whereMonth('m.date',$month)
            ->whereYear('m.date',$year)
            ->whereBetween(DB::raw('DAY(m.date)'), [(int)$start_day, (int)$end_day])
            ->orderBy('m.date', 'asc')
            ->orderBy('m.time', 'asc')
            ->whereNull('m.deleted_at')
            ->where('m.campus',session('campus'))
            ->get();


        return Pdf::loadView('pages.medical-record-visit-form',compact('view'))->setPaper('a4', 'landscape')->stream();
    }
    public function WDgeneratePDF(Request $request)
    {
        $role = $request->role;
        $year = $request->year;
        $month = $request->monthSearch;
        $monthName = Carbon::create()->month($month)->format('F');

        if ($role== 'Student'){   
            $response = DB::connection('mysql')->table('medicalrecord')->first();
            $view = DB::connection('mysql')->table('medicalrecord as m')
                ->select('m.date','m.time','m.deleted_at','m.purpose','m.age','m.role',
                    'm.patientId','m.findings','m.recommendation','m.positioncourse',
                    'm.role', 's.FirstName', 's.MiddleName', 's.LastName', 
                    's.Sex', 's.accro' , 's.StudentYear','s.brgy','s.city','s.province')
                ->join('student_info as s', 'm.patientId', '=', 's.StudentNo')
                ->whereJsonContains('Purpose','Wound Dressing')
                ->whereMonth('m.date',$month)
                ->whereYear('m.date',$year)
                ->orderBy('m.date', 'asc')
                ->orderBy('m.time', 'asc')
                ->whereNull('deleted_at')
                ->where('s.campus',session('campus'))
                ->get();

        return Pdf::loadView('pages.medical-wd-form',compact('view','monthName','role'))->setPaper('a4', 'landscape')->stream();
        } elseif ($role== 'Employee'){
            $response = DB::connection('mysql')->table('medicalrecord')->first();
            $view = DB::connection('mysql')->table('medicalrecord as m')
                ->select('m.date','m.time','m.deleted_at','m.purpose','m.age','m.role',
                    'm.patientId','m.findings','m.recommendation','m.positioncourse',
                    'e.FirstName', 'e.MiddleName', 'e.LastName', 'e.Sex', 'e.EmploymentStatus')
                ->join('employee_info as e', 'm.patientId', '=', 'e.id')
                ->whereJsonContains('Purpose','Wound Dressing')
                ->whereMonth('m.date',$month)
                ->whereYear('m.date',$year)
                ->orderBy('m.date', 'asc')
                ->orderBy('m.time', 'asc')
                ->whereNull('deleted_at')
                ->where('e.campus',session('campus'))
                ->get();

        return Pdf::loadView('pages.medical-wd-form',compact('view','monthName','role'))->setPaper('a4', 'landscape')->stream();
        } 
    }
    public function BPgeneratePDF(Request $request)
    {
        $role = $request->role;
        // dd($role);
        $year = $request->year;
        $month = $request->monthSearch;
        $monthName = Carbon::create()->month($month)->format('F');

        if ($role== 'Student'){   
            $response = DB::connection('mysql')->table('medicalrecord')->first();
            $view = DB::connection('mysql')->table('medicalrecord as m')
                ->select('m.date','m.time','m.deleted_at','m.purpose','m.age','m.role',
                    'm.bp', 's.FirstName', 's.MiddleName', 's.LastName',
                    's.Sex', 's.accro' , 's.StudentYear','s.brgy','s.city','s.province')
                ->join('student_info as s', 'm.patientId', '=', 's.StudentNo')
                ->whereJsonContains('m.purpose','Blood Pressure')
                ->whereMonth('m.date',$month)
                ->whereYear('m.date',$year)
                ->orderBy('m.date', 'asc')
                ->orderBy('m.time', 'asc')
                ->whereNull('deleted_at')
                ->where('s.campus',session('campus'))
                ->get();

        return Pdf::loadView('pages.medical-bp-form',compact('view','monthName','role'))->setPaper('a4', 'landscape')->stream();
        } elseif ($role== 'Employee'){
            $response = DB::connection('mysql')->table('medicalrecord')->first();
            $view = DB::connection('mysql')->table('medicalrecord as m')
                ->select('m.date','m.time','m.deleted_at','m.purpose','m.age','m.role','m.bp',
                    'm.patientId','m.findings','m.recommendation', 'e.FirstName',
                    'e.MiddleName', 'e.LastName', 'e.Sex', 'e.EmploymentStatus')
                ->join('employee_info as e', 'm.patientId', '=', 'e.id')
                ->whereJsonContains('m.purpose','Blood Pressure')
                ->whereMonth('m.date',$month)
                ->whereYear('m.date',$year)
                ->orderBy('m.date', 'asc')
                ->orderBy('m.time', 'asc')
                ->whereNull('deleted_at')
                ->where('e.campus',session('campus'))
                ->get();

            return Pdf::loadView('pages.medical-bp-form',compact('view','monthName','role'))->setPaper('a4', 'landscape')->stream();
        } 
    }
    public function PCgeneratePDF(Request $request)
    {
        $role = $request->role;
        $year = $request->year;
        $month = $request->monthSearch;
        $monthName = Carbon::create()->month($month)->format('F');
 
        if ($role== 'Student'){   
            $response = DB::connection('mysql')->table('medicalrecord')->first();
            $view = DB::connection('mysql')->table('medicalrecord as m')
                ->select('m.date','m.time','m.deleted_at','m.purpose','m.age','m.role',
                    'm.patientId','m.findings','m.recommendation','s.FirstName', 's.MiddleName',
                    's.LastName', 's.Sex', 's.accro' , 's.StudentYear','s.brgy','s.city','s.province')
                ->join('student_info as s', 'm.patientId', '=', 's.StudentNo')
                ->whereJsonContains('m.purpose','Provision of Comfort')
                ->whereMonth('m.date',$month)
                ->whereYear('m.date',$year)
                ->orderBy('m.date', 'asc')
                ->orderBy('m.time', 'asc')
                ->whereNull('deleted_at')
                ->where('s.campus',session('campus'))
                ->get();

        return Pdf::loadView('pages.medical-pc-form',compact('view','monthName','role'))->setPaper('a4', 'landscape')->stream();
        } elseif ($role== 'Employee'){
            $response = DB::connection('mysql')->table('medicalrecord')->first();
            $view = DB::connection('mysql')->table('medicalrecord as m')
                ->select('m.date','m.time','m.deleted_at','m.purpose','m.age','m.role',
                    'm.patientId','m.findings','m.recommendation','e.FirstName',
                    'e.MiddleName', 'e.LastName', 'e.Sex', 'e.EmploymentStatus')
                ->join('employee_info as e', 'm.patientId', '=', 'e.id')
                ->whereJsonContains('m.purpose','Provision of Comfort')
                ->whereMonth('m.date',$month)
                ->whereYear('m.date',$year)
                ->orderBy('m.date', 'asc')
                ->orderBy('m.time', 'asc')
                ->whereNull('deleted_at')
                ->where('e.campus',session('campus'))
                ->get();

        return Pdf::loadView('pages.medical-pc-form',compact('view','monthName','role'))->setPaper('a4', 'landscape')->stream();
        } 
    }
    public function MCgeneratePDF(Request $request)
    {
        $role = $request->role;
       
        $date_range = $request->date_range;
        $year = $request->year;
        $month = $request->monthSearch;
        $monthName = Carbon::create()->month($month)->format('F');
        [$start_day, $end_day] = explode('-', $date_range);

        ini_set('max_execution_time', 300);
        ini_set('memory_limit', '1024M');




        if ($role== 'Student'){   

        $view = DB::connection('mysql')->table('medicalrecord as m')
            ->select(
                'm.date', 'm.time', 'm.deleted_at', 'm.purpose', 'm.age', 'm.role',
                'm.temp', 'm.pulse', 'm.res_rate', 'm.bp', 'm.findings','m.reqlabres','m.positioncourse',
                's.FirstName', 's.MiddleName', 's.LastName', 's.Sex', 's.accro',
                's.StudentYear', 's.brgy', 's.city', 's.province'
            )
            ->join('student_info as s', 'm.patientId', '=', 's.StudentNo')
            ->whereJsonContains('m.purpose', 'Issuance of Certificate')
            ->whereMonth('m.date', $month)
            ->whereYear('m.date', $year)
            ->whereBetween(DB::raw('DAY(m.date)'), [(int)$start_day, (int)$end_day])
            ->whereNull('m.deleted_at')
              ->where('m.role',$role)
            ->where('s.campus', session('campus'))
            ->orderBy('m.date', 'asc')
            ->orderBy('m.time', 'asc')
            ->get();


        return Pdf::loadView('pages.medical-mc-form',compact('view','monthName','role'))->setPaper('a4', 'landscape')->stream();
        } elseif ($role== 'Employee'){
            $response = DB::connection('mysql')->table('medicalrecord')->first();
            $view = DB::connection('mysql')->table('medicalrecord as m')
                ->select('m.date','m.time','m.deleted_at','m.purpose','m.age','m.role',
                    'm.temp','m.pulse','m.res_rate','m.bp','m.findings',
                    'e.FirstName', 'e.MiddleName', 'e.LastName',
                    'e.Sex', 'e.EmploymentStatus')
                ->join('employee_info as e', 'm.patientId', '=', 'e.id')
                ->whereJsonContains('m.purpose','Issuance of Certificate')
                ->whereMonth('m.date',$month)
                ->whereYear('m.date',$year)
                ->whereBetween(DB::raw('DAY(m.date)'), [(int)$start_day, (int)$end_day])
                ->where('m.role',$role)
                ->orderBy('m.date', 'asc')
                ->orderBy('m.time', 'asc')
                ->whereNull('m.deleted_at')
                ->where('e.campus',session('campus'))
                ->get();


            return Pdf::loadView('pages.medical-mc-form',compact('view','monthName','role'))->setPaper('a4', 'landscape')->stream();
        } 
    }
    public function RSgeneratePDF(Request $request)
    {
        $role = $request->role;
        $year = $request->year;
        $month = $request->monthSearch;
        $monthName = Carbon::create()->month($month)->format('F');

        if ($role== 'Student'){   
            $response = DB::connection('mysql')->table('medicalrecord')->first();
            $view = DB::connection('mysql')->table('medicalrecord as m')
                ->select('m.date','m.time','m.deleted_at','m.purpose','m.age','m.role',
                    'm.patientId','m.findings','m.recommendation', 's.FirstName',
                    's.MiddleName', 's.LastName', 's.Sex', 's.accro' , 's.StudentYear',
                    'r.referTo','s.brgy','s.city','s.province')
                ->leftjoin('student_info as s', 'm.patientId', '=', 's.StudentNo')
                ->leftjoin('referral as r', 'r.patientId', '=', 's.StudentNo')
                ->whereJsonContains('m.purpose','Referral')
                ->whereMonth('m.date',$month)
                ->whereYear('m.date',$year)
                ->orderBy('m.date', 'asc')
                ->orderBy('m.time', 'asc')
                ->whereNull('m.deleted_at')
                ->where('s.campus',session('campus'))
                ->get();

        return Pdf::loadView('pages.medical-rs-form',compact('view','monthName','role'))->setPaper('a4', 'landscape')->stream();
        } elseif ($role== 'Employee'){
            $response = DB::connection('mysql')->table('medicalrecord')->first();
            $view = DB::connection('mysql')->table('medicalrecord as m')
                ->select('m.date','m.time','m.deleted_at','m.purpose','m.age','m.role',
                    'm.patientId','m.findings','m.recommendation','e.FirstName',
                    'e.MiddleName', 'e.LastName', 'e.Sex', 'e.EmploymentStatus','r.referTo')
                ->leftjoin('employee_info as e', 'm.patientId', '=', 'e.id')
                ->leftjoin('referral as r', 'r.patientId', '=', 'e.id')
                ->whereJsonContains('m.purpose','=','Referral')
                ->whereMonth('m.date',$month)
                ->whereYear('m.date',$year)
                ->orderBy('m.date', 'asc')
                ->orderBy('m.time', 'asc')
                ->whereNull('m.deleted_at')
                ->where('e.campus',session('campus'))
                ->get();

        return Pdf::loadView('pages.medical-rs-form',compact('view','monthName','role'))->setPaper('a4', 'landscape')->stream();
        } 
    }
    public function OTCgeneratePDF(Request $request)
    {
        $role = $request->role;
        $year = $request->year;
        $month = $request->monthSearch;
        $monthName = Carbon::create()->month($month)->format('F');

        if ($role== 'Student'){   
            $response = DB::connection('mysql')->table('medicalrecord')->first();
            $view = DB::connection('mysql')->table('medicalrecord as m')
                ->select('m.date','m.time','m.deleted_at','m.purpose','m.age','m.role',
                    'm.patientId','m.findings','m.recommendation','m.OTCmedDescript','m.OTCmedpcs',
                    's.FirstName', 's.MiddleName', 's.LastName', 's.Sex', 's.accro' ,
                    's.StudentYear','s.brgy','s.city','s.province')
                ->join('student_info as s', 'm.patientId', '=', 's.StudentNo')
                ->whereJsonContains('m.purpose','OTC Medicine')
                ->whereMonth('m.date',$month)
                ->whereYear('m.date',$year)
                ->orderBy('m.date', 'asc')
                ->orderBy('m.time', 'asc')
                ->whereNull('m.deleted_at')
                ->where('s.campus',session('campus'))
                ->get();

        return Pdf::loadView('pages.medical-OTC-form',compact('view','monthName','role'))->setPaper('a4', 'landscape')->stream();
        } elseif ($role== 'Employee'){
            $response = DB::connection('mysql')->table('medicalrecord')->first();
            $view = DB::connection('mysql')->table('medicalrecord as m')
                ->select('m.date','m.time','m.deleted_at','m.purpose','m.age','m.role',
                    'm.patientId','m.findings','m.recommendation','m.OTCmedDescript','m.OTCmedpcs',
                    'e.FirstName', 'e.MiddleName', 'e.LastName', 'e.Sex', 'e.EmploymentStatus')
                ->join('employee_info as e', 'm.patientId', '=', 'e.id')
                ->whereJsonContains('m.purpose','OTC Medicine')
                ->whereMonth('m.date',$month)
                ->whereYear('m.date',$year)
                ->orderBy('m.date', 'asc')
                ->orderBy('m.time', 'asc')
                ->whereNull('m.deleted_at')
                ->where('e.campus',session('campus'))
                ->get();

        return Pdf::loadView('pages.medical-OTC-form',compact('view','monthName','role'))->setPaper('a4', 'landscape')->stream();
        } 
    }
    public function OCgeneratePDF(Request $request)
    {
        $role = $request->role;
        $year = $request->year;
        $month = $request->monthSearch;
        $monthName = Carbon::create()->month($month)->format('F');

        if ($role== 'Student'){   
            $response = DB::connection('mysql')->table('medicalrecord')->first();
            $view = DB::connection('mysql')->table('medicalrecord as m')
                ->select('m.date','m.time','m.deleted_at','m.purpose','m.age','m.role',
                    'm.patientId','m.findings','m.recommendation', 's.FirstName', 
                    's.MiddleName', 's.LastName', 's.Sex', 's.accro' , 's.StudentYear','s.brgy','s.city','s.province')
                ->join('student_info as s', 'm.patientId', '=', 's.StudentNo')
                ->whereJsonContains('m.purpose','Other Concerns')
                ->whereMonth('m.date',$month)
                ->whereYear('m.date',$year)
                ->orderBy('m.date', 'asc')
                ->orderBy('m.time', 'asc')
                ->whereNull('m.deleted_at')
                ->where('s.campus',session('campus'))
                ->get();

        return Pdf::loadView('pages.medical-oc-form',compact('view','monthName','role'))->setPaper('a4', 'landscape')->stream();
        } elseif ($role== 'Employee'){
            $response = DB::connection('mysql')->table('medicalrecord')->first();
            $view = DB::connection('mysql')
                    ->table('medicalrecord as m')
                    ->select(
                        'm.date','m.time','m.deleted_at','m.purpose','m.age','m.role',
                        'm.patientId','m.findings','m.recommendation',
                        'e.FirstName','e.MiddleName','e.LastName','e.Sex','e.EmploymentStatus'
                    )
                    ->join('employee_info as e', 'm.patientId', '=', 'e.id')
                    ->whereJsonContains('m.purpose', 'Other Concerns')
                    ->whereMonth('m.date', $month)
                    ->whereYear('m.date', $year)
                    ->whereNull('m.deleted_at')
                    ->where('e.campus', session('campus'))
                    ->orderBy('m.date', 'asc')
                    ->orderBy('m.time', 'asc')
                    ->get();

        return Pdf::loadView('pages.medical-oc-form',compact('view','monthName','role'))->setPaper('a4', 'landscape')->stream();
        } 
    }


#DENTAL LOGBOOK
    public function checkup(Request $request){

        $pageConfigs = ['pageHeader' => true];
        $breadcrumbs = [
          ["link" => "/", "name" => "Home"],["name" => "Consultation"]
        ];
        $today = Carbon::today();
        $year = $today -> year;
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
            12 => 'December'];
        $month = $monthNames[$monthNumber];

        $checkup = DB::connection('mysql')
            ->table('treatmentrecord as t')
            ->select('t.*','d.id','d.lastname','d.firstname','d.middlename','d.birthdate','d.poscourse')
            ->join('dentalchart as d','d.id','=','t.patientId')
            ->whereMonth('t.date', $monthNumber)
            ->whereYear('t.date', $year)
            ->where('t.remarks', 'LIKE', '%"Consultation"%')
            ->where('t.campus',session('campus'))
            ->get();
      

        return view('pages.records-of-checkup',['pageConfigs'=>$pageConfigs,'breadcrumbs'=>$breadcrumbs],
        compact('checkup','month'));
    } 
    public function recordsforcheckup(Request $request) {
        $pageConfigs = ['pageHeader' => true];
        $breadcrumbs = [
            ["link" => "/", "name" => "Home"],
            ["name" => "Patient Records"]
        ];

            if ($request->ajax()) {
                $monthSearch = $request->input('monthSearch');
                $year = $request->input('year');
                 
                $strDate = $year."-".$monthSearch;
              
                $search = DB::connection('mysql')
                    ->table('treatmentrecord as t')
                    ->select('t.*','d.id','d.lastname','d.firstname','d.middlename','d.birthdate','d.poscourse')
                    ->join('dentalchart as d','d.id','=','t.patientId')
                    ->where('t.remarks', 'LIKE', '%"Consultation"%')
                    ->where('t.date', "LIKE",  $strDate."%")
                    ->whereNull('t.deleted_at')
                    ->where('t.campus',session('campus'))
                    ->get();
    
                return response()->json($search);
            }
    }
    public function cleaning(Request $request){

        $pageConfigs = ['pageHeader' => true];
        $breadcrumbs = [
          ["link" => "/", "name" => "Home"],["name" => "Patient Records"]
        ];
        $today = Carbon::today();
        $year = $today -> year;
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
            12 => 'December'];
        $month = $monthNames[$monthNumber];
       
        $cleaning = DB::connection('mysql')
            ->table('treatmentrecord as t')
            ->select('t.*','d.id','d.lastname','d.firstname','d.middlename','d.birthdate','d.poscourse')
            ->join('dentalchart as d','d.id','=','t.patientId')
            ->whereMonth('t.date', $monthNumber)
            ->whereYear('t.date', $year)
            ->where('t.remarks', 'LIKE', '%"Oral Prophylaxis"%')
            ->where('t.campus',session('campus'))
            ->get();

        return view('pages.records-of-oralprophylaxis',['pageConfigs'=>$pageConfigs,'breadcrumbs'=>$breadcrumbs],
        compact('cleaning','month'));
    } 
    public function recordsforcleaning(Request $request) {
        $pageConfigs = ['pageHeader' => true];
        $breadcrumbs = [
            ["link" => "/", "name" => "Home"],
            ["name" => "Patient Records"]
        ];
        
            if ($request->ajax()) {
                $monthSearch = $request->input('monthSearch');
                $year = $request->input('year');
                 
                $strDate = $year."-".$monthSearch;
              
                $search = DB::connection('mysql')
                    ->table('treatmentrecord as t')
                    ->select('t.*','d.id','d.lastname','d.firstname','d.middlename','d.birthdate','d.poscourse')
                    ->join('dentalchart as d','d.id','=','t.patientId')
                    ->where('t.remarks', 'LIKE', '%"Oral Prophylaxis"%')
                    ->where('t.date', "LIKE",  $strDate."%")
                    ->whereNull('t.deleted_at')
                    ->where('t.campus',session('campus'))
                    ->get();
    
                return response()->json($search);
            }
    }
    public function pasta(Request $request){

        $pageConfigs = ['pageHeader' => true];
        $breadcrumbs = [
          ["link" => "/", "name" => "Home"],["name" => "Patient Records"]
        ];
        $today = Carbon::today();
        $year = $today -> year;
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
            12 => 'December'];
        $month = $monthNames[$monthNumber];
       
        $pasta = DB::connection('mysql')
            ->table('treatmentrecord as t')
            ->select('t.*','d.id','d.lastname','d.firstname','d.middlename','d.birthdate','d.poscourse')
            ->join('dentalchart as d','d.id','=','t.patientId')
            ->whereMonth('t.date', $monthNumber)
            ->whereYear('t.date', $year)
            ->where('t.remarks', 'LIKE', '%"Oral Restoration"%')
            ->where('t.campus',session('campus'))
            ->get();

        return view('pages.records-of-cavityfilling',['pageConfigs'=>$pageConfigs,'breadcrumbs'=>$breadcrumbs],
        compact('pasta','month'));
    } 
    public function recordsforpasta(Request $request) {
        $pageConfigs = ['pageHeader' => true];
        $breadcrumbs = [
            ["link" => "/", "name" => "Home"],
            ["name" => "Patient Records"]
        ];

        if ($request->ajax()) {
            $monthSearch = $request->input('monthSearch');
            $year = $request->input('year');
                
            $strDate = $year."-".$monthSearch;
            
            $search = DB::connection('mysql')
                ->table('treatmentrecord as t')
                ->select('t.*','d.id','d.lastname','d.firstname','d.middlename','d.birthdate','d.poscourse')
                ->join('dentalchart as d','d.id','=','t.patientId')
                ->where('t.remarks', 'LIKE', '%"Oral Restoration"%')
                ->where('t.date', "LIKE",  $strDate."%")
                ->whereNull('t.deleted_at')
                ->where('t.campus',session('campus'))
                ->get();

            return response()->json($search);
        }
    }
    public function extraction(Request $request){

        $pageConfigs = ['pageHeader' => true];
        $breadcrumbs = [
          ["link" => "/", "name" => "Home"],["name" => "Patient Records"]
        ];
        $today = Carbon::today();
        $year = $today -> year;
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
            12 => 'December'];
        $month = $monthNames[$monthNumber];
       
        $extraction = DB::connection('mysql')
            ->table('treatmentrecord as t')
            ->select('t.*','d.id','d.lastname','d.firstname','d.middlename','d.birthdate','d.poscourse')
            ->join('dentalchart as d','d.id','=','t.patientId')
            ->whereMonth('t.date', $monthNumber)
            ->whereYear('t.date', $year)
            ->where('t.remarks', 'LIKE', '%"Tooth Extraction"%')
            ->where('t.campus',session('campus'))
            ->get();

        return view('pages.records-of-toothextraction',['pageConfigs'=>$pageConfigs,'breadcrumbs'=>$breadcrumbs],
        compact('extraction','month'));
    } 
    public function recordsforextraction(Request $request) {
        $pageConfigs = ['pageHeader' => true];
        $breadcrumbs = [
            ["link" => "/", "name" => "Home"],
            ["name" => "Patient Records"]
        ];

        if ($request->ajax()) {
            $monthSearch = $request->input('monthSearch');
            $year = $request->input('year');
                
            $strDate = $year."-".$monthSearch;
            
            $search = DB::connection('mysql')
                ->table('treatmentrecord as t')
                ->select('t.*','d.id','d.lastname','d.firstname','d.middlename','d.birthdate','d.poscourse')
                ->join('dentalchart as d','d.id','=','t.patientId')
                ->where('t.remarks', 'LIKE', '%"Tooth Extraction"%')
                ->where('t.date', "LIKE",  $strDate."%")
                ->whereNull('t.deleted_at')
                ->where('t.campus',session('campus'))
                ->get();

            return response()->json($search);
        }
    }
     public function OTCdental(Request $request){

        $pageConfigs = ['pageHeader' => true];
        $breadcrumbs = [
          ["link" => "/", "name" => "Home"],["name" => "Patient Records"]
        ];
        $today = Carbon::today();
        $year = $today -> year;
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
            12 => 'December'];
        $month = $monthNames[$monthNumber];
       
        $otcdentalS = DB::connection('mysql')
            ->table('treatmentrecord as t')
            ->select('t.*','o.*','d.id','d.lastname','d.firstname','d.middlename','d.birthdate','d.poscourse')
            ->leftjoin('dentalchart as d','d.id','=','t.patientId')
            ->leftjoin('otc_medicine as o','o.patientId','=','t.patientId')
            ->where('o.role','Student')
            ->whereMonth('t.date', $monthNumber)
            ->whereYear('t.date', $year)
            ->where('t.campus',session('campus'))
            ->get();

        $otcdentalE = DB::connection('mysql')
            ->table('treatmentrecord as t')
            ->select('t.*','o.*','d.id','d.lastname','d.firstname','d.middlename','d.birthdate','d.poscourse')
            ->leftjoin('dentalchart as d','d.id','=','t.patientId')
            ->leftjoin('otc_medicine as o','o.patientId','=','t.patientId')
            ->where('o.role','Employee')
            ->whereMonth('t.date', $monthNumber)
            ->whereYear('t.date', $year)
            ->where('t.campus',session('campus'))
            ->get();

        return view('pages.dental-OTC-medicine',['pageConfigs'=>$pageConfigs,'breadcrumbs'=>$breadcrumbs],
        compact('otcdentalS','otcdentalE','month'));
    } 
    public function recordsOTCdental(Request $request) {
        $pageConfigs = ['pageHeader' => true];
        $breadcrumbs = [
            ["link" => "/", "name" => "Home"],
            ["name" => "Patient Records"]
        ];

        if ($request->ajax()) {
            $monthSearch = $request->input('monthSearch');
            $year = $request->input('year');
                
            $strDate = $year."-".$monthSearch;
            
            $search = DB::connection('mysql')
                ->table('treatmentrecord as t')
                ->select('t.*','o.*','d.id','d.lastname','d.firstname','d.middlename','d.birthdate','d.poscourse')
                ->join('dentalchart as d','d.id','=','t.patientId')
                ->where('t.remarks', 'LIKE', '%"Tooth Extraction"%')
                ->where('t.date', "LIKE",  $strDate."%")
                ->whereNull('t.deleted_at')
                ->where('t.campus',session('campus'))
                ->get();

            return response()->json($search);
        }
    }
    public function totalMedical(Request $request){
      
        $pageConfigs = ['pageHeader' => true];
        $breadcrumbs = [
          ["link" => "/", "name" => "Home"],["name" => "Overall Total Patient"]
        ];

        return view('pages.medical-total-patient',['pageConfigs'=>$pageConfigs,'breadcrumbs'=>$breadcrumbs]);
    }
    public function displaytotalMedical(Request $request) {
        $year = $request->input('year');
        $months = [
            'January', 'February', 'March', 'April', 'May', 'June', 
            'July', 'August', 'September', 'October', 'November', 'December',
        ];
    
        $studentCount = [];
        $employeeCount = [];
        $totalCount = [];
        $overAllTotal = [];
    
        foreach (range(1, 12) as $monthIndex) {
            $studentCount[] = DB::connection('mysql')->table('medicalrecord')
                ->where('role', 'Student')
                ->whereYear('date', $year)
                ->whereMonth('date', $monthIndex)
                ->where('campus', session('campus'))
                ->whereNull('deleted_at')
                ->count();
    
            $employeeCount[] = DB::connection('mysql')->table('medicalrecord')
                ->where('role', 'Employee')
                ->whereYear('date', $year)
                ->whereMonth('date', $monthIndex)
                ->where('campus', session('campus'))
                ->whereNull('deleted_at')
                ->count();

            $totalCount[] = DB::connection('mysql')->table('medicalrecord')
                ->whereYear('date', $year)
                ->whereMonth('date', $monthIndex)
                ->where('campus', session('campus'))
                ->whereNull('deleted_at')
                ->count();
        }

       $overAllTotal = array_sum($studentCount) + array_sum($employeeCount);
        
        return response()->json([
            'studentCount' => $studentCount,
            'employeeCount' => $employeeCount,
            'totalCount' => $totalCount,
            'month' => $months,
            'overAllTotal' => $overAllTotal,
        ]);
    }

  public function indexBorrow(Request $request){

        $pageConfigs = ['pageHeader' => true];
        $breadcrumbs = [
          ["link" => "/", "name" => "Home"],["name" => "Patient Records"]
        ];

        $data = DB::connection('mysql')->table('borrowslip')
           ->whereNull('deleted_at')
           ->whereNull('returned_at')
           ->where('campus',session('campus'))
           ->get();

        return view('pages.borrow-slip',['pageConfigs'=>$pageConfigs,'breadcrumbs'=>$breadcrumbs],compact('data'));
    } 

    public function borrowSearch(Request $request){ 
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
      $employee->encryptedEmployeeNo = $this->aes->encrypt($employee->id);
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
// BORROW SLIP END
    public function borrowSlip(Request $request){

        $pageConfigs = ['pageHeader' => true];
        $breadcrumbs = [
          ["link" => "/", "name" => "Home"],["name" => "Borrowed Item"]
        ];
         $role = $request->get('role');

         if ($role === 'Student') {  
            $data =  Student::where('StudentNo', $this->aes->decrypt($request->id))->where('campus', session('campus'))->first();
         }
         else if ($role === 'Employee') {    
            $data =  Employee::where('id', $this->aes->decrypt($request->id))->where('campus', session('campus'))->first();
          }

           $id = $this->aes->decrypt($request->id);

           $items = DB::connection('mysql')->table('borrowslip')
                ->where('patientId',$this->aes->decrypt($request->id))
                ->whereNull('deleted_at')
                ->get();

        return view('pages.borrow-slip-view',['pageConfigs'=>$pageConfigs,'breadcrumbs'=>$breadcrumbs],compact('data','id','items'));
    } 

    public function saveBorrow(Request $request){

        $save = DB::table('borrowslip')
          ->insert([
            'patientId' => $request->patientId,
            'contact' => $request->contact,
            'item' => json_encode($request->item),
            'borrowed_date' => $request->borrowed_date,
            'borrowed_time' => $request->borrowed_time,
            'campus' => session('campus'),
            'created_at' => Carbon::now('Asia/Manila')
          ]);

        return response()->json([
            'status' => 200,
            'success' => 'Saved Successfully!'
        ]);
    } 
    public function borrowModal(Request $request){

        $modal = DB::table('borrowslip')
            ->where('id',$request->id)
            ->where('campus',session('campus'))
            ->first();

        return response()->json( $modal);
    } 
    public function returnedBorrow(Request $request){

        $save = DB::table('borrowslip')
          ->where('id',$request->id)
          ->where('campus',session('campus'))
          ->update([ 
            'returned_date' => $request->returned_date,
            'returned_time' => $request->returned_time,
            'received_by' => session('firstname') . ' ' . session('lastname'),
            'returned_at' => Carbon::now('Asia/Manila')
          ]);

        return response()->json([
            'status' => 200,
            'success' => 'Returned Successfully!'
        ]);
    } 
    public function editModal(Request $request){

        $modal = DB::table('borrowslip')
            ->where('id',$request->id)
            ->where('campus',session('campus'))
            ->first();

        return response()->json( $modal);
    } 
    public function updateModal(Request $request){

        $save = DB::table('borrowslip')
          ->where('id',$request->id)
          ->where('campus',session('campus'))
          ->update([
            'item' => json_encode($request->item),
            'borrowed_date' => $request->borrowed_date,
            'borrowed_time' => $request->borrowed_time,
            'returned_date' => $request->returned_date,
            'returned_time' => $request->returned_time,
            'updated_at' => Carbon::now('Asia/Manila')
          ]);

        return response()->json([
            'status' => 200,
            'success' => 'Updated Successfully!'
        ]);
    } 
     public function deleteBorrow(Request $request){

        $delete = DB::table('borrowslip')
            ->where('id',$request->id)
            ->where('campus',session('campus'))
            ->update([
                 'deleted_at' => Carbon::now('Asia/Manila')
            ]);
            
            
        return response()->json([
            'status' => 200,
            'message' => 'Deleted successfully!'
        ]);
    } 
}

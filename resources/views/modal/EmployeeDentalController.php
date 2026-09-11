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
use\App\Providers;
use Carbon\Carbon;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use App\Http\Controllers\AESCipher;

class EmployeeDentalController extends Controller
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

    //   $data = DB::table('employee_info')->get('AgencyNumber');

      return view('pages.employee-dental-record',['pageConfigs'=>$pageConfigs,'breadcrumbs'=>$breadcrumbs]);
    }
    public function dentalChart(Request $request){
        
        $pageConfigs = ['pageHeader' => true];
        $breadcrumbs = [
            ["link" => "/", "name" => "Home"],
            ["link" => "/search-dental-record", "name" => "Search"], 
            ["name" => "Dental Record Chart"]
        ];
       
        $record = DB::table('employee_info')->where('AgencyNumber', $this->aes->decrypt($request->id))->where('campus',session('campus'))->first();
        $dentalchart = DB::table('dentalchart')->where('id', $this->aes->decrypt($request->id))->where('campus',session('campus'))->first();
       
            if ($dentalchart === null) {
                
                $record = DB::connection('hrmis')
                        ->table('employee as e')
                        ->select('e.*','d.DepartmentName','rc.citymunDesc','rp.provDesc' )
                        ->leftJoin('department as d', 'd.id', '=', 'e.Department')
                        ->leftJoin('refcitymun as rc', 'rc.id', '=', 'e.rcitymun')
                        ->leftJoin('refprovince as rp', 'rp.id', '=', 'e.rprovince')
                        ->where('e.id',$this->aes->decrypt($request->id))
                        ->where('e.Campus',session('campus'))
                        ->whereNull('e.deleted_at') 
                        ->first();
                        
                $newencryptedId = $request->id;

                $today = Carbon::today();
                $dateofbirth =$this->aes->decrypt($record->DateOfBirth);
               
                $age = $today->diff($dateofbirth)->y;

                return view('pages.employee-dental-chart', ['pageConfigs' => $pageConfigs,'breadcrumbs' => $breadcrumbs], compact('record','dateofbirth','age','dentalchart'));
    
            } else if($dentalchart !== null) {

                // dd( $this->aes->decrypt($request->id));

                $details = DB::table('dentalchart')->where('id', $this->aes->decrypt($request->id))->where('campus',session('campus'))->first();
                $record = DB::table('employee_info')->where('id', $this->aes->decrypt($request->id))->where('campus',session('campus'))->first();

                $issueDetails = json_decode($details->dental_issues,true);
                $newencryptedId = $request->id;
            
                $today = Carbon::today();
                $dateofbirth =$record->DateOfBirth;
                $age = $today->diff($dateofbirth)->y;

                return view('pages.employee-dental-chart', ['pageConfigs' => $pageConfigs,'breadcrumbs' => $breadcrumbs], compact('record','dentalchart','newencryptedId','details','issueDetails','age'));
            }
            return back();

    }
    public function treatmentRecord(Request $request){
        $pageConfigs = ['pageHeader' => true];
        $breadcrumbs = [
            ["link" => "/", "name" => "Home"],
            ["link" => "/search-dental-record", "name" => "Search"], 
            ["link" => "/dental-record-chart", "name" => "Dental Record Chart"], 
            ["name" => "Treatment Record"]
        ];
     
        $details = DB::table('dentalchart')
            ->where('id', $request->id)
            ->where('campus', session('campus'))
            ->first();

        $issue = json_decode($details->dental_issues,true);
            
        return view('pages.dental-treatment-record', ['data' => $details,'issueDetails' => $issue,'pageConfigs' => $pageConfigs,'breadcrumbs' => $breadcrumbs]);
    }
    public function search(Request $request){ 

        $result =DB::connection('hrmis')
            ->table('employee')
            ->where(function ($query) use ($request) {
                $query->where('AgencyNumber', 'like', '%' . $request->search . '%')
                    ->orWhere('LastName', 'LIKE', '%' . $request->search . '%')
                    ->('FirstName', 'LIKE', '%' . $request->search . '%')
                    ->orWhere('MiddleName', 'LIKE', '%' . $request->search . '%');
            })
            ->where('Campus',session('campus'))
            ->whereNull('deleted_at')
            ->distinct()
            ->get();
    
            $encryptedResults = $result->map(function ($employee) {
                $employee->encryptedEmployeeNo = $this->aes->encrypt($employee->id);
            return $employee;
        });
      
        
        return response()->json($encryptedResults);        
    }
    public function viewChart(Request $request) {

        $response = DB::table('employee_info as s')
            ->leftJoin('dentalchart as d', 'd.patientId', '=', 's.empNo')
            ->select('d.*', 's.*')
            ->where('s.iempNod', $request->id)
            ->where('d.campus', session('campus'))
            ->first();


        if ($response) {
              if ($response->id) {
                  return response()->json($response);
              } else {
                  $employee = [
                      'id' => $response->empNo,
                      'last_name' => $response->lastname,
                      'middle_name' => $response->middlename,
                      'first_name' => $response->lastname, 
                  ];
                  return response()->json($employee);
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

        // dd($request->id);

        $patientId =$request->id;

        
        $found = DB::table('dentalchart')   
            ->where('id',$patientId)
            ->where('campus',session('campus'))
            ->first();

        $issues = $request->input('dental_issues');
        $filteredIssues = array_filter($issues, function ($value) {
            return $value !== null;
        });

        if ($found) {
            $update = DB::table('dentalchart')
            ->where('id',$patientId)
            ->update([ 
                'campus' => session('campus'),
                'dental_issues' => json_encode($filteredIssues),
                'periodontal' => json_encode($request->periodontal),
                'occlusion' => json_encode($request->occlusion),
                'appliances' => json_encode($request->appliances),
                'tmd' => json_encode($request->tmd),
                'othersApp' => $request->othersApp,
                'date' => $request->date,
                'updated_at' => Carbon::now('Asia/Manila'),
             ]);

             DB::table('appointment')->where('id', $request->appointmentId)->where('patientId', $request->patientId)
               ->update([ 
                'status' => $request->status,
             ]);
    
             $newId = DB::table('dentalchart')->where('id', $request->id)->where('campus', session('campus'))->latest('id')->first();
             
             return response()->json(['newId' => $this->aes->encrypt($newId->id),'status' => 200,'success'   => 'Updated Successfully!']);
        } else if (empty($found)) {

            $check = DB::table('employee_info')
                    ->where('id',$request->id)
                    ->where('campus',session('campus'))
                    ->exists();

                 
             if (empty($check)) {
                DB::table('employee_info')
                ->insert([
                    'campus' => session('campus'),
                    'id' => $request->id,
                    'AgencyNumber' => $patientId,
                    'EmploymentStatus' =>$request->EmploymentStatus,
                    'DepartmentName' =>$request->DepartmentName,
                    'LastName' =>$request->LastName,
                    'FirstName' => $request->FirstName,
                    'MiddleName' => $request->MiddleName,
                    'Sex' => $request->Sex,
                    'DateOfBirth' => $request->DateOfBirth, 
                    'Cellphone' => $request->Cellphone,
                    'RBarangay' => $request->RBarangay,
                    'citymunDesc' =>$request->citymunDesc,
                    'provDesc' => $request->provDesc,
                    'CivilStatus' =>$request->CivilStatus,
                    'Citizenship' => $request->Citizenship,
                    'EmailAddress' => $request->EmailAddress,
                    'created_at' =>  Carbon::now('Asia/Manila')
                ]);

                DB::table('dentalchart')->insert([ 
                'campus' => session('campus'),
                'id' => $patientId,
                'lastname' => $request->LastName,
                'firstname' => $request->FirstName,
                'middlename' => $request->MiddleName,
                'role' => $request->role,
                'poscourse' => $request->poscourse,
                'birthdate' => $request->DateOfBirth,
                'gender' => $request->Sex,
                'dental_issues' => json_encode($filteredIssues),
                'periodontal' => json_encode($request->periodontal),
                'occlusion' => json_encode($request->occlusion),
                'appliances' => json_encode($request->appliances),
                'tmd' => json_encode($request->tmd),
                'othersApp' => $request->othersApp,
                'date' => $request->date,
                'created_at' => Carbon::now('Asia/Manila'),
                'updated_at' => null,
             ]);
             } else{
                DB::table('dentalchart')->insert([ 
                    'campus' => session('campus'),
                    'id' => $patientId,
                    'lastname' => $request->LastName,
                    'firstname' => $request->FirstName,
                    'middlename' => $request->MiddleName,
                    'role' => $request->role,
                    'poscourse' => $request->poscourse,
                    'birthdate' => $request->DateOfBirth,
                    'gender' => $request->Sex,
                    'dental_issues' => json_encode($filteredIssues),
                    'periodontal' => json_encode($request->periodontal),
                    'occlusion' => json_encode($request->occlusion),
                    'appliances' => json_encode($request->appliances),
                    'tmd' => json_encode($request->tmd),
                    'othersApp' => $request->othersApp,
                    'date' => $request->date,
                    'created_at' => Carbon::now('Asia/Manila'),
                    'updated_at' => null,
                ]);
             }

            DB::table('appointment')
                ->where('id', $request->appointmentId)
                ->where('patientId', $request->patientId)
                ->update([ 
                    'status' => $request->status,
                ]);
    
             $newId = DB::table('dentalchart')->where('id', $request->patientId)->latest('id')->where('campus', session('campus'))->first();

             return response()->json(['newId' => $this->aes->encrypt($newId->id),'status' => 200,'success'   => 'Added Successfully!']);
        }
    }
    public function treatment (Request $request){

        $save=DB::table('dentalchart')
        ->where('id',$request->id)
        ->update([ 
            'treatment' => $request->treatment,
            'diagnosis' =>$request->treatment,
         ]);

         return response()->json(['status' => 200,'success'   => 'Saved Successfully!']);
    }
    public function update(Request $request){
        $existingRecord = DB::table('dentalchart')->latest('id')->where('campus',session('campus'))->first();

        if ($existingRecord) {
            $counter = intval(substr($existingRecord->id, strlen('D-'))) + 1;
            $newId = 'D-' . $counter;
        } else {
            $newId = 'D-1';
        }
            try {
                $condition = json_encode($request->condition);
                $restoration =json_encode($request->restoration);
                $surgery =json_encode($request->surgery);
                $others =json_encode($request->others);
                $periodontal =json_encode($request->periodontal);
                $occlusion =json_encode($request->occlusion);
                $appliances =json_encode($request->appliances);
                $tmd =json_encode($request->tmd);
                $found = DB::table('dentalchart')
                ->where('id',$request->patientId)
                ->first();
            
            if ($found) {
                $update = DB::table('dentalchart')
                    ->where('id',$request->id)
                    ->update([
                        'diagnosis' => $request->diagnosis,
                        'treatment' =>$request->treatment,
                        'teethId' =>$request->teethId,
                        'condition' => $condition,
                        'restoration' => $restoration,
                        'surgery' => $surgery,
                        'others' => $others,
                        'periodontal' => $periodontal,
                        'occlusion' => $occlusion,
                        'appliances' => $appliances,
                        'tmd' => $tmd,
                        'others_app' => $request->others_app,
                        'date' =>   $request->date,
                        'updated_at' =>  Carbon::now('Asia/Manila')->toDateTimeString()
                    ]);
            return response()->json([
                   'status' => 200,
                    'success'   => 'Updated Successfully!'
            ]);
            } else {
                DB::table('dentalchart')
                    ->insert([
                        'id' => $newId,
                        'campus' => session('campus'),
                        'patientId' => $request->patientId,
                        'diagnosis' => $request->diagnosis,
                        'treatment' =>$request->treatment,
                        'teethId' =>$request->teethId,
                        'condition' => $condition,
                        'restoration' => $restoration,
                        'surgery' => $surgery,
                        'others' => $others,
                        'periodontal' => $periodontal,
                        'occlusion' => $occlusion,
                        'appliances' => $appliances,
                        'tmd' => $tmd,
                        'others_app' => $request->others_app,
                        'date' =>   $request->date ,
                        'created_at' =>  Carbon::now('Asia/Manila')->toDateTimeString()
                    ]);
                      
            return response()->json(['status' => 200,'success'   => 'Saved Successfully!']);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'error'   => $e->getMessage()
            ]);
        }  
    }            
}

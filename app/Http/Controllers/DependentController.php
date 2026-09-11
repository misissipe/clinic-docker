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

class DependentController extends Controller
{
    protected $aes;
    public function __construct(){
        $this->aes = new AESCipher;
    }
    public function index(){
        $pageConfigs = ['pageHeader' => true];
        $breadcrumbs = [
          ["link" => "/", "name" => "Home"],["name" => "Dependent"]
        ];
        // $appointments = DB::table('appointment'); 

        return view('pages.dependent-dental-record',['pageConfigs'=>$pageConfigs,'breadcrumbs'=>$breadcrumbs]);
    }

    public function dependentChart(Request $request){
        $pageConfigs = ['pageHeader' => true];
        $breadcrumbs = [
            ["link" => "/", "name" => "Home"],
            ["link" => "/search-dental-record", "name" => "Dependent"], 
            ["name" => "Dental Record Chart"]
        ];
       
        $record = DB::table('dependent_info')->where('id', $this->aes->decrypt($request->id))->where('campus',session('campus'))->first();
        $dentalchart = DB::table('dentalchart')->where('id', $this->aes->decrypt($request->id))->where('role',$request->role)->where('campus',session('campus'))->first();
      
            if ($dentalchart === null) {
                $record = DB::table('dependent_info')->where('id', $this->aes->decrypt($request->id))->first();
               
                $newencryptedId = $request->id;
          
                $today = Carbon::today();
                $dateofbirth =$record->BirthDate;
                $age = $today->diff($dateofbirth)->y;

                return view('pages.new-dependent-dental-record', [
                    'pageConfigs' => $pageConfigs,
                    'breadcrumbs' => $breadcrumbs
                ], compact('record','dentalchart','newencryptedId', 'age'));
    
            } else if($dentalchart !== null) {
                
                $details = DB::table('dentalchart')->where('role','=','Dependent')->where('id', $this->aes->decrypt($request->id))->where('campus',session('campus'))->first();
                // dd($details);

                $issueDetails = json_decode($details->dental_issues,true);

                $today = Carbon::today();
                $dateofbirth =$record->BirthDate;
                $age = $today->diff($dateofbirth)->y;

                $newStudent = DB::table('dependent_info')->where('id', $record->id)->where('campus',session('campus'))->first();
               
                $newencryptedId = $request->id;
                
                return view('pages.new-dependent-dental-record', [
                    'pageConfigs' => $pageConfigs,
                    'breadcrumbs' => $breadcrumbs
                ], compact('record', 'newStudent','dentalchart','newencryptedId','details','issueDetails', 'age'));
            }
  
            return back();
    }
    public function add(Request $request){
        $pageConfigs = ['pageHeader' => true]; 
        $breadcrumbs = [
          ["link" => "/", "name" => "Home"],["name" => "Dependent"]
        ];
        
        $user = DB::table('dependent_info')
            ->where('EmployeeId',$this->aes->decrypt($request->id))
            ->where('services','Dental')
            ->whereNull('deleted_at')
            ->where('campus',session('campus'))
            ->get();


        $empId = $this->aes->decrypt($request->id);

        return view('pages.add-new-dependent',
        ['pageConfigs'=>$pageConfigs,'breadcrumbs'=>$breadcrumbs],
        compact('empId','user'));
    }
    public function addDependent(Request $request){

        $user = DB::table('dependent_info')
          ->insert([
            'date' => $request->date,
            'EmployeeId' =>$request->employeeId,
            'campus' => session('campus'),
            'FirstName' =>$request->firstname,
            'MiddleName' =>$request->middlename,
            'LastName' =>$request->lastname,
            'BirthDate' =>$request->bday,
            'gender' =>$request->gender,
            'services' => 'Dental',
            'created_at' => Carbon::now('Asia/Manila'),
            'updated_at' => null,
            'deleted_at' => null,
          ]);
  
        return response()->json([
            'success'   => 'Saved Successfully!'
        ]);
      }  

    public function new(Request $request){
        $pageConfigs = ['pageHeader' => true]; 
        $breadcrumbs = [
          ["link" => "/", "name" => "Home"],["name" => "Appointment"]
        ];

        $user = DB::table('dependent_info')->where('campus',session('campus'))->first();

        $today = Carbon::today();
        $dateofbirth =$user->BirthDate;
        $age = $today->diff($dateofbirth)->y;
        
        $id = $this->aes->decrypt($request->id);

        return view('pages.new-dependent-dental-record',
        ['pageConfigs'=>$pageConfigs,'breadcrumbs'=>$breadcrumbs],
        compact('id','user', 'age'));
    }
    public function search(Request $request){ 

        $result = DB::table('dependent_info')
        ->where(function ($query) use ($request) {
            $query->where('LastName', 'LIKE', '%' . $request->search . '%')
                ->orWhere('FirstName', 'LIKE', '%' .$request->search . '%')
                ->orWhere('MiddleName', 'LIKE', '%' . $request->search . '%');
        })
        ->whereNull('deleted_at')
        ->where('campus',session('campus'))
        ->get();

        $encryptedResults = $result->map(function ($dependent) {
            $dependent->encryptedDependentNo = $this->aes->encrypt($dependent->id);
            return $dependent;
        });
        
        return response()->json($encryptedResults);
    }
    public function create(Request $request){
      
        $patientId =$request->patientId;
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
                'dental_issues' => json_encode($filteredIssues),
                'periodontal' => json_encode($request->periodontal),
                'occlusion' => json_encode($request->occlusion),
                'appliances' => json_encode($request->appliances),
                'tmd' => json_encode($request->tmd),
                'othersApp' => $request->othersApp,
                'date' => $request->date,
                'updated_at' => Carbon::now('Asia/Manila'),
             ]);

             DB::table('appointment')
               ->where('id', $request->appointmentId)
               ->where('id', $request->patientId)
               ->update([ 
                'status' => $request->status,
             ]);
    
             $newId = DB::table('dentalchart')->where('id', $request->patientId)->latest('id')->where('campus',session('campus'))->first();

             return response()->json(['newId' => $this->aes->encrypt($newId->id),'status' => 200,'success'   => 'Updated Successfully!']);
        } else {

        $role = 'Dependent';
        
        DB::table('dentalchart')
        ->insert([ 
            'id' => $request->patientId,
            'campus' => session('campus'),
            'lastname' => $request->lastname,
            'firstname' => $request->firstname,
            'middlename' => $request->middlename,
            'role' => $role,
            'birthdate' => $request->BirthDate,
            'gender' => $request->gender,
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

        $newId = DB::table('dentalchart')
        ->where('id', $request->patientId)
        ->where('role','=','Dependent')
        ->latest('id')
        ->where('campus',session('campus'))
        ->first();

        return response()->json([
            'newId' => $this->aes->encrypt($newId->id),
            'status' => 200,
            'success'   => 'Added Successfully!'
        ]);

      }      
    }
    public function modaleditDependent(Request $request){

        $details = DB::table('dependent_info')
            ->where('id', $request->id)
            ->where('campus',session('campus'))
            ->first();

        return response()->json($details);
    }

    public function updateDependent(Request $request){


       $update = DB::table('dependent_info')
            ->where('id', $request->id)
            ->update([
                'FirstName' => $request->firstname,
                'MiddleName' => $request->middlename,
                'LastName' => $request->lastname,
                'BirthDate' => $request->bday,
                'Gender' => $request->gender,
                'updated_at' =>  Carbon::now('Asia/Manila'),
            ]);

        return response()->json(['message' => 'Deleted successfully']);
    }
    public function deleteDependent(Request $request)
    {

       $delete=DB::table('dependent_info')
            ->where('id', $request->id)
            ->update([
                'deleted_at' => Carbon::now('Asia/Manila'),
            ]);
   
           return response()->json(['message' => 'Deleted successfully']);
   }

//    Medical Services
public function indexDependent(Request $request){
        $pageConfigs = ['pageHeader' => true]; 
        $breadcrumbs = [
          ["link" => "/", "name" => "Home"],["name" => "Medical Dependent"]
        ];
        
        $user = DB::table('dependent_info')
            ->where('EmployeeId',$this->aes->decrypt($request->id))
            ->where('services','Medical')
            ->whereNull('deleted_at')
            ->where('campus',session('campus'))
            ->get();


        $empId = $this->aes->decrypt($request->id);

        return view('pages.medical-addNewDependent',['pageConfigs'=>$pageConfigs,'breadcrumbs'=>$breadcrumbs],compact('empId','user'));
    }

      public function addMedicalDependent(Request $request){

        $user = DB::table('dependent_info')
          ->insert([
            'date' => $request->date,
            'EmployeeId' =>$request->employeeId,
            'campus' => session('campus'),
            'FirstName' =>$request->firstname,
            'MiddleName' =>$request->middlename,
            'LastName' =>$request->lastname,
            'BirthDate' =>$request->bday,
            'gender' =>$request->gender,
            'services' => 'Medical',
            'created_at' => Carbon::now('Asia/Manila'),
            'updated_at' => null,
            'deleted_at' => null,
          ]);
  
        return response()->json([
            'success'   => 'Saved Successfully!'
        ]);
      }  

       public function updateMedicalDependent(Request $request){

       $update = DB::table('dependent_info')
            ->where('id', $request->id)
            ->where('services','Medical')
            ->update([
                'FirstName' => $request->firstname,
                'MiddleName' => $request->middlename,
                'LastName' => $request->lastname,
                'BirthDate' => $request->bday,
                'Gender' => $request->gender,
                'updated_at' =>  Carbon::now('Asia/Manila'),
            ]);

        return response()->json(['message' => 'Deleted successfully']);
    }
    public function deleteMedicalDependent(Request $request)
    {

       $delete=DB::table('dependent_info')
            ->where('id', $request->id)
            ->where('services','Medical')
            ->update([
                'deleted_at' => Carbon::now('Asia/Manila'),
            ]);

        return response()->json(['message' => 'Deleted successfully']);
   }
}

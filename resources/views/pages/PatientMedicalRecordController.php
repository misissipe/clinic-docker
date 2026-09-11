<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Collection;
use Illuminate\Pagination\Paginator;
use\App\Product;
use\App\Inventory;
use\App\Medical;
use\App\Student;
use\App\Employee;
use\App\Stocks;
use DataTables;
use\App\Providers;
use Carbon\Carbon;
use Haruncpi\LaravelIdGenerator\IdGenerator;

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
    public function indexRecord(Request $request){
      $pageConfigs = ['pageHeader' => true];
      $breadcrumbs = [
        ["link" => "/", "name" => "Home"],["name" => "Add New"]
      ];
      $year = date('Y');
      $today = Carbon::today();
      $role = $request->role;

      if($role === 'Student'){
        $name = Student::where('StudentNo', (new AESCipher)->decrypt($request->id))->where('campus',session('campus'))->first();
        $data = DB::table('medicalrecord as m')
                ->select('m.*','s.LastName','s.FirstName','s.MiddleName','s.Sex','s.StudentNo','s.BirthDate')
                ->join('student_info as s','m.patientId','=','s.StudentNo')
                ->where('s.StudentNo',(new AESCipher)->decrypt($request->id))
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
                ->where('e.id',(new AESCipher)->decrypt($request->id))
                ->where('e.campus',session('campus'))
                ->first();

        $dateofbirth =$name->DateOfBirth;
        $age = $today->diff($dateofbirth)->y;

        if (!empty($data)){
          $hhId = (new AESCipher)->encrypt($data->AgencyNumber) ;
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
          ->orderBy('date', 'desc')
          ->where('campus',session('campus'))
          ->whereNull('deleted_at')
          ->get();
             
     return view('pages.patient-monitoring-record',['pageConfigs'=>$pageConfigs,'breadcrumbs'=>$breadcrumbs], compact('addYear','view', 'name', 'request','data','role','year','age','today','id','hhId'));
   
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
      } else {
        $data = [];
        return response()->json($data);
      }     
    }
#insert record
    public function patientRecord(Request $request){
      try {
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
        $stockId = $request->idOTCMed;
        
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

        if ($existingRecord) {
            return response()->json(["Error" => 1, "Message" => "Record already exists."]);
        } else{
      
          if (in_array("OTC Medicine", $request->purpose)) {
   
            $patientId = $request -> patientId;
            $role = $request->get('role');
            
            $record = DB::table('medicalrecord')->insert([
              'patientId' =>  $patientId,
              'campus' => session('campus'),
              'role' => $request->role,
              'positioncourse' => $request->positioncourse,
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
              'status' => $request->status,
              'reqlabres' => $request->reqlabres,
              'recommendation' => $request->recommendation,
              'OTCmedpcs' => json_encode($request->OTCmedpcs), 
              'OTCmedDescript' => json_encode($request->OTCmedDescript),
              'created_at' =>  Carbon::now('Asia/Manila'),
            ]);

            $idOTCMed = $request->idOTCMed; 
            $OTCmedDescript = $request->OTCmedDescript;
            $OTCmedpcs = $request->OTCmedpcs;
                  
            $items = Stocks::whereIn('id', $idOTCMed)
              ->where('campus', session('campus'))
              ->where('item_quantity', '>', 0)
              ->whereNull('deleted_at')
              ->get()
              ->keyBy('id');

            $latestInventories = Inventory::whereIn('stockId', $idOTCMed)
              ->where('campus', session('campus'))
              ->whereIn('id', function ($query) {
                $query->selectRaw('MAX(id)')
                      ->from('inventory')
                      ->where('campus', session('campus'))
                      ->groupBy('stockId');
              })
              ->get() 
              ->keyBy('stockId');

            foreach ($OTCmedDescript as $index => $description) {
    
              $stockId  = $idOTCMed[$index];   
              $itemless = intval($OTCmedpcs[$index]);

              if (!isset($items[$stockId])) continue; 

              $stockItem = $items[$stockId];

              if (!isset($latestInventories[$stockId])) continue;

              $latestInventory = $latestInventories[$stockId];
            
              if ($latestInventory->remaining_stock < $itemless) {
                  return response()->json([
                      "Error"   => 1,
                      "Message" => "Quantity is Greater than Remaining Stock for {$description}!"
                  ]);
              }

              $stockLeft = max(0, $latestInventory->remaining_stock - $itemless);

              $stockItem->update([
                  'item_quantity' => $stockLeft,
                  'updated_at'    => Carbon::now(),
              ]);

              $services = 'Medical';

              Inventory::insert([
                'added_by'        => (new AESCipher)->decrypt(session('employee_id')),
                'patientId'       => $patientId,
                'stockId'         => $stockId,
                'lotno'           => $stockItem->lotno,
                'campus'          => session('campus'),
                'remaining_stock' => $stockLeft,
                'item_stock'      => $latestInventory->remaining_stock,
                'stock_less'      => $itemless,
                'date'            => $request->date,
                'services'        => $services,
                'updated_at'      => Carbon::now('Asia/Manila'), 
              ]);
            }

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
                'role' => $request->role,
                'positioncourse' => $request->positioncourse,
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
                'status' => $request->status,
                'reqlabres' => $request->reqlabres,
                'recommendation' => $request->recommendation,
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
}

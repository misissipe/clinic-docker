<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Collection;
use Illuminate\Pagination\Paginator;
use App\Employee;
use App\HealthHistory;
use DataTables;
use App\Providers;
use Carbon\Carbon;
use App\Http\Controllers\AESCipher;
use Haruncpi\LaravelIdGenerator\IdGenerator;


class EmployeeInformationController extends Controller
{
  protected $aes;
  public function __construct(){
      $this->aes = new AESCipher;
  }
    public function index(Request $request){
      $pageConfigs = ['pageHeader' => true];
      $breadcrumbs = [
        ["link" => "/", "name" => "Home"],["name" => "Employee"]
      ];
    
      return view('pages.employee-information',['pageConfigs'=>$pageConfigs,'breadcrumbs'=>$breadcrumbs]);
    }
#health history
    public function healthHistory(Request $request){
      $pageConfigs = ['pageHeader' => true];
      $breadcrumbs = [
        ["link" => "/", "name" => "Home"],
        ["link" => "/employee-information", "name" => "Search"], 
        ["name" => "Medical and Social Health History"]
      ];
    // dd($request->id);
      // dd(DB::connection('hrmis')->table('employee as e')
      //  ->select('e.*','rp.*')
      // ->leftJoin('refprovince as rp', 'rp.id', '=', 'e.rprovince')
      // ->where('e.LastName', 'Perioles')->where('e.FirstName', 'Clares Mae')->first());

      
      $response = DB::connection('hrmis')
          ->table('employee as e')
          ->select('e.*','d.DepartmentName','rc.citymunDesc','rp.provDesc' )
          ->leftJoin('department as d', 'd.id', '=', 'e.Department')
          ->leftJoin('refcitymun as rc', 'rc.id', '=', 'e.rcitymun')
          ->leftJoin('refprovince as rp', 'rp.id', '=', 'e.rprovince')
          ->where('e.AgencyNumber',$this->aes->decrypt($request->id))
          ->where('e.Campus',session('campus'))
          ->whereNull('e.deleted_at') 
          ->first();

      $data = HealthHistory::where('patientId', $this->aes->decrypt($request->id))->where('campus',session('campus'))->first();

      $today = Carbon::today();
    
      $dateofbirth =$this->aes->decrypt($response->DateOfBirth);
      $age = $today->diff($dateofbirth)->y;
      $newencryptedId = $request->id;
       
      $success = true;
      if($success) {
        return view('pages.employee-health-history', ['pageConfigs' => $pageConfigs,'breadcrumbs' => $breadcrumbs],compact('data','response','dateofbirth','age','newencryptedId'));
      } else {
        return response()->json(["Error"=>1,"Message"=>"Error Saving Data!"]);
      }    
      return back();
    }  
#search
    public function search(Request $request){ 

      $result = DB::connection('hrmis')
      ->table('employee')
      ->where(function ($query) use ($request) {
        $query->where('AgencyNumber', 'like', '%' . $request->search . '%')
          ->orWhere('LastName', 'LIKE', '%' . $request->search . '%')
          ->orWhere('FirstName', 'LIKE', '%' . $request->search . '%')
          ->orWhere('MiddleName', 'LIKE', '%' . $request->search . '%');
      })
      ->where('Campus',session('campus'))
      ->whereNull('deleted_at')
      ->distinct()
      ->get();


        $encryptedResults = $result->map(function ($employee) {
          $employee->encryptedEmployeeNo = $this->aes->encrypt($employee->AgencyNumber);
        return $employee;
    });
    
    return response()->json($encryptedResults);
    
  }
#update
  public function update(Request $request){
    $famhis = json_encode($request->family_his);
    $perhis =json_encode($request->personal_his);
    $pastill =json_encode($request->past_illness);
    $preill =json_encode($request->present_illness);
    $immu =json_encode($request->immunization_his);

    $role = "Employee"; 

    $check = Employee::where('id',$request->id)->where('campus',session('campus'))->exists();
   
     if (!empty($check)) {
        $foundeEmployee = HealthHistory::where('patientId',$this->aes->decrypt($request->patientId))->where('campus',session('campus'))->first();

          if (!empty($foundeEmployee)) {
              $update = HealthHistory::where('patientId',$this->aes->decrypt($request->patientId))
                ->where('campus',(session('campus')))
                ->update([
                    'family_his' => $famhis,
                    'role' => $role, 
                    'othersFamhis' =>$request->othersFamhis,
                    'personal_his' => $perhis,
                    'sticksPerDay' => $request->sticksPerDay,
                    'forYears' => $request->forYears,
                    'shot' => $request->shot,
                    'beer' => $request->beer, 
                    'shotPer' => $request->shotPer,
                    'beerPer' => $request->beerPer, 
                    'past_illness' => $pastill, 
                    'present_illness' => $preill, 
                    'othersPreIll' => $request->othersPreIll,
                    'hospitalization' =>$request->hospitalization,
                    'medicine_mnt' =>$request->medicine_mnt,
                    'allergies' =>$request->allergies,
                    'hos_detail' =>$request->hos_detail,
                    'med_detail' =>$request->med_detail,
                    'al_detail' =>$request->al_detail,
                    'immunization_his' => $immu, 
                    'othersImmu' => $request->othersImmu, 
                    'updated_at' =>  Carbon::now('Asia/Manila')
                ]);

                $updateEmployee = Employee::where('AgencyNumber', $this->aes->decrypt($request->patientId))
                  ->where('campus',(session('campus')))
                  ->update([
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
                  ]);
          
                if($update) {
                    return response()->json(['status' => 200,'success'   => 'Updated Successfully!']);
                } else {
                  return response()->json(["Error"=>1,"Message"=>"Error Saving Data!"]);
                }
          } else {
              $patientId =$this->aes->decrypt($request->patientId);
              
              HealthHistory::insert([
                  'patientId' => $patientId,
                  'campus' => session('campus'),
                  'role' => $role, 
                  'family_his' => $famhis,
                  'othersFamhis' =>$request->othersFamhis,
                  'personal_his' => $perhis,
                  'sticksPerDay' => $request->sticksPerDay,
                  'forYears' => $request->forYears,
                  'shot' => $request->shot,
                  'beer' => $request->beer, 
                  'shotPer' => $request->shotPer,
                  'beerPer' => $request->beerPer, 
                  'past_illness' => $pastill, 
                  'present_illness' => $preill, 
                  'othersPreIll' => $request->othersPreIll,
                  'hospitalization' =>$request->hospitalization,
                  'medicine_mnt' =>$request->medicine_mnt,
                  'allergies' =>$request->allergies,
                  'hos_detail' =>$request->hos_detail,
                  'med_detail' =>$request->med_detail,
                  'al_detail' =>$request->al_detail,
                  'immunization_his' => $immu, 
                  'othersImmu' => $request->othersImmu, 
                  'created_at' =>  Carbon::now('Asia/Manila'),
                  'updated_at' =>  null,
              ]);

              return response()->json(['status' => 200, 'success' => 'Saved Successfully!']);
          }
        }else  {
          $patientId =$this->aes->decrypt($request->patientId);
              
          $employeeCheck =Employee::insert([
              'id' => $request->id,
              'AgencyNumber' => $patientId,
              'campus' => session('campus'), 
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
         
          HealthHistory::insert([
              'patientId' => $patientId,
              'campus' => session('campus'),
              'role' => $role, 
              'family_his' => $famhis,
              'othersFamhis' =>$request->othersFamhis,
              'personal_his' => $perhis,
              'sticksPerDay' => $request->sticksPerDay,
              'forYears' => $request->forYears,
              'shot' => $request->shot,
              'beer' => $request->beer, 
              'shotPer' => $request->shotPer,
              'beerPer' => $request->beerPer, 
              'past_illness' => $pastill, 
              'present_illness' => $preill, 
              'othersPreIll' => $request->othersPreIll,
              'hospitalization' =>$request->hospitalization,
              'medicine_mnt' =>$request->medicine_mnt,
              'allergies' =>$request->allergies,
              'hos_detail' =>$request->hos_detail,
              'med_detail' =>$request->med_detail,
              'al_detail' =>$request->al_detail,
              'immunization_his' => $immu, 
              'othersImmu' => $request->othersImmu, 
              'created_at' =>  Carbon::now('Asia/Manila'),
              'updated_at' =>  null,
          ]);

          return response()->json(['status' => 200, 'success' => 'Saved Successfully!']);
        }
    }
}

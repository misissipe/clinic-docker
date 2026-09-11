<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Collection;
use Illuminate\Pagination\Paginator;
use App\Employee;
use DataTables;
use App\Providers;
use App\HealthHistory;
use Carbon\Carbon;
use App\Http\Controllers\AESCipher;
use Haruncpi\LaravelIdGenerator\IdGenerator;

class EmployeeController extends Controller
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
    
      return view('pages.search-employee',['pageConfigs'=>$pageConfigs,'breadcrumbs'=>$breadcrumbs]);
  }
  public function search(Request $request){ 
  
    $result = DB::table('employee_info')
      ->where('LastName', 'like', '%' . $request->search . '%')
      ->orWhere('FirstName', 'LIKE', '%' . $request->search . '%')
      ->orWhere('MiddleName', 'LIKE', '%' . $request->search . '%')
      ->orWhere('AgencyNumber', 'like', '%' . $request->search . '%')
      ->where('campus', session('campus'))
      ->orderBy('LastName', 'asc')
      ->get();

    $encryptedResults = $result->map(function ($employee) {
    $employee->encryptedEmployeeNo = $this->aes->encrypt($employee->AgencyNumber);
        return $employee;
    });


    return response()->json($encryptedResults);
  }
  public function data(Request $request){
    $pageConfigs = ['pageHeader' => true];
    $breadcrumbs = [
      ["link" => "/", "name" => "Home"],["link" => "/", "name" => "Search"],["name" => "Information"]
    ];

    $data = DB::table('employee_info')->where('id ', $this->aes->decrypt($request->id))->where('campus',session('campus'))->first();

    $today = Carbon::today();
    $age = $today->diff($data->DateOfBirth)->y;

    return view('pages.information-employee ',['pageConfigs'=>$pageConfigs,'breadcrumbs'=>$breadcrumbs],compact('data','age'));
  }
  public function modalPersonalEmp(Request $request){
    try {
  
      $employee =  DB::connection('mysql')->table('employee_info')
        ->where('id',$this->aes->decrypt($request->id))
        ->where('campus',session('campus'))
        ->first();

      return response()->json($employee);

      } catch (\Throwable $th) {
        dd('error',$th);
      }
  }
  public function updatePersonalEmp(Request $request){
    try {

      $viewModal = DB::connection('mysql')
        ->table('employee_info')
        ->where('campus',session('campus'))
        ->where('id',$request->id)
        ->update([
          'FirstName' =>$request->FirstName,
          'MiddleName' =>$request->MiddleName,
          'LastName' =>$request->LastName,
          'DateOfBirth' => $request->DateOfBirth,
          'Cellphone' =>$request->Cellphone,
          'CivilStatus' =>$request->CivilStatus,
          'Citizenship' =>$request->Citizenship,
          'RBarangay' =>$request->RBarangay,
          'citymunDesc' =>$request->citymunDesc,
          'provDesc' =>$request->provDesc,
          'EmailAddress' =>$request->EmailAddress,
          'updated_at' => Carbon::now('Asia/Manila')
        ]);
  
      return response()->json($viewModal);

      } catch (\Throwable $th) {
        dd('error',$th);
      }
  }
  public function delete(Request $request) {

        $delete=Employee::where('id',$this->aes->decrypt($request->id))
            ->where('campus',session('campus'))
            ->delete();
        
       return response()->json(['message' => 'Deleted successfully']);
    }

}

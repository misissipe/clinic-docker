<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Collection;
use Illuminate\Pagination\Paginator;
use App\Result;
use DataTables;
use App\Providers;
use Carbon\Carbon;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use App\Http\Controllers\AESCipher;

class ViewGeneratedSlipController extends Controller
{
    protected $aes;
    public function __construct() {
        $this->aes = new AESCipher;
    }
    public function index(){
       
        $pageConfigs = ['pageHeader' => true];
        $breadcrumbs = [
          ["link" => "/", "name" => "Home"],["name" => "Pending Referrals"]
        ];

        $data = DB::table('referral')->where('status','=','pending')->where('campus',session('campus'))->get();

        $referralS = DB::table('referral')
          ->where('status','=','Pending')
          ->where('role','=','Student')
          ->where('campus',session('campus'))
          ->get();

        $referralE = DB::table('referral')
          ->where('status','=','Pending')
          ->where('role','=','Employee')
          ->where('campus',session('campus'))
          ->get();

        $total_Studcents = DB::table('referral')
          ->where('status','=','Pending')
          ->where('role','=','Student')
          ->where('campus',session('campus'))
          ->count();

        $total_Employees = DB::table('referral')
          ->where('status','=','Pending')
          ->where('role','=','Employee')
          ->where('campus',session('campus'))
          ->count();
    
        return view('pages.view-generated-slip',['pageConfigs'=>$pageConfigs,'breadcrumbs'=>$breadcrumbs],compact('data','referralS','referralE','total_Studcents','total_Employees'));
    }
    public function viewGenSlip(Request $request){
        try {
        $pageConfigs = ['pageHeader' => true];
        $breadcrumbs = [
          ["link" => "/", "name" => "Home"],
          ["link" => "view-generated-certificate", "name" => "Pending Referrals"],
          ["name" => "Generated Slip"]
        ];
    
        $response = DB::table('referral')
          ->where('id',$this->aes->decrypt($request->id))
          ->where('campus',session('campus'))
          ->latest('id')
          ->first();

          $schoolyr = date('Y');
        $current_month = date('n');

        $semester = $request->semester;

        if ($semester === '1') {
            $schoolyr_start = ($current_month >= 6 && $current_month <= 12) ? $schoolyr : null;
        } elseif ($semester === '2') {
            $schoolyr_start = ($current_month >= 12 && $current_month <= 5) ? $schoolyr : $schoolyr - 1;
        } elseif ($semester === '9') {
            $schoolyr_start = ($current_month >= 5 && $current_month <= 7) ? $schoolyr - 1 : null;
        }
      
          $syr = $schoolyr + 1;
          $addYear = $schoolyr.'-'.$syr;

              $doctor = DB::table('doctors')
            ->where('specialization','physician')
            ->where('campus',session('campus'))
            ->first(); 

          $newencryptedId = $response->id;
        return view('pages.viewGeneratedSlip',['pageConfigs'=>$pageConfigs,'breadcrumbs'=>$breadcrumbs],compact('response','newencryptedId','addYear','doctor'));
        } catch (\Throwable $th) {
          dd('error',$th);
        }
    }
    public function viewSlip(Request $request){
      try {
        $view =DB::table('referral')
        ->where('id',$request->id)
        ->where('campus',session('campus'))
        ->first();

        return response()->json($view);

          } catch (\Throwable $th) {
            dd('error',$th);
          }
    }
    public function autoSearchSlip(Request $request)
      {
        $role = $request->get('role');
        $query = $request->get('query');
    
        if ($role === 'Student') {
          $data = DB::table('student_info')
          ->where(function ($query) use ($request) {
              $query->where('StudentNo', 'like', '%' . $request->search . '%')
                  ->orWhere('LastName', 'LIKE', '%' . $request->search . '%')
                  ->orWhere('FirstName', 'LIKE', '%' . $request->search . '%');
          })
          ->where('campus',session('campus'))
              ->orderBy('LastName', 'asc')
              ->get();
              return response()->json([
                  'data' =>$data,
                  'role' => $role
              ]);
      } elseif ($role === 'Employee') {
          
          $data = DB::table('employee_info')
          ->where(function ($query) use ($request) {
              $query->where('AgencyNumber', 'like', '%' . $request->search . '%')
                  ->orWhere('LastName', 'LIKE', '%' . $request->search . '%')
                  ->orWhere('FirstName', 'LIKE', '%' . $request->search . '%');
          })
          ->where('campus',session('campus'))
              ->orderBy('LastName', 'asc')
              ->get();
          return response()->json([
              'data' =>$data,
              'role' => $role
          ]);
      } else {
           
            $data = [];
            return response()->json($data);
        }     
    }
    public function resultSlip(Request $request)
      {
        $result = DB::table('referral')
          ->where('patientId', $request->patientId)
          ->where('campus',session('campus'))
          ->get();
    
      return response()->json($result);
    
    }
    public function approveSlip(Request $request)
      {
          $id = $request->input('id');
          $status = $request->input('status');
          $remarks = $request->input('stat_remarks');

          $cert = DB::table('referral')->where('id', $id)->where('campus', session('campus'))->first();

          if ($status === 'approve') {
              DB::table('referral')->where('id', $id)->update([
                  'status' => 'Approved'
              ]);
              return response()->json([
                  'success' => 'Approved successfully.'
              ]);
          } elseif ($status === 'disapprove') {
              if (empty($remarks)) {
                  return response()->json([
                      'error' => 'Remarks are required for disapproval.'
                  ]);
              }
              DB::table('referral')->where('id', $id)->update([
                  'status' => 'Disapproved',
                  'stat_remarks' => $remarks
              ]);
              return response()->json([
                  'success' => 'Disapproved successfully.'
              ]);
          }

         return redirect()->back();
    }
}


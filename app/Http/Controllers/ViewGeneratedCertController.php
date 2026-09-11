<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Collection;
use Illuminate\Pagination\Paginator;
use App\Status;
use DataTables;
use App\Providers;
use Carbon\Carbon;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use App\Http\Controllers\AESCipher;

class ViewGeneratedCertController extends Controller
{
    protected $aes;
    public function __construct() {
        $this->aes = new AESCipher;
    }
    public function index(){
       
        $pageConfigs = ['pageHeader' => true];
        $breadcrumbs = [
          ["link" => "/", "name" => "Home"],["name" => "Generated Medical Certificate"]
        ];

        $data = DB::table('medicalcert')->where('campus', session('campus'))->get('status');
  
        return view('pages.view-generated-certificate',['pageConfigs'=>$pageConfigs,'breadcrumbs'=>$breadcrumbs],compact('data'));
    }
    public function viewCert(Request $request){
        try {
        $pageConfigs = ['pageHeader' => true];
        $breadcrumbs = [
          ["link" => "/", "name" => "Home"],
          ["link" => "view-generated-certificate", "name" => "Generated Certificate Record"],
          ["name" => "View Generated Certificate"]
        ];
      
          $view = DB::table('medicalcert as m')
            ->select('s.StudentNo','s.courses','s.year','m.*')
            ->join('student_info as s','s.StudentNo','=','m.patientId')
            ->where('m.id',$request->id)
            ->where('s.campus',session('campus'))
            ->first();

        
        // dd($view);
      $newencryptedId = $view->id;
         return view('pages.viewGeneratedCert',['pageConfigs'=>$pageConfigs,'breadcrumbs'=>$breadcrumbs],compact('view','newencryptedId'));
            } catch (\Throwable $th) {
              dd('error',$th);
            }
    }
    public function reviewCert(Request $request){
      try {
    
        $view = DB::table('medicalcert')
            ->where('id',$request->id)
            ->where('campus', session('campus'))
            ->first();
      //    dd($view);
        return response()->json($view);

          } catch (\Throwable $th) {
            dd('error',$th);
          }
    } 
    public function approveResult(Request $request){
            $id = $request->input('id');
            // dd($id);
            $status = $request->input('status');
            $remarks = $request->input('stat_remarks');

            $cert = DB::table('medicalcert')->where('campus', session('campus'))->where('id', $id)->first();

            if ($status === 'approve') {
               $app=DB::table('medicalcert')->where('id', $id)
               ->update([
                    'status' => 'Approved'
                ]);
                // dd($app);
                return response()->json([
                    'success' => 'Approved successfully.'
                ]);
            } elseif ($status === 'disapprove') {
                if (empty($remarks)) {
                    return response()->json([
                        'error' => 'Remarks are required for disapproval.'
                    ]);
                }
                DB::table('medicalcert')->where('id', $id)
                ->update([
                    'status' => 'Disapproved',
                    'stat_remarks' => $remarks
                ]);
                return response()->json([
                    'success' => 'Disapproved successfully.'
                ]);
            }

            return redirect()->back();
    }
    public function autoSearch(Request $request)
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
                ->where('campus', session('campus'))
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
    public function result(Request $request){
        $result = DB::table('medicalcert')
            ->where('patientId', $request->patientId)
            ->where('campus', session('campus'))
            ->get();
        
        return response()->json($result);
    }
}

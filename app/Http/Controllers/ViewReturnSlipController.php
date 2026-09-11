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
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;


class ViewReturnSlipController extends Controller
{
    public function index(){
       
        $pageConfigs = ['pageHeader' => true];
        $breadcrumbs = [
          ["link" => "/", "name" => "Home"],["name" => "View Return Slip"]
        ];

        $data = DB::table('referral')
        ->where('status','=','pending')
        ->where('campus', session('campus'))
        ->get();
  
        return view('pages.view-return-slip',['pageConfigs'=>$pageConfigs,'breadcrumbs'=>$breadcrumbs],compact('data'));
    }
    public function returnSlip(Request $request){
      try {
        $result = DB::table('referral')
        ->where('patientId', $request->patientId)
        ->where('campus', session('campus'))
        ->get();

        return response()->json($result);
            } catch (\Throwable $th) {
              dd('error',$th);
            }
    }
    public function autoSearchReturnSlip(Request $request)
    {
        $role = $request->get('role');
        $searchQuery = $request->get('query');
    
        if ($role === 'Student') {
            $data = DB::table('student_info')
                ->where(function ($query) use ($searchQuery) {
                    $query->where('StudentNo', 'like', '%' . $searchQuery . '%')
                          ->orWhere('LastName', 'LIKE', '%' . $searchQuery . '%')
                          ->orWhere('FirstName', 'LIKE', '%' . $searchQuery . '%');
                })
                ->where('campus', session('campus'))
                ->orderBy('LastName', 'asc')
                ->get();
    
            return response()->json([
                'data' => $data,
                'role' => $role
            ]);
    
        } elseif ($role === 'Employee') {
    
            $data = DB::table('employee_info')
                ->where(function ($query) use ($searchQuery) {
                    $query->where('AgencyNumber', 'like', '%' . $searchQuery . '%')
                          ->orWhere('LastName', 'LIKE', '%' . $searchQuery . '%')
                          ->orWhere('FirstName', 'LIKE', '%' . $searchQuery . '%');
                })
                ->where('campus', session('campus'))
                ->orderBy('LastName', 'asc')
                ->get();
    
            return response()->json([
                'data' => $data,
                'role' => $role
            ]);
    
        } else {
            return response()->json([
                'data' => [],
                'role' => $role
            ]);
        }
    }
    public function getFile(Request $request){

      $view = DB::table('referral')
          ->where("id", $request->input('id'))
          ->where('campus', session('campus'))
          ->first();
              
      return response()->json($view);

    }
    public function delete(Request $request)
    {
        $id = $request->input('id');
     
        $status = $request->input('status');
        $remarks = $request->input('stat_remarks');

        if ($status === 'disapprove') {
            if (empty($remarks)) {
                return response()->json([
                    'errorMessage' => 'Remarks are required for deletion.'
                ]);
            }
        $fileData = DB::table('referral')->where('id', $request->id)->where('campus', session('campus'))->first();

        if (!$fileData) {
            return back()->with('error', 'File not found.');
        }

        // Delete the file from storage
        $filePath = $fileData->file_directory;
        if (\Storage::exists($filePath)) {
            \Storage::delete($filePath);
        }
            DB::table('referral')
                ->where('id', $id)
                ->update([
                    'status' => 'Deleted',
                    'stat_remarks' => $remarks,
                    'deleted_at' => Carbon::now('Asia/Manila'),
                    'file_name' => null,
                    'file_directory' => null
                ]);
    
            return response()->json([
                'success' => 'Deleted successfully.'
            ]);
        } else {
            return response()->json([
                'errorMessage' => 'Invalid status for deletion.'
            ]);
        }
    }
    
  
}

 

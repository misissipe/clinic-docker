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
use App\Signatories;
use Carbon\Carbon;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use App\Http\Controllers\AESCipher;
use Illuminate\Support\Str;

class SignatoriesController extends Controller
{
    protected $aes;
    public function __construct(){
        $this->aes = new AESCipher;
    }
    public function index(){
       
        $pageConfigs = ['pageHeader' => true];
        $breadcrumbs = [
          ["link" => "/", "name" => "Home"],["name" => "Add Signatories"]
        ];

        $view = Signatories::whereNull('deleted_at')->where('campus', session('campus'))->get();

        return view('pages.add-signatories',['pageConfigs'=>$pageConfigs,'breadcrumbs'=>$breadcrumbs],compact('view'));
    }
    public function addSignatories(Request $request)
    {
        $data = [ 
            'campus' => session('campus'),
            "LastName" => $request->LastName,
            "FirstName" => $request->FirstName,
            "MiddleName" => $request->MiddleName,
            'Role'=> $request->role,
            'Designation'=> $request->designation,
            'Office'=> $request->office,
            'services'=> $request->services, 
            'EmploymentStatus'=> $request->emp,
            'sigtype'=> $request->sigtype,
            "created_at"  =>  Carbon::today('Asia/Manila'),
        ];
    
        $signatories = Signatories::insert($data);

        return response()->json([
            'status' => 200,
            'success'   => 'Added Successfully!'
        ]);
        
    }
    public function editSignatories(Request $request){
    
        $edit = Signatories::where('id', $this->aes->decrypt($request->id))
            ->where('campus',session('campus'))
            ->first();
    
        return response()->json($edit);
    }
    public function updateSignatories(Request $request) {

        $update = Signatories::where('id', $this->aes->decrypt($request->id))
            ->update([
                'campus' => session('campus'),
                "LastName" => $request->LastName,
                "FirstName" => $request->FirstName,
                "MiddleName" => $request->MiddleName,
                'Role'=> $request->role,
                'Designation'=> $request->designation,
                'Office'=> $request->office,
                'services'=> $request->services,
                'EmploymentStatus'=> $request->emp,
                'sigtype'=> $request->sigtype,
                "updated_at"  => Carbon::now('Asia/Manila'),
            ]);

        if ($update) {
            return response()->json([
                'status' => 200,
                'success' => 'Updated Successfully!'
            ]);
        } else {
            return response()->json([
                'status' => 500,
                'error' => 'Failed to update!'
            ]);
        }
        
    }    
    public function deleteSignatories(Request $request) {

        $delete=Signatories::where('id',$this->aes->decrypt($request->id))
            ->where('campus', session('campus'))
            ->delete();

       return response()->json(['message' => 'Deleted successfully']);
    }
   

}

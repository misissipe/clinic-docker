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
use App\Http\Controllers\AESCipher;
use Haruncpi\LaravelIdGenerator\IdGenerator;

class AddUserController extends Controller
{
    public function index(){
      $pageConfigs = ['pageHeader' => true];
      $breadcrumbs = [
        ["link" => "/", "name" => "Home"],["name" => "Users"]
      ];

      $user = DB::table('account')->where('campus', session('campus'))->whereNull('deleted_at')->get();

      return view('pages.add-new-user',['pageConfigs'=>$pageConfigs,'breadcrumbs'=>$breadcrumbs], compact('user'));
    }
#add user 
    public function addUser(Request $request){
      $user = DB::table('account')
        ->insert([
          'employee_id' =>$request->employee_id,
          'firstname' =>$request->firstname,
          'middlename' =>$request->middlename,
          'lastname' =>$request->lastname,
          'email' =>$request->email,
          'role' =>$request->role,
          'campus' => session('campus'),
          'created_at' => Carbon::now()
        ]);

      return response()->json([
          'success'   => 'Saved Successfully!'
      ]);
    }   
#view user
    public function viewUser(Request $request) {

      $viewModal = DB::table('account')
        ->where('employee_id',$request->employee_id)
        ->where('campus', session('campus'))
        ->first();
  
      return response()->json($viewModal);
    }
#update
    public function update(Request $request) {
      
      $viewModal = DB::table('account')
        ->where('campus',session('campus'))
        ->where('employee_id',$request->employee_id)
        ->update([
          'employee_id' =>$request->employee_id,
          'firstname' =>$request->firstname,
          'middlename' =>$request->middlename,
          'lastname' =>$request->lastname,
          'email' =>$request->email,
          'role' =>$request->role,
          'updated_at' => Carbon::now()
        ]);
  
      return response()->json($viewModal);
    }

#delete
public function deleteUser(Request $request){

       DB::table('account')
        ->where('employee_id', $request->id)
        ->where('campus',session('campus'))
        ->update([
            'deleted_at' =>  Carbon::now('Asia/Manila'),
        ]);

        return response()->json(['message' => 'Deleted successfully']);
    }

    
}

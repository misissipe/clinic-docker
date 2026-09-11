<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Collection; 
use Illuminate\Pagination\Paginator;
use\App\Measure;
use DataTables;
use\App\Providers;
use Carbon\Carbon;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use App\Http\Controllers\AESCipher;

class MeasureController extends Controller
{
    public function index(){
       
        $pageConfigs = ['pageHeader' => true];
        $breadcrumbs = [
          ["link" => "/", "name" => "Home"],["name" => "Add Unit"]
        ];

        $view = DB::table('unit_of_measurement')->where('campus',session('campus'))->get();

        return view('pages.category-measurement',['pageConfigs'=>$pageConfigs,'breadcrumbs'=>$breadcrumbs],compact('view'));
    }
    public function add(Request $request){
      
        $measurename = $request->measurename;
        // $brandname = $request->brandname;

        $chckItem = Measure::where("unit_of_measurement",$measurename)->where('campus',session('campus'))->first();
        // dd($chckItem);

    if(!empty($measurename) && $chckItem)
        return response()->json(["Error" => 1, "Message" => "Already Exists!"]);
    
        $data = [   
          'campus' => session('campus'),
          "unit_of_measurement" => $measurename,
          "created_at"  =>  Carbon::now('Asia/Manila'),
          "created_by" => session('employee_id')
        ];
  
        $measuresave = Measure::insert($data);

        return response()->json([
            'status' => 200,
            'success'   => 'Added Successfully!'
        ]);
        
}
public function edit(Request $request){
    
    $edit = DB::table('unit_of_measurement')
    ->where('id', (new AESCipher)->decrypt($request->id))
    ->where('campus',session('campus'))
    ->first();

    return response()->json($edit);
}
public function update(Request $request){
    $measureId = $request->id;
    $measurename = $request->measurename;


    $chckItem = Measure::where('id',(new AESCipher)->decrypt($measureId))->where("unit_of_measurement",$measurename)->where('campus',session('campus'))->first();

    if (!empty($measurename) && $chckItem) {
        return response()->json(["Error" => 1, "Message" => "Already Exists!"]);
    } else {
        $update = Measure::where('id', (new AESCipher)->decrypt($measureId))
            ->update([
                'campus' => session('campus'),
                "unit_of_measurement" => $measurename,
                "updated_at"  => Carbon::now('Asia/Manila'),
                "updated_by" => session('employee_id')
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
 }
 public function delete(Request $request) {

    $delete=Measure::where('id', (new AESCipher)->decrypt($request->id))
    ->update([
        'deleted_at' => Carbon::now('Asia/Manila'),
    ]);


   return response()->json(['message' => 'Deleted successfully']);
 }
}

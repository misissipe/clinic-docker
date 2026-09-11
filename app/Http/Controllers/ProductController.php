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
use App\Product;
use Carbon\Carbon;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use App\Http\Controllers\AESCipher;
use Illuminate\Support\Str;

class ProductController extends Controller
{    
    protected $aes;
    public function __construct(){
        $this->aes = new AESCipher;
    }
    public function index(){
       
        $pageConfigs = ['pageHeader' => true];
        $breadcrumbs = [
          ["link" => "/", "name" => "Home"],["name" => "Add Product"]
        ];

        $view = Product::where('campus',session('campus'))
            ->whereNull('deleted_at')
            ->orderBy('created_at','desc')
            ->get();

        return view('pages.category-product',['pageConfigs'=>$pageConfigs,'breadcrumbs'=>$breadcrumbs],compact('view'));
    }
    public function add(Request $request){
            $genericname = $request->genericname;
            $brandname = $request->brandname;

            $chckItem = Product::where("generic_name",$genericname)
                ->where("brand_name",$brandname)
                ->where('campus',session('campus'))
                ->first();
        
        if(!empty($genericname) && !empty($brandname) &&  $chckItem){
            return response()->json(["Error" => 1, "Message" => "Already Exists!"]);
        }

            $data = [ 
              "brand_name" => $brandname,
              "generic_name" => $genericname,
              'campus' =>session('campus'),
              "created_at"  =>  Carbon::now('Asia/Manila'),
              "created_by" =>  $this->aes->decrypt(session('employee_id'))
            ];
      
            $measuresave = Product::insert($data);

            return response()->json([
                'status' => 200,
                'success'   => 'Added Successfully!'
            ]);
            
    }
    public function edit(Request $request){
    
        $edit = Product::where('id', $this->aes->decrypt($request->id))
            ->where('campus',session('campus'))
            ->first();
    
        return response()->json($edit);
    }
    public function update(Request $request) {

        $productId = $request->id;
        $genericName = $request->genericname;
        $brandname = $request->brandname;
     
    
        $chckItem = Product::where('id', $this->aes->decrypt($productId))
            ->where("generic_name", $genericName)
            ->where("brand_name", $brandname)
            ->where('campus',session('campus'))
            ->exists();
    
        if (!empty($genericName) && !empty($brandname) && $chckItem) {
            return response()->json(["Error" => 1, "Message" => "Already Exists!"]);
        } else {
            $update = Product::where('id', $this->aes->decrypt($productId))
                ->update([
                    "brand_name" => $brandname,
                    "generic_name" => $genericName,
                    'campus' => session('campus'),
                    "updated_at"  => Carbon::now('Asia/Manila'),
                    "updated_by" => $this->aes->decrypt(session('employee_id')),
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

        $delete=Product::where('id',$this->aes->decrypt($request->id))
            ->where('campus',session('campus'))
            ->delete();
        
       return response()->json(['message' => 'Deleted successfully']);
    }

}

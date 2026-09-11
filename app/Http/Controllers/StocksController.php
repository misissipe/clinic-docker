<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Collection; 
use Illuminate\Pagination\Paginator;
use App\Product;
use App\Stocks;
use App\Inventory;
use App\Measure;
use DataTables;
use App\Providers;
use Carbon\Carbon;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use App\Http\Controllers\AESCipher;

class StocksController extends Controller
{
    protected $aes;
    public function __construct(){
        $this->aes = new AESCipher;
    }
    public function index(){
       
        $pageConfigs = ['pageHeader' => true];
        $breadcrumbs = [
          ["link" => "/", "name" => "Home"],["name" => "Add"]
        ];
        $year = date('Y');
        
        $data = DB::table('stock')->where('item_quantity', '>', 0)
        // ->whereYear('created_at',$year)
          ->where('campus',session('campus'))
          ->whereNull('deleted_at')
          ->get();
        
        return view('pages.add-items',['pageConfigs'=>$pageConfigs,'breadcrumbs'=>$breadcrumbs],compact('data'));
    }
    public function searchitem(Request $request){

      $itemname = $request->get('itemname');
  
      $data = Product::where('generic_name', 'LIKE', '%' . $itemname . '%')
              ->orderBy('generic_name', 'asc')
              ->where('campus',session('campus'))
              ->get();
              
      return response()->json($data);
    }
    public function searchUnit(Request $request){ 

      $measure = $request->get('measure');
  
          $data = Measure::where('unit_of_measurement', 'like', '%' . $measure . '%')
              ->orderBy('unit_of_measurement', 'asc')
              ->where('campus',session('campus'))
              ->get();

          return response()->json($data);
    
    }
     public function add(Request $request){
        $batchNo = $request->batchNo;
        $itemname = $request->itemname;
        $quantity = $request->quantity;
        $measure = $request->measure;
        $expirationdate = $request->expirationdate;

        $chckItem = Stocks::where("item_name", $itemname)
          ->where("lotno", $batchNo)
          ->where('campus',session('campus'))
          ->first();

        if(!empty($chckItem)) {
            $stockid = $chckItem->id;
          
            $stockquantity =  $chckItem->item_quantity;
            $stocktotal =  $chckItem->total_stock;

            $new_total_qty = $quantity + $stocktotal;
            $new_qty = $quantity + $stockquantity;
          
              $data = [
                "item_quantity" => $new_qty,
                "total_stock" => $new_total_qty,
                'campus' => session('campus'),
                "added_at"  =>  Carbon::now('Asia/Manila'),
                "added_by" => $this->aes->decrypt(session('employee_id'))
              ];
  
              $find = Stocks::where('id',$stockid)->update($data);
              
              $prev = Inventory::where('stockId',$stockid)
                ->where('lotno',$batchNo)
                ->latest('id')
                ->where('campus',session('campus'))
                ->first();
        
              $oldstock = $prev->remaining_stock;
              $remaining = $oldstock + $quantity;
          
              $invent = [
                  "date" => Carbon::now('Asia/Manila'),
                  "stockId" => $stockid,
                  "lotno" => $batchNo,
                  "remaining_stock" => $remaining,
                  "item_stock" => $oldstock,
                  "added_stock" => $quantity,
                  'campus' => session('campus'),
                  "added_at"  =>  Carbon::now('Asia/Manila'),
                  "added_by" => $this->aes->decrypt(session('employee_id'))
                ];

                Inventory::insert($invent);

            $success = true;
            if($success) {
              return response()->json(["success"=>200,"Message"=>"New Stock Added!"]);
            } else {
              return response()->json(["Error"=>1,"Message"=>"Error Adding Stock!"]);
            }
          } else {
           
         $data = [
            "lotno" => $batchNo,
            "item_name" => $itemname,
            "item_quantity" => $quantity,
            "total_stock" => $quantity,
            "measurement" => $measure,
            "expiration_date" => $expirationdate,
            'campus' => session('campus'),
            "created_at"  =>  Carbon::now('Asia/Manila'),
            "created_by" => $this->aes->decrypt(session('employee_id'))
          ];

          $stocks= Stocks::insert($data);

          $stockId1 = Stocks::where('lotno', $request->batchNo)
            ->latest('id')
            ->where('campus', session('campus'))
            ->first();
         
          $invent = [
            "date" => Carbon::now('Asia/Manila'),
            "stockId" =>$stockId1->id,
            "lotno" => $batchNo,
            "remaining_stock" => $quantity,
            "item_stock" => $quantity,
            'campus' =>session('campus'),
            "created_at" => Carbon::now('Asia/Manila'),
            "created_by" => $this->aes->decrypt(session('employee_id'))
          ];
          
          Inventory::insert($invent);
            $success = true;
            if($success) {
              return response()->json(["success"=>200,"Message"=>"New Stock Added!"]);
            } else {
              return response()->json(["Error"=>1,"Message"=>"Error Adding Stock!"]);
            }
          }
        
      }
      public function viewModalStock(Request $request){

        $viewModal = Stocks::where('id',$request->id)
          ->where('campus', session('campus'))
          ->first();

        $measurements = DB::connection('mysql')->table('unit_of_measurement')->get();
      
        $data = [
          'modal' => $viewModal,
          'measure' => $measurements
        ];

        return response()->json($data);
      }
      public function updateStock(Request $request) {

        $update = Stocks::where('lotno', $request->batchNo)
          ->update([
            'lotno' => $request->batchNo,
            'item_name' => $request->itemname,
            'total_stock' => $request->quantity,
            'item_quantity' => $request->quantity,
            'measurement' => $request->measure,
            'expiration_date' => $request->expirationdate,
            'campus' => session('campus'),
            'updated_at' => Carbon::now('Asia/Manila')
          ]);

        return response()->json([
            'status' => 200,
            'success' => 'Updated Successfully!'
        ]);
      }
      public function deleteMed(Request $request){
      
        Stocks::where('id', $request->id)
                ->update([
                    'deleted_at' =>  Carbon::now('Asia/Manila'),
                ]);

        Inventory::where('stockId', $request->id)
                ->update([
                    'deleted_at' =>  Carbon::now('Asia/Manila'),
                ]);
      
        return response()->json(['message' => 'Deleted successfully']);
      }

      public function indexmedicine(){
       
        $pageConfigs = ['pageHeader' => true];
        $breadcrumbs = [
          ["link" => "/", "name" => "Home"],["name" => "List"]
        ];
        $year = date('Y');
        
        $data = DB::table('stock')->where('item_quantity', '>', 0)
          ->where('campus',session('campus'))
          ->whereNull('deleted_at')
          ->orderBy('item_name','asc')
          ->get();
        
        return view('pages.medicine-inventory',['pageConfigs'=>$pageConfigs,'breadcrumbs'=>$breadcrumbs],compact('data'));
    }
}

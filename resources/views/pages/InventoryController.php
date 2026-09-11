<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Collection; 
use Illuminate\Pagination\Paginator;
use\App\Student;
use DataTables;
use\App\Providers;
use\App\Product;
use\App\Stocks;
use\App\Inventory;
use Carbon\Carbon;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use App\Http\Controllers\AESCipher;
use Illuminate\Support\Str;

class InventoryController extends Controller
{
    public function index(){
    $pageConfigs = ['pageHeader' => true];
    $breadcrumbs = [
      ["link" => "/", "name" => "Home"],["name" => "List"]
    ];

      $monthNumber = date('n');
      $year = Carbon::now()->year;

      $monthName = Carbon::create()->month($monthNumber)->format('F');

      $view = DB::table('inventory as i')
          ->join('stock as s','s.id','=','i.stockId')
          ->orderby('i.id','desc')
          ->where('i.campus', session('campus'))
          ->whereMonth('i.date', $monthNumber)
          ->whereYear('i.date', $year)  
          ->whereNull('i.deleted_at')  
          ->get();
        
      $stock = DB::connection('mysql')->table('stock')
          ->orderby('id','asc')
          ->where('campus', session('campus'))
          ->where('item_quantity', '>', 0)
          ->whereNull('deleted_at')
          ->get();

      return view('pages.inventory',['pageConfigs'=>$pageConfigs,'breadcrumbs'=>$breadcrumbs],compact('view','stock','monthName'));
    }
    public function add(Request $request){
       
      $stock_id = Stocks::where("id", $stockselect)->where('campus',session('campus'))->first();
      $damage = Damageitem::where('stock_id',$stock_id->id)->sum('quantity');
  
      if($purchase_qty > ($stock_id->quantity))
         return response()->json(["Error"=>1,"Message"=>"Quantity is greater than the value of available stocks"]);
      }
     public function totalInventory(Request $request){
      
      $pageConfigs = ['pageHeader' => true];
      $breadcrumbs = [
        ["link" => "/", "name" => "Home"],["name" => "Inventory Report"]
      ];
     
      return view('pages.Inventory-report',['pageConfigs'=>$pageConfigs,'breadcrumbs'=>$breadcrumbs]);
    }
    public function displaytotalInventory(Request $request) {
      $year = $request->input('year');

      $medicine = Stocks::where('campus',session('campus'))
          ->whereNull('deleted_at')
          ->get();
      
      $medicine_names = $medicine->pluck('item_name', 'id')->toArray();
      $expiration_date = $medicine->pluck('expiration_date', 'id')->toArray(); 
      
      $inventory_data = Inventory::selectRaw('stockId, MONTH(date) as month, SUM(stock_less) as total_released')
        ->where('campus', session('campus'))
        ->whereYear('date',$year )
        ->whereIn('stockId', array_keys($medicine_names))
        ->whereNull('deleted_at')
        ->groupBy('stockId', 'month')
        ->get();
  
      $monthly_release = [];
      
      foreach ($medicine_names as $id => $name) {
          $monthly_release[$id] = array_fill(1, 12, 0);
      }
      
      foreach ($inventory_data as $data) {
          $monthly_release[$data->stockId][$data->month] = $data->total_released;
      }
      
      $release_totals = [];

      foreach ($monthly_release as $id => $months) {
          $release_totals[$id] = array_sum($months);
      }
      
      $total_released_all_medicines = array_sum($release_totals); 
      
      return response()->json([
          'medicine_names' => $medicine_names,
          'expiration_date' => $expiration_date,
          'monthly_release' => $monthly_release,
          'release_totals' => $release_totals,
          'total_released_all_medicines' => $total_released_all_medicines 
      ]);
     
  }
  public function inventoryRecords(Request $request) {
        $pageConfigs = ['pageHeader' => true];
        $breadcrumbs = [
            ["link" => "/", "name" => "Home"],
            ["name" => "Dental Records"]
        ];

        if ($request->ajax()) {
            $monthSearch = $request->input('monthSearch');
            $year = $request->input('year');
            
            $search = DB::table('inventory as i')
                        ->join('stock as s','s.id','=','i.stockId')
                        ->orderby('i.id','desc')
                        ->where('i.campus', session('campus'))
                        ->whereMonth('i.date', $monthNumber)
                        ->whereYear('i.date', $year)  
                        ->whereNull('i.deleted_at')  
                        ->get();

            return response()->json($search);
        }
    }
}

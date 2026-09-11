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
        $view = DB::table('inventory as i')
          ->join('stock as s','s.id','=','i.stockId')
          ->orderby('i.id','desc')
          ->where('i.campus', session('campus'))
          ->whereMonth('i.date', $monthNumber)
          ->get();
        

        $stock = DB::connection('mysql')->table('stock')
          ->orderby('id','desc')
          ->where('campus', session('campus'))
          ->where('item_quantity', '>', 0)
          ->get();

        
        return view('pages.inventory',['pageConfigs'=>$pageConfigs,'breadcrumbs'=>$breadcrumbs],compact('view','stock'));
    }
    public function add(Request $request){
       
         $stock_id = Stocks::where("id", $stockselect)->where('campus', session('campus'))->first();
         $damage = Damageitem::where('stock_id',$stock_id->id)->sum('quantity');
    
        if($purchase_qty > ($stock_id->quantity))
        
        return response()->json(["Error"=>1,"Message"=>"Quantity is greater than the value of available stocks"]);
    
      }
}

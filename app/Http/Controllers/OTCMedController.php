<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Collection;
use Illuminate\Pagination\Paginator;
use App\Product;
use App\Inventory;
use App\Medical;
use App\Stocks;
use DataTables;
use App\Providers;
use Carbon\Carbon;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use App\Http\Controllers\AESCipher; 

class OTCMedController extends Controller
{
    protected $aes;
    public function __construct(){
        $this->aes = new AESCipher;
    }
   #OVER THE COUNTER MEDICINE
   public function autoSearchOTC(Request $request)
   {
        $query = $request->get('query');

        $data = DB::table('dentalchart')
            ->where('role', $request->get('role'))
            ->where(function($queryBuilder) use ($query) {
                $queryBuilder->where('id', 'like', '%' .  $query . '%')
                        ->orWhere('lastname', 'LIKE', '%' .  $query . '%')
                        ->orWhere('firstname', 'LIKE', '%' .  $query . '%')
                        ->orWhere('middlename', 'LIKE', '%' .  $query . '%');
            })
            ->where('campus', session('campus'))
            ->orderBy('lastname', 'asc')
            ->get();

        return response()->json($data);
    }
    public function medicine(Request $request)  
    {
        $pageConfigs = ['pageHeader' => true];
        $breadcrumbs = [
        ["link" => "/", "name" => "Home"],["name" => "Search"]
        ];

        return view('pages.OTC-medicine',['pageConfigs'=>$pageConfigs,'breadcrumbs'=>$breadcrumbs]);
    }
    public function viewOTC(Request $request){
        $pageConfigs = ['pageHeader' => true];
        $breadcrumbs = [
        ["link" => "/", "name" => "Home"],["name" => "Over-The-Counter Record"]
        ];

        $data = DB::connection('mysql')->table('otc_medicine')
            ->where('patientId', $this->aes->decrypt($request->id))
            ->first();

        if(empty($data)){
            $error_message = 'No record found ';

            session()->flash('error', $error_message);

          return redirect()->route('backtoOTC')->with(['error', $error_message]);
        }

        $view = DB::connection('mysql')->table('otc_medicine')
                ->where('patientId', $this->aes->decrypt($request->id))
                ->whereNull('deleted_at')
                ->orderBy('date', 'desc')
                ->where('campus',session('campus'))
                ->get();

        return view('pages.view-OTC-Record',['pageConfigs'=>$pageConfigs,'breadcrumbs'=>$breadcrumbs], compact('view','request','data'));
    }
    public function createOTC(Request $request){
        
        $existingRecord = DB::table('otc_medicine')
            ->where('patientId',$request->patientId)
            ->where('lastname', $request->lastname) 
            ->where('firstname', $request->firstname)  
            ->where('middlename', $request->middlename)
            ->where('OTCremarks',$request->OTCremarks)
            ->where('OTCmedpcs', json_encode($request->OTCmedpcs))
            ->where('OTCmedDescript',json_encode($request->OTCmedDescript))
            ->latest('patientId', $request->patientId)
            ->exists();

        if ($existingRecord) {
            return response()->json(["Error" => 1, "Message" => "Record already exists."]);
        } else{

        DB::connection('mysql')->table('otc_medicine')->insert([ 
            'campus' => session('campus'),
            'purpose' => $request->purpose,
            'patientId' => $request->patientId,
            'poscourse' => $request->poscourse,
            'lastname' => $request->lastname,
            'firstname' => $request->firstname,
            'middlename' => $request->middlename,
            'gender' => $request->gender,
            'role' => $request->role,
            'OTCremarks' => $request->OTCremarks,
            'OTCmedpcs' => json_encode($request->OTCmedpcs),
            'OTCmedDescript' =>  json_encode($request->OTCmedDescript),
            'date' => $request->date,
            'created_at' => Carbon::now('Asia/Manila'),
        ]);

        
        $idOTCMed = $request->idOTCMed; 
        $OTCmedDescript = $request->OTCmedDescript;
        $OTCmedpcs = $request->OTCmedpcs;
                  
        $items = Stocks::whereIn('id', $idOTCMed)
            ->where('campus', session('campus'))
            ->where('item_quantity', '>', 0)
            ->whereNull('deleted_at')
            ->get()
            ->keyBy('id');

        $latestInventories = Inventory::whereIn('stockId', $idOTCMed)
            ->where('campus', session('campus'))
            ->whereIn('id', function ($query) {
            $query->selectRaw('MAX(id)')
                    ->from('inventory')
                    ->where('campus', session('campus'))
                    ->groupBy('stockId');
            })
            ->get() 
            ->keyBy('stockId');

        foreach ($OTCmedDescript as $index => $description) {

            $stockId  = $idOTCMed[$index];   
            $itemless = intval($OTCmedpcs[$index]);

            if (!isset($items[$stockId])) continue; 

            $stockItem = $items[$stockId];

            if (!isset($latestInventories[$stockId])) continue;

            $latestInventory = $latestInventories[$stockId];
        
            if ($latestInventory->remaining_stock < $itemless) {
                return response()->json([
                    "Error"   => 1,
                    "Message" => "Quantity is Greater than Remaining Stock for {$description}!"
                ]);
            }

            $stockLeft = max(0, $latestInventory->remaining_stock - $itemless);

            $stockItem->update([
                'item_quantity' => $stockLeft,
                'updated_at'    => Carbon::now(),
            ]);

            $services = 'Dental';

            Inventory::insert([
            'added_by'        => (new AESCipher)->decrypt(session('employee_id')),
            'patientId'       => $request->patientId,
            'stockId'         => $stockId,
            'lotno'           => $stockItem->lotno,
            'campus'          => session('campus'),
            'remaining_stock' => $stockLeft,
            'item_stock'      => $latestInventory->remaining_stock,
            'stock_less'      => $itemless,
            'date'            => $request->date,
            'services'        => $services,
            'updated_at'      => Carbon::now('Asia/Manila'), 
            ]);
        }

            $newId = DB::connection('mysql')->table('otc_medicine')
                ->where('patientId', $request->patientId)
                ->where('campus',session('campus'))
                ->latest('id')
                ->first();

            return response()->json([
                'newId' => $newId->id,
                'status' => 200,
                'success'   => 'Saved Successfully!'
            ]);
        }
    }
    public function OTCRecordindex()
    {
        $pageConfigs = ['pageHeader' => true];
        $breadcrumbs = [
            ["link" => "/", "name" => "Home"],["name" => "Search"]
        ];
    
        return view('pages.patient-OTC-record',['pageConfigs'=>$pageConfigs,'breadcrumbs'=>$breadcrumbs]);
    }
    public function searchOTC(Request $request){ 
    try{
        $role = $request->get('role'); 
        $search = $request->input('search');
    
        $result = DB::table('dentalchart')
        ->where('role',$role)
            ->where(function ($query) use ($request) {
                $query->where('id', 'like', '%' . $request->search . '%')
                    ->orWhere('lastname', 'LIKE', '%' . $request->search . '%')
                    ->orWhere('firstname', 'LIKE', '%' . $request->search . '%')
                    ->orWhere('middlename', 'LIKE', '%' . $request->search . '%');
            })
            ->where('campus', session('campus'))
            ->get();

    
        $encryptedResults = $result->map(function ($patient) {
            $patient->encryptedPatientNo = $this->aes->encrypt($patient->id);
            return $patient;
        });
    
        $response = [
            'role' => $role,
            'data' => $encryptedResults,
        ];
    
        return response()->json($response);

      } catch (\Throwable $th) {
        dd('error',$th);
      }
   }

    public function viewEditModal(Request $request){

        $viewModal = DB::table('otc_medicine')
            ->where('id',$request->id)
            ->where('campus', session('campus'))
            ->first();
        
        return response()->json($viewModal);
    }

    public function updateOTCmedicine(Request $request)
    {

        $request->OTCmedpcs = json_encode($request->OTCmedpcs);
        $request->OTCmedDescript = json_encode($request->OTCmedDescript);
    
        $update = DB::table('otc_medicine')
            ->where('id', $request->id)
            ->update([
                'date' => $request->date,
                'OTCremarks' => $request->OTCremarks,
                'OTCmedpcs' => $request->OTCmedpcs,
                'OTCmedDescript' => $request->OTCmedDescript,
                'updated_at' => Carbon::now('Asia/Manila')
            ]);
        return response()->json([
            'status' => 200,
            'success' => 'Updated Successfully!'
        ]);
    }
    public function deleteRecord(Request $request)
    {

        $delete=DB::table('otc_medicine')
            ->where('id', $request->id)
            ->update([
                'deleted_at' => Carbon::now('Asia/Manila'),
            ]);

        return response()->json(['message' => 'Deleted successfully']);
    }
#new 
    public function dental()
    {
        $pageConfigs = ['pageHeader' => true];
        $breadcrumbs = [
        ["link" => "/", "name" => "Home"],["name" => "Search"]
        ];

        $data = DB::table('student_info')->where('deleted_at',null)->where('campus', session('campus'))->where('campus',session('campus'))->get('StudentNo');

        return view('pages.dental-record-chart',['pageConfigs'=>$pageConfigs,'breadcrumbs'=>$breadcrumbs]);
    }

    public function searchMed(Request $request)
    {
        $OTCmedDescript = $request->get('OTCmedDescript');
        $data = Stocks::where('item_name', 'LIKE', '%' . $OTCmedDescript . '%')
            ->orderBy('item_name', 'asc')
            ->where('campus', session('campus'))
            ->where('item_quantity', '>', 0)
            ->get();
    
        return response()->json($data);
    }
}

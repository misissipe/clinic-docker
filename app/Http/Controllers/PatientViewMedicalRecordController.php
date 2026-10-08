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
use App\Student;
use App\Employee;
use App\Stocks;
use DataTables;
use App\Providers;
use Carbon\Carbon;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Validation\ValidationException;

class PatientViewMedicalRecordController extends Controller
{
    protected $aes;
    public function __construct(){
        $this->aes = new AESCipher;
    }
    public function index(){
        $pageConfigs = ['pageHeader' => true];
        $breadcrumbs = [
          ["link" => "/", "name" => "Home"],["name" => "Search"]
        ];
        return view('pages.patient-view-record',['pageConfigs'=>$pageConfigs,'breadcrumbs'=>$breadcrumbs]);
    }
    public function searchView(Request $request)
    { 
        try{
            if ($request->get('role') === 'Student') {
                $search = $request->input('search');
            
                $result = Student::where(function ($query) use ($request) {
                        $query->where('StudentNo', 'like', '%' . $request->search . '%')
                            ->orWhere('LastName', 'LIKE', '%' . $request->search . '%')
                            ->orWhere('FirstName', 'LIKE', '%' . $request->search . '%');
                    })
                    ->where('campus', session('campus'))
                    ->get();
            
                $encryptedResults = $result->map(function ($student) {
                    $student->encryptedStudentNo =$this->aes->encrypt($student->StudentNo);
                    return $student;
                });
             
                $response = [
                    'role' => $request->get('role'),
                    'data' => $encryptedResults,
                ];
            
                return response()->json($response);
            } else if ($request->get('role') === 'Employee') {
         
                $search = $request->input('search');
            
                $result = Employee::where(function ($query) use ($request) {
                    $query->where('AgencyNumber', 'like', '%' . $request->search . '%')
                        ->orWhere('LastName', 'LIKE', '%' . $request->search . '%')
                        ->orWhere('FirstName', 'LIKE', '%' . $request->search . '%');
                    })
                    ->where('campus',session('campus'))
                    ->orderBy('LastName', 'asc')
                    ->get();
            
                    $encryptedResults = $result->map(function ($employee) {
                    $employee->encryptedEmployeeNo = $this->aes->encrypt($employee->id);
                    return $employee;
                });
                
                $response = [
                    'role' => $request->get('role'),
                    'data' => $encryptedResults,
                ];
            
                return response()->json($response);
          
            } elseif ($request->get('role') === 'Dependent') {
                $search = $request->input('search');
            
                $result = DB::table('dependent_info')->where(function ($query) use ($request) {
                    $query->where('id', 'like', '%' . $request->search . '%')
                        ->orWhere('LastName', 'LIKE', '%' . $request->search . '%')
                        ->orWhere('FirstName', 'LIKE', '%' . $request->search . '%');
                    })
                    ->where('services','Medical')
                    ->where('campus',session('campus'))
                    ->orderBy('LastName', 'asc')
                    ->get();
            
                    $encryptedResults = $result->map(function ($dependent) {
                    $dependent->encryptedDependentNo = $this->aes->encrypt($dependent->id);
                    return $dependent;
                });
                
                $response = [
                    'role' => $request->get('role'),
                    'data' => $encryptedResults,
                ];
            
                return response()->json($response);
      } else {
                     return response()->json('<tr><td colspan="5" style="text-align:center;">No records found</td></tr>');
            }
        } catch (\Throwable $th) {
            dd('error',$th);
        }
    }
    
    public function records(Request $request){
        $pageConfigs = ['pageHeader' => true];
        $breadcrumbs = [
            ["link" => "/", "name" => "Home"], 
            ["link" => "/patient-view-record", "name" => "Search"],
            ["name" => "Patient Record"]
        ]; 

        $role = $request->role;

        $identify = Medical::where('patientId',$this->aes->decrypt($request->id))
            ->where('role',$role)
            ->where(function ($query) {
                $query->where('campus', session('campus'))
                    ->orWhereNull('campus')
                    ->orWhere('campus', '');
            })
            ->first();
        
        if ($identify === null) {
            $error_message = 'No record found';
            if($role === 'Student'){
                $name = Student::where('StudentNo', $this->aes->decrypt($request->id))->where('campus',session('campus'))->first();
            }elseif($role === 'Employee'){
                $name = Employee::where('id', $this->aes->decrypt($request->id))->where('campus',session('campus'))->first();
            }elseif($role === 'Dependent'){
                $name = DB::table('dependent_info')->where('id', $this->aes->decrypt($request->id))->where('campus',session('campus'))->first();
            }
            
            $namePatient = $name->FirstName . ' ' . $name->MiddleName . ' ' . $name ->LastName;
            
            session()->flash('error', $error_message);
            session()->flash('patient', $namePatient);
            return redirect()->route('return')->with(['error' => $error_message, 'patient' => $namePatient]);
        } else {

            if($role === 'Student'){
                $name = Student::where('StudentNo', $this->aes->decrypt($request->id))->where('campus',session('campus'))->first();
            } elseif($role === 'Employee'){
                $name = Employee::where('id', $this->aes->decrypt($request->id))->where('campus',session('campus'))->first();
            }elseif($role === 'Dependent'){
                $name = DB::table('dependent_info')->where('id', $this->aes->decrypt($request->id))->where('campus',session('campus'))->first();
            }

            $currentMonth = date('n');
            $schoolYearStartMonth = 8;
    
            if ($currentMonth >= $schoolYearStartMonth) {
                $schoolYear = date('Y');
            } else {
                $schoolYear = date('Y') - 1;
            }
    
            $nextSchoolYear = $schoolYear + 1;
            $addYear = $schoolYear . '-' . $nextSchoolYear;

            $data = Medical::where('patientId', $this->aes->decrypt($request->id))
                    ->where(function ($query) {
                        $query->where('campus', session('campus'))
                            ->orWhereNull('campus')
                            ->orWhere('campus', '');
                    })
                    ->first();
                
            $view = Medical::where('patientId', $this->aes->decrypt($request->id))
                    ->orderBy('date', 'desc')
                    ->where('role',$role)
                    ->where(function ($query) {
                        $query->where('campus', session('campus'))
                            ->orWhereNull('campus')
                            ->orWhere('campus', '');
                    })
                    ->whereNull('deleted_at')
                    ->get();

            $prescriptionRecordIds = DB::table('doctor_consultation')
                    ->whereIn('patientId', $view->pluck('id'))
                    ->whereNull('deleted_at')
                    ->distinct()
                    ->pluck('patientId')
                    ->map(function ($id) {
                        return (int) $id;
                    })
                    ->all();

            return view('pages.patient-record', ['pageConfigs' => $pageConfigs, 'breadcrumbs' => $breadcrumbs], compact('addYear','view', 'name', 'request','data','role','prescriptionRecordIds'));
        }
        return redirect();
    }
    public function viewAll(Request $request) 
    {
        $view = DB::table('medicalrecord as m')
            ->select('m.*','s.LastName','s.FirstName','s.MiddleName','s.Sex')
            ->join('student_info as s','m.patientId','=','s.StudentNo')
            ->where('s.id',$request->id)
            ->orderBy('m.date', 'desc')
            ->where('m.campus',session('campus'))
            ->get();
    
        return response()->json([ 'data'=>$view]);
    } 
    public function viewModal(Request $request) 
    {
      $role = $request->get('role');

      $data = DB::table('medicalrecord as m')
            ->select(
                'm.*',
                's.LastName as studentLastName',
                's.FirstName as studentFirstName',
                's.MiddleName as studentMiddleName',
                's.Sex as studentSex', 
                's.accro as studentaccro' ,
                's.StudentYear as studentStudentYear',
                's.brgy as studentbrgy',
                's.city as studentcity',
                's.province as studentprovince',
                'e.LastName as employeeLastName',
                'e.FirstName as employeeFirstName',
                'e.MiddleName as employeeMiddleName',
                'e.Sex as employeeSex',
                'e.EmploymentStatus as employeeEmploymentStatus' ,
                'e.RBarangay as employeeRBarangay',
                'e.citymunDesc as employeecitymunDesc',
                'e.provDesc as employeeprovDesc',
                'd.LastName as dependentLastName',
                'd.FirstName as dependentFirstName',
                'd.MiddleName as dependentMiddleName',
                'd.Gender as dependentSex',
                'd.campus'
            )
            ->leftJoin('student_info as s', 'm.patientId', '=', 's.StudentNo')
            ->leftJoin('employee_info as e', 'm.patientId', '=', 'e.AgencyNumber')
            ->leftJoin('dependent_info as d', 'm.patientId', '=', 'd.id')
            ->where('m.id',$request->id)
            ->where('m.campus',session('campus'))
            ->first();

            $prescribedMedicines = DB::table('doctor_consultation')
                ->where('patientId', $data->id)
                ->whereNull('deleted_at')
                ->orderBy('id')
                ->get([
                    'medicine_name',
                    'quantity',
                    'dose',
                    'route',
                    'frequency',
                    'duration',
                    'when_to_take',
                    'instruction',
                ]);

            $newData = [
                'viewModal' =>$data,
                'role' => $role,
                'prescribedMedicines' => $prescribedMedicines,
            ];
        return response()->json($newData);
    }
    public function delete(Request $request)
    {

        Medical::where('id', $request->id)
            ->where('campus',session('campus'))
            ->update([
                'deleted_at' =>  Carbon::now('Asia/Manila'),
            ]);

        return response()->json(['message' => 'Deleted successfully']);
    }

    public function updateViewModal(Request $request)
    {
        $request->validate([
            'OTCmedpcs' => 'nullable|array',
            'OTCmedpcs.*' => 'nullable|integer|min:1',
            'OTCmedDescript' => 'nullable|array',
            'OTCmedDescript.*' => 'nullable|string|max:255',
            'idOTCMed' => 'nullable|array',
            'idOTCMed.*' => 'nullable|integer',
        ]);

        $medical = Medical::where('id', $request->id)
            ->where('campus', session('campus'))
            ->firstOrFail();

        $medicineDescriptions = [];
        $medicineQuantities = [];
        $medicineStockIds = [];
        foreach ($request->input('OTCmedDescript', []) as $index => $description) {
            $description = trim((string) $description);
            if ($description === '') continue;

            $medicineDescriptions[] = $description;
            $medicineQuantities[] = (int) ($request->input("OTCmedpcs.$index") ?: 1);
            $medicineStockIds[] = $request->input("idOTCMed.$index");
        }

        $oldDate = $medical->date;
        $oldDescriptions = json_decode($medical->OTCmedDescript, true) ?: [];
        $oldQuantities = json_decode($medical->OTCmedpcs, true) ?: [];

        $request->merge([
            'OTCmedDescript' => $medicineDescriptions,
            'OTCmedpcs' => $medicineQuantities,
            'idOTCMed' => $medicineStockIds,
        ]);

        DB::transaction(function () use ($request, $medical, $medicineDescriptions, $medicineQuantities, $medicineStockIds, $oldDate, $oldDescriptions, $oldQuantities) {
            Medical::where('id', $medical->id)
                ->where('campus', session('campus'))
                ->update([
                    'purpose' => $request->purpose,
                    'date' => $request->date,
                    'time' => $request->time,
                    'findings' => $request->findings,
                    'weight' => $request->weight,
                    'height' => $request->height,
                    'blood_type' => $request->bloodType,
                    'temp' => $request->temperature,
                    'pulse' => $request->pulse,
                    'res_rate' => $request->respiratoryRate,
                    'bp' => $request->bloodPressure,
                    'OTCmedDescript' => json_encode($medicineDescriptions),
                    'OTCmedpcs' => json_encode($medicineQuantities),
                    'remarks' => $request->remarks,
                    'specify' => $request->specify,
                    'status' => $request->status,
                    'reqlabres' => $request->reqlabres,
                    'recommendation' => $request->recommendation,
                    'updated_at' => Carbon::now('Asia/Manila')
                ]);

            $this->syncMedicalInventory($request, $medical, $oldDate, $oldDescriptions, $oldQuantities);

            foreach ($medicineDescriptions as $index => $description) {
                $oldIndex = array_search($description, $oldDescriptions, true);
                $hasInventoryDeduction = $oldIndex !== false && DB::table('inventory as i')
                    ->join('stock as s', 's.id', '=', 'i.stockId')
                    ->where('i.patientId', $medical->patientId)
                    ->where('i.campus', session('campus'))
                    ->where('s.campus', session('campus'))
                    ->where('s.item_name', $description)
                    ->whereDate('i.date', $oldDate)
                    ->whereNull('i.deleted_at')
                    ->exists();

                if ($hasInventoryDeduction) continue;

                $stockId = $medicineStockIds[$index] ?? null;
                if (!$stockId) {
                    $stockId = Stocks::where('item_name', $description)
                        ->where('campus', session('campus'))
                        ->where('item_quantity', '>', 0)
                        ->whereNull('deleted_at')
                        ->where(function ($query) {
                            $query->whereNull('expiration_date')
                                ->orWhere('expiration_date', '>=', Carbon::today());
                        })
                        ->orderByRaw('expiration_date IS NULL, expiration_date ASC')
                        ->value('id');
                }

                if (!$stockId) {
                    throw ValidationException::withMessages([
                        'OTCmedDescript' => "Please select {$description} from the medicine search results.",
                    ]);
                }

                $stock = Stocks::where('id', $stockId)
                    ->where('campus', session('campus'))
                    ->whereNull('deleted_at')
                    ->lockForUpdate()
                    ->first();
                $quantity = $medicineQuantities[$index];

                if (!$stock) {
                    throw ValidationException::withMessages([
                        'OTCmedDescript' => "The selected inventory item for {$description} is unavailable.",
                    ]);
                }

                $latestInventory = Inventory::where('stockId', $stock->id)
                    ->where('campus', session('campus'))
                    ->whereNull('deleted_at')
                    ->orderByDesc('id')
                    ->lockForUpdate()
                    ->first();
                $currentStock = $latestInventory ? (int) $latestInventory->remaining_stock : (int) $stock->item_quantity;

                if ($currentStock < $quantity) {
                    throw ValidationException::withMessages([
                        'OTCmedpcs' => "Insufficient inventory for {$description}.",
                    ]);
                }

                $remainingStock = $currentStock - $quantity;
                $stock->update([
                    'item_quantity' => $remainingStock,
                    'updated_at' => Carbon::now('Asia/Manila'),
                ]);

                Inventory::insert([
                    'added_by' => (new AESCipher)->decrypt(session('employee_id')),
                    'patientId' => $medical->patientId,
                    'stockId' => $stock->id,
                    'lotno' => $stock->lotno,
                    'campus' => session('campus'),
                    'remaining_stock' => $remainingStock,
                    'item_stock' => $currentStock,
                    'stock_less' => $quantity,
                    'added_stock' => 0,
                    'date' => $request->date,
                    'services' => 'Medical',
                    'created_at' => Carbon::now('Asia/Manila'),
                    'updated_at' => Carbon::now('Asia/Manila'),
                ]);
            }
        });
      
            return response()->json([
                'status' => 200,
                'success'   => 'Updated Successfully!'
            ]);
        return back(); 
    }

    private function syncMedicalInventory($request, $medical, $oldDate, array $oldDescriptions, array $oldPieces)
    {
        $newDescriptions = $request->OTCmedDescript ?: [];
        $newPieces = $request->OTCmedpcs ?: [];

        foreach ($oldDescriptions as $index => $oldDescription) {
            $newIndex = array_search($oldDescription, $newDescriptions);
            $newStockLess = $newIndex !== false ? (int) $newPieces[$newIndex] : 0;
            $oldStockLess = isset($oldPieces[$index]) ? (int) $oldPieces[$index] : null;

            $inventory = $this->findMedicalInventoryRowByMedicine(
                $medical->patientId,
                $oldDescription,
                $oldDate,
                $oldStockLess
            );

            if (!$inventory) continue;

            Inventory::where('id', $inventory->id)->update([
                'date' => $request->date,
                'stock_less' => $newStockLess,
                'updated_at' => Carbon::now('Asia/Manila'),
            ]);

            $this->recalculateInventoryFrom($inventory->id);

            if ($newIndex === false) {
                Inventory::where('id', $inventory->id)->update([
                    'deleted_at' => Carbon::now('Asia/Manila'),
                    'updated_at' => Carbon::now('Asia/Manila'),
                ]);
            }
        }

        $staleInventoryIds = DB::table('inventory as i')
            ->join('stock as s', 's.id', '=', 'i.stockId')
            ->where('i.patientId', $medical->patientId)
            ->where('i.campus', session('campus'))
            ->where('i.services', 'Medical')
            ->where('i.stock_less', 0)
            ->where('i.added_stock', 0)
            ->whereNull('i.deleted_at')
            ->where(function ($query) use ($oldDate, $request) {
                $query->whereDate('i.date', $oldDate)
                    ->orWhereDate('i.date', $request->date);
            });

        if (!empty($newDescriptions)) {
            $staleInventoryIds->whereNotIn('s.item_name', $newDescriptions);
        }

        Inventory::whereIn('id', $staleInventoryIds->pluck('i.id'))->update([
            'deleted_at' => Carbon::now('Asia/Manila'),
            'updated_at' => Carbon::now('Asia/Manila'),
        ]);
    }

    private function findMedicalInventoryRowByMedicine($patientId, $medicineName, $date, $stockLess)
    {
        $query = DB::table('inventory as i')
            ->join('stock as s', 's.id', '=', 'i.stockId')
            ->select('i.id')
            ->where('i.patientId', $patientId)
            ->where('i.campus', session('campus'))
            ->where('s.campus', session('campus'))
            ->where('s.item_name', $medicineName)
            ->whereDate('i.date', $date)
            ->whereNull('i.deleted_at');

        if (!is_null($stockLess)) {
            $query->where('i.stock_less', $stockLess);
        }

        $inventory = $query->orderBy('i.id', 'asc')->first();

        if (!$inventory) {
            $inventory = DB::table('inventory as i')
                ->join('stock as s', 's.id', '=', 'i.stockId')
                ->select('i.id')
                ->where('i.patientId', $patientId)
                ->where('i.campus', session('campus'))
                ->where('s.campus', session('campus'))
                ->where('s.item_name', $medicineName)
                ->whereNull('i.deleted_at')
                ->orderBy('i.id', 'desc')
                ->first();
        }

        return $inventory ? Inventory::where('id', $inventory->id)->first() : null;
    }

    private function recalculateInventoryFrom($inventoryId)
    {
        $editedInventory = Inventory::where('id', $inventoryId)
            ->where('campus', session('campus'))
            ->whereNull('deleted_at')
            ->first();

        if (!$editedInventory) return;

        $rows = Inventory::where('stockId', $editedInventory->stockId)
            ->where('lotno', $editedInventory->lotno)
            ->where('campus', session('campus'))
            ->where('id', '>=', $editedInventory->id)
            ->whereNull('deleted_at')
            ->orderBy('id', 'asc')
            ->get();

        $runningStock = (int) $editedInventory->item_stock;

        foreach ($rows as $row) {
            $remainingStock = max(0, $runningStock + (int) $row->added_stock - (int) $row->stock_less);

            Inventory::where('id', $row->id)->update([
                'item_stock' => $runningStock,
                'remaining_stock' => $remainingStock,
                'updated_at' => Carbon::now('Asia/Manila'),
            ]);

            $runningStock = $remainingStock;
        }

        Stocks::where('id', $editedInventory->stockId)
            ->where('campus', session('campus'))
            ->update([
                'item_quantity' => $runningStock,
                'updated_at' => Carbon::now('Asia/Manila'),
            ]);
    }
    public function indeStatus()
    {
        $pageConfigs = ['pageHeader' => true];
        $breadcrumbs = [
          ["link" => "/", "name" => "Home"],["name" => "Search"]
        ];

        $data = DB::table('medicalrecord as m')
            ->select(
                'm.*',
                's.LastName as studentLastName',
                's.FirstName as studentFirstName',
                's.MiddleName as studentMiddleName',
                's.Sex as studentSex',
                's.campus',
                'e.LastName as employeeLastName',
                'e.FirstName as employeeFirstName',
                'e.MiddleName as employeeMiddleName',
                'e.Sex as employeeSex',
                'e.campus',
                'd.LastName as dependentLastName',
                'd.FirstName as dependentFirstName',
                'd.MiddleName as dependentMiddleName',
                'd.Gender as dependentSex',
                'd.campus'
            )
            ->leftJoin('student_info as s', 'm.patientId', '=', 's.StudentNo')
            ->leftJoin('employee_info as e', 'm.patientId', '=', 'e.id')
            ->leftJoin('dependent_info as d', 'm.patientId', '=', 'd.id')
            ->where(function ($query) {
                    $query->where('e.campus', session('campus'))
                        ->orWhere('s.campus', session('campus'))
                         ->orWhere('d.campus', session('campus'));
                })
            ->where('m.status', 'Active')
            ->whereNull('m.logged_out')
            ->whereNull('m.deleted_at') 
            ->where('m.campus', session('campus'))
            ->get();

        return view('pages.patient-status',['pageConfigs'=>$pageConfigs,'breadcrumbs'=>$breadcrumbs],compact('data'));
    }
    public function statusLogout(Request $request)
    {
        $campus = session('campus');
        $id = $request->id;

        if ($request->has('time') && !empty($request->time)) {
            $customDateTime = Carbon::now('Asia/Manila')->format('Y-m-d') . ' ' . $request->time;
            $logoutTime = Carbon::parse($customDateTime, 'Asia/Manila')->format('H:i:s');
        } else {
            $logoutTime = Carbon::now('Asia/Manila')->format('H:i:s');
        }

        $updated = Medical::where('id', $id)
            ->where('campus', $campus)
            ->update([
                'logged_out' => $logoutTime,
                'status' => 'InActive'
            ]);

        if ($updated) {
            return response()->json(['message' => 'Logged out successfully']);
        } else {
            return response()->json(['message' => 'Failed to log out record'], 400);
        }
    }
    public function generatePDF(Request $request){

        $today = Carbon::today();
        $currentMonth = date('n');
        $schoolYearStartMonth = 8;

        if ($currentMonth >= $schoolYearStartMonth) {
            $schoolYear = date('Y');
        } else {
            $schoolYear = date('Y') - 1;
        }

        $nextSchoolYear = $schoolYear + 1;
        $addYear = $schoolYear . '-' . $nextSchoolYear;

        $check = Medical::where('patientId', $this->aes->decrypt($request->id))->where('campus',session('campus'))->first();
    
        if($check->role === 'Student'){
            $info = Student::where('StudentNo', $this->aes->decrypt($request->id))->where('campus',session('campus'))->first();
            $bdatetmp = explode(' ', $info->BirthDate);
            $newbday = $bdatetmp[2].'-'.str_pad($bdatetmp[0], 2, "0", STR_PAD_LEFT).'-'.str_pad($bdatetmp[1], 2, "1", STR_PAD_LEFT);
            $age = $today->diff($newbday)->y;
        } else if($check->role === 'Employee'){
            $info = Employee::where('id', $this->aes->decrypt($request->id))->where('campus',session('campus'))->first();
            $dateofbirth =$info->DateOfBirth;
            $age = $today->diff($dateofbirth)->y;
        }
         
        $view = Medical::where('patientId', $this->aes->decrypt($request->id))
            ->orderBy('date', 'asc')
            ->whereNull('deleted_at')
            ->where('campus',session('campus'))
            ->get();
            

            
        return Pdf::loadView('pages.patient-monitoring-record-form',compact('view','info','addYear','request','check','age'))
            ->setPaper('A5', 'portrait')
            ->stream();
    }
}

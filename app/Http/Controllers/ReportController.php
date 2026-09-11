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
use Haruncpi\LaravelIdGenerator\IdGenerator;
use App\Http\Controllers\AESCipher;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    public function index(){
      $pageConfigs = ['pageHeader' => true];
      $breadcrumbs = [
        ["link" => "/", "name" => "Home"],["name" => "Report Medical Services"]
      ];
    
      return view('pages.report-medical-services',['pageConfigs'=>$pageConfigs,'breadcrumbs'=>$breadcrumbs]);
    }
    public function dentalindex(){
      $pageConfigs = ['pageHeader' => true];
      $breadcrumbs = [
        ["link" => "/", "name" => "Home"],["name" => "Report Dental Services"]
      ];
    
      return view('pages.report-dental-services',['pageConfigs'=>$pageConfigs,'breadcrumbs'=>$breadcrumbs]);
    }
    public function reportMedicalRecord(Request $request){
      $pageConfigs = ['pageHeader' => true];
      $breadcrumbs = [["link" => "/", "name" => "Home"],
      ["link" => "/report-medical-services", "name" => "Report Medical Services"],
      ["name" => "Report"]];

      if(!empty($request->year)){

        $month = $request->query('Month');
        $year = $request->query('year');
        $campus = session('campus');

        $strDate = $year."-".$month;

        $monthName = Carbon::create()->month($month)->format('F');
        
        $medical_services =[
          ["Label" => '1. Provision of OTC Medicines', 'Condition' =>  'OTC Medicine'],
          ["Label" => '2. Physical Assessment', 'Condition' =>  'Physical Assessment'],
          ["Label" => '3. Consultation', 'Condition' =>  'Consultation'],
          ["Label" => '4. Wound Dressing', 'Condition' =>  'Wound Dressing'],
          ["Label" => '5. Issuance of Certificate', 'Condition' =>  'Issuance of Certificate'],
          ["Label" => '6. Blood Pressure', 'Condition' =>  'Blood Pressure'],
          ["Label" => '7. Referral', 'Condition' =>  'Referral'],
          ["Label" =>  '8. Provision of Comfort', 'Condition' =>  'Provision of Comfort'],
          ["Label" => '9. Other Concerns', 'Condition' =>  'Other Concerns']
        ];
                  
        $nurs = DB::table('doctors')
          ->where('specialization','physician')
          ->where('campus',session('campus'))
          ->first(); 
    
        $summary = DB::table('medicalrecord')
          ->select('role', 'purpose', 'gender', DB::raw('COUNT(patientId) as countEmp'))
          ->where('date', "LIKE", $strDate."%")
          ->whereNull('deleted_at')
          ->groupby('role')
          ->groupby('purpose')
          ->groupby('gender')
          ->where('campus', session('campus'))
          ->get();

        $preparedby = DB::connection('mysql')->table('signatories')
         ->where('sigtype','Prepared by')
          ->whereIn('services', ['Medical', 'Medical & Dental'])
          ->where('campus',session('campus'))
          ->first();

          $noted = DB::connection('mysql')->table('signatories')
            ->where('sigtype','Noted by')
             ->whereIn('services', ['Medical', 'Medical & Dental'])
            ->where('campus',session('campus'))
            ->first();

           

        return view('pages.report-records',['pageConfigs'=>$pageConfigs,'breadcrumbs'=>$breadcrumbs],compact('medical_services','month','year','monthName','summary','preparedby','noted'));
      }
    }

    public function reportDentalRecord(Request $request){
      $pageConfigs = ['pageHeader' => true];
      $breadcrumbs = [["link" => "/", "name" => "Home"],
      ["link" => "/report-dental-services", "name" => "Report Dental Services"],
      ["name" => "Report"]];
  
      
      if(!empty($request->year)){
           
        $month = $request->query('Month');
        $year = $request->query('year');
         $campus = session('campus');


        $monthName = Carbon::create()->month($month)->format('F');
        
        $dental_services = [
          'TOOTH EXTRACTION',
          'CAVITY FILLING',
          'ORAL PROPHYLAXIS',
          'DENTAL CHECK-UP',
          'PROVISION OF OTC MEDICINE',
          'ISSUANCE OF DENTAL CERTIFICATE'
        ];

        $preparedby = DB::connection('mysql')->table('signatories')
         ->where('sigtype','Prepared by')
          ->whereIn('services', ['Dental', 'Medical & Dental'])
          ->where('campus',session('campus'))
          ->first();

        $noted = DB::connection('mysql')->table('signatories')
            ->where('sigtype','Noted by')
            ->whereIn('services', ['Dental', 'Medical & Dental'])
            ->where('campus',session('campus'))
            ->first();

        return view('pages.report-dental',['pageConfigs'=>$pageConfigs,'breadcrumbs'=>$breadcrumbs],compact('dental_services','month','year','monthName' ,'preparedby','noted','r'));
      }
    }

    public function expiredmedicine(Request $request){
    $pageConfigs = ['pageHeader' => true];
    $breadcrumbs = [
      ["link" => "/", "name" => "Home"],["name" => "Report Dental Services"]
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
  
    return view('pages.Expiration-report',['pageConfigs'=>$pageConfigs,'breadcrumbs'=>$breadcrumbs]);
  }
public function expiredmedicineSearch(Request $request){
   $pageConfigs = ['pageHeader' => true];
        $breadcrumbs = [
            ["link" => "/", "name" => "Home"],
            ["name" => "Expired Medicine Record"]
        ];

    $monthSearch = $request->monthSearch;
    $year = $request->year;

    $search = DB::table('stock')
        ->where('campus', session('campus'))
        ->whereMonth('expiration_date', $monthSearch)
        ->whereYear('expiration_date', $year)
        ->whereNull('deleted_at')
        ->get();

    return response()->json($search);         
  }
  public function generateReportMed(Request $request){
    $pageConfigs = ['pageHeader' => true];
    $breadcrumbs = [
      ["link" => "/", "name" => "Home"],["name" => "Report Dental Services"]
    ];

      $month = $request->monthSearch;
      $year = $request->year;
    
      $view = DB::table('stock')
            ->whereMonth('expiration_date',$month)
            ->whereYear('expiration_date',$year)
            ->whereNull('deleted_at')
            ->where('campus',session('campus'))
            ->get();

      $preparedby = DB::connection('mysql')->table('signatories')
          ->where('sigtype','Prepared by')
          ->whereIn('services', ['Medical', 'Medical & Dental'])
          ->where('campus',session('campus'))
          ->first();

    
      $noted = DB::connection('mysql')->table('signatories')
            ->where('sigtype','Noted by')
             ->whereIn('services', ['Medical', 'Medical & Dental'])
            ->where('campus',session('campus'))
            ->first();
  
      return Pdf::loadView('pages.Expiration-medicine-form',compact('view','preparedby','noted'))->setPaper('a4')->stream();
  }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Collection;
use Illuminate\Pagination\Paginator;
use App\Status;
use DataTables;
use\App\Providers;
use Carbon\Carbon;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use App\Http\Controllers\AESCipher;

class DashboardController extends Controller
{
    //ecommerce
    public function dashboardEcommerce(){

      $today = Carbon::today();
      $monthNumber = date('n');
      $year = $today->year;
  
      // if ($monthNumber >= 8 && $monthNumber <= 12) {
        
      //     $schoolYearStart = "$year-08-01";  
      //     $schoolYearEnd = ($year + 1) . "-06-30"; 
      // } else {
          
      //     $schoolYearStart = ($year - 1) . "-08-01"; 
      //     $schoolYearEnd = "$year-06-30";  
      // } ->whereBetween('created_at', [$schoolYearStart, $schoolYearEnd])

      $totalStudMS = DB::table('health_history')->where('role','Student')->where('campus',session('campus'))->count();
      $totalEmployeeMS = DB::table('health_history')->where('role','Employee')->where('campus',session('campus'))->count();
      $totalStudDS = DB::table('dentalchart')->where('role','=','Student')->where('campus',session('campus'))->count();
      $totalEmployeeDS = DB::table('dentalchart')->where('role','=','Employee')->where('campus',session('campus'))->count();
      $totalDependentDS = DB::table('dentalchart')->where('role','=','Dependent')->where('campus',session('campus'))->count();


   //Medical Services

      $query = DB::table('medicalrecord')
        ->whereMonth('date', $monthNumber)
        ->whereYear('date', $year)
        ->where('campus', session('campus'))
        ->whereNull('deleted_at');

      $total_records = $query->count();

      $total_consultation = (clone $query)
          ->whereJsonContains('purpose', 'Consultation')
          ->count();

      $total_others = (clone $query)
          ->whereJsonContains('purpose', 'Other Concerns')
          ->count();
      $total_wound_dressing = (clone $query)
          ->whereJsonContains('purpose', 'Wound Dressing')
          ->count();
      $total_bp= (clone $query)
          ->whereJsonContains('purpose', 'Blood Pressure')
          ->count();
      $total_provision= (clone $query)
          ->whereJsonContains('purpose', 'Provision of Comfort')
          ->count();
      $total_issuedcert= (clone $query)
          ->whereJsonContains('purpose', 'Issuance of Certificate')
          ->count();
      $total_referral= (clone $query)
          ->whereJsonContains('purpose', 'Referral')
          ->count();
      $total_medicine= (clone $query)
          ->whereJsonContains('purpose', 'OTC Medicine')
          ->count();

      // $total_records = DB::table('medicalrecord')->whereMonth('date', $monthNumber)->whereYear('date', $year)->where('campus',session('campus'))->whereNull('deleted_at')->count();
      // $total_consultation = DB::table('medicalrecord')->whereJsonContains('purpose', 'Consultation')->whereMonth('date', $monthNumber)->whereYear('date', $year)->where('campus',session('campus'))->whereNull('deleted_at')->count();
      // $total_others = DB::table('medicalrecord')->whereJsonContains('purpose', 'Other Concerns')->whereMonth('date', $monthNumber)->whereYear('date', $year)->where('campus',session('campus'))->whereNull('deleted_at')->count();
      // $total_wound_dressing = DB::table('medicalrecord')->whereJsonContains('purpose', 'Wound Dressing')->whereMonth('date', $monthNumber)->whereYear('date', $year)->where('campus',session('campus'))->whereNull('deleted_at')->count();
      // $total_bp= DB::table('medicalrecord')->whereJsonContains('purpose', 'Blood Pressure')->whereMonth('date', $monthNumber)->whereYear('date', $year)->where('campus',session('campus'))->whereNull('deleted_at')->count();
      // $total_provision= DB::table('medicalrecord')->whereJsonContains('purpose', 'Provision of Comfort')->whereMonth('date', $monthNumber)->whereYear('date', $year)->where('campus',session('campus'))->whereNull('deleted_at')->count();
      // $total_issuedcert = DB::table('medicalrecord')->whereJsonContains('purpose', 'Issuance of Certificate')->whereMonth('date', $monthNumber)->whereYear('date', $year)->where('campus',session('campus'))->whereNull('deleted_at')->count();
      // $total_referral = DB::table('medicalrecord')->whereJsonContains('purpose', 'Referral')->whereMonth('date', $monthNumber)->whereYear('date', $year)->where('campus',session('campus'))->whereNull('deleted_at')->count();
      // $total_medicine = DB::table('medicalrecord')->whereJsonContains('purpose', 'OTC Medicine')->whereMonth('date', $monthNumber)->whereYear('date', $year)->where('campus',session('campus'))->whereNull('deleted_at')->count();
   //Dental Services

      $query2 = DB::table('treatmentrecord')
                ->whereMonth('date', $monthNumber)
                ->whereYear('date', $year)
                ->whereNull('deleted_at')
                ->where('campus',session('campus'));

      $total_recordsVisit = $query2->count();

      $dentalcheckup = (clone $query2)
              ->whereJsonContains('remarks', 'Consultation')
              ->count();
      $cavityfilling = (clone $query2)
              ->whereJsonContains('remarks', 'Oral Restoration')
              ->count();
      $oralprophylaxis = (clone $query2)
              ->whereJsonContains('remarks', 'Oral Prophylaxis')
              ->count();
      $toothextraction = (clone $query2)
              ->whereJsonContains('remarks', 'Tooth Extraction')
              ->count();

      // $total_recordsVisit = DB::table('treatmentrecord')->whereMonth('date', $monthNumber)->whereYear('date', $year)->whereNull('deleted_at')->where('campus',session('campus'))->count();
      // $dentalcheckup = DB::table('treatmentrecord')->whereJsonContains('remarks', 'Consultation')->whereMonth('date', $monthNumber)->whereYear('date', $year)->whereNull('deleted_at')->where('campus',session('campus'))->count();
      // $cavityfilling = DB::table('treatmentrecord')->whereJsonContains('remarks', 'Oral Restoration')->whereMonth('date', $monthNumber)->whereYear('date', $year)->whereNull('deleted_at')->where('campus',session('campus'))->count();
      // $oralprophylaxis = DB::table('treatmentrecord')->whereJsonContains('remarks', 'Oral Prophylaxis')->whereMonth('date', $monthNumber)->whereYear('date', $year)->whereNull('deleted_at')->where('campus',session('campus'))->count();
      // $toothextraction = DB::table('treatmentrecord')->whereJsonContains('remarks', 'Tooth Extraction')->whereMonth('date', $monthNumber)->whereYear('date', $year)->whereNull('deleted_at')->where('campus',session('campus'))->count();
      
      $total_Students = DB::table('referral')->where('status','=','Pending')->where('role','=','Student')->whereMonth('created_at', $monthNumber)->where('campus',session('campus'))->count();
      $total_Employees = DB::table('referral')->where('status','=','Pending')->where('role','=','Employee')->whereMonth('created_at', $monthNumber)->where('campus',session('campus'))->count();

      $total = $total_Students + $total_Employees; 
      $totalOTC = DB::table('otc_medicine')->where('campus',session('campus'))->whereNull('deleted_at')->count();

      $scheduleToday = DB::table('appointment')->where('date', $today)->where('campus',session('campus'))->count();
      $rescheduled = DB::table('appointment')->where('status', 'Rescheduled')->where('date', $today)->where('campus',session('campus'))->count();

      if(session('role') == 'Admin'){
        $scheduleAll = DB::table('appointment')->where('status', '=','Pending')->Orwhere('status', '=','Approved')->Orwhere('status', '=', 'Rescheduled')->where('campus',session('campus'))->get();
       
        return view('pages.dashboard-ecommerce',compact('rescheduled','total_consultation','dentalcheckup','cavityfilling','oralprophylaxis','toothextraction','totalOTC','totalStudMS','totalStudDS','total_recordsVisit','total_records','total_issuedcert','total_referral','total_wound_dressing','total_bp','total_provision','total_medicine','total_others','scheduleAll','scheduleToday','total','totalEmployeeMS','totalEmployeeDS','totalDependentDS'));
      } else if (session('role') == 'Nurse'){
       return view('pages.nurse-dashboard',compact('rescheduled','total_consultation','total','dentalcheckup','cavityfilling','oralprophylaxis','toothextraction','totalOTC','total_recordsVisit','scheduleToday','totalStudMS','totalStudDS','totalStudDS','total_recordsVisit','total_records','total_issuedcert','total_referral','total_wound_dressing', 'total_bp','total_provision','total_medicine','total_others','totalEmployeeMS','totalEmployeeDS','totalDependentDS'));
      } else if (session('role') == 'Nurse Attendant'){

       return view('pages.nurse-attendant-dashboard',compact('rescheduled','total_consultation','total','dentalcheckup','cavityfilling','oralprophylaxis','toothextraction','totalOTC','total_recordsVisit','scheduleToday','totalStudMS','totalStudDS','totalStudDS','total_recordsVisit','total_records','total_issuedcert','total_referral','total_wound_dressing', 'total_bp','total_provision','total_medicine','total_others','totalEmployeeMS','totalEmployeeDS','totalDependentDS'));
      } else if (session('role') == 'Attendant'){
      return view('pages.attendant-dashboard',compact('rescheduled','total_consultation','total','dentalcheckup','cavityfilling','oralprophylaxis','toothextraction','totalOTC','total_recordsVisit','scheduleToday','totalStudMS','totalStudDS','totalStudDS','total_recordsVisit','total_records','total_issuedcert','total_referral','total_wound_dressing', 'total_bp','total_provision','total_medicine','total_others','totalEmployeeMS','totalEmployeeDS','totalDependentDS'));
       return view('pages.doctor-dashboard');
      } else if (session('role') == 'Dentist'){
        $appointmentToday = DB::table('appointment')->whereDate('approve_at', $today)->where('status', '=','Approved')->where('campus',session('campus'))->get();
       return view('pages.dentist-dashboard',compact('rescheduled','total_consultation','appointmentToday','totalStudDS','totalStudMS','totalEmployeeMS','totalEmployeeDS','totalDependentDS'));
      } else if (session('role') == 'Employee'){
          
     return view('pages.page-contact');
    } 
       return view('pages.employee-dashboard');
   }

    // analystic
    public function dashboardAnalytics(){
        return view('pages.dashboard-analytics');
    }


   
    
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PatientDataController extends Controller
{
    public function index(){
      
        return view('pages.patient-data');
      }

      public function store(Request $request){
        
  
      $user = DB::table('health_history')
        ->where('id',$id)
        ->insert([
          'family_his' => $request->family_his,
          'personal_his' => $request->personal_his,
          'present_illness' => $request->past_illness,
          'hospitalization' => $request->present_illness,
          'medicine_mnt' => $request->hospitalization,
          'allergies' => $request->medicine_mnt,
          'Immunization' => $request->allergies,
        ]);
        

        return response()->json([
          'success'   => 'Save Successfully!'
   ]);

        return redirect()->route('pages.patient-data');
      }
  }


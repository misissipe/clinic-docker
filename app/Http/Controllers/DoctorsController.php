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
use App\Doctor;
use App\DoctorLeave;
use Carbon\Carbon;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use App\Http\Controllers\AESCipher;
use Illuminate\Support\Str;

class DoctorsController extends Controller
{
    protected $aes;
    public function __construct(){
        $this->aes = new AESCipher;
    }
    public function indexDoctors(Request $request){
       
        $pageConfigs = ['pageHeader' => true];
        $leaveOnly = $request->routeIs('doctor-leaves.index');
        $breadcrumbs = [
          ["link" => "/", "name" => "Home"],["name" => $leaveOnly ? "Doctor Leaves" : "Add Doctor"]
        ];

        $view = DB::connection('mysql')->table('doctors')->whereNull('deleted_at')->where('campus', session('campus'))->get();
        $leaves = DoctorLeave::with('doctor')
            ->where('campus', session('campus'))
            ->where('ends_on', '>=', Carbon::today()->toDateString())
            ->orderBy('starts_on')
            ->get();

        return view('pages.add-doctors',['pageConfigs'=>$pageConfigs,'breadcrumbs'=>$breadcrumbs],compact('view', 'leaves', 'leaveOnly'));
    }
    public function addDoctors(Request $request){
           
            $data = [ 
              'campus' => session('campus'),
              "LastName" => $request->LastName,
              "FirstName" => $request->FirstName,
              "MiddleName" => $request->MiddleName,
              "license" => $request->license,
              "specialization" => $request->specialization,
              "created_at"  =>  Carbon::now('Asia/Manila'),
              "created_by" =>  $this->aes->decrypt(session('employee_id'))
            ];
      
            $doctors = Doctor::insert($data);

            return response()->json([
                'status' => 200,
                'success'   => 'Added Successfully!'
            ]);
            
    }
    public function editDoctors(Request $request){
    
        $edit = DB::connection('mysql')->table('doctors')
            ->where('id', $this->aes->decrypt($request->id))
            ->where('campus', session('campus'))
            ->first();
    
        return response()->json($edit);
    }
    public function updateDoctors(Request $request) {

            $update = Doctor::where('id', $this->aes->decrypt($request->id))
                ->update([
                    'campus' => session('campus'),
                    "LastName" => $request->LastName,
                    "FirstName" => $request->FirstName,
                    "MiddleName" => $request->MiddleName,
                    "license" => $request->license,
                    "specialization" => $request->specialization,
                    "updated_at"  => Carbon::now('Asia/Manila'),
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
    public function deleteDoctors(Request $request) {

        $delete=Doctor::where('id',$this->aes->decrypt($request->id))
            ->where('campus', session('campus'))
            ->delete();

       return response()->json(['message' => 'Deleted successfully']);
    }

    public function addLeave(Request $request)
    {
        $validated = $request->validate([
            'doctor_id' => 'required|integer',
            'starts_on' => 'required|date|after_or_equal:today',
            'ends_on' => 'required|date|after_or_equal:starts_on',
            'reason' => 'nullable|string|max:255',
            'announcement' => 'nullable|string|max:500',
        ]);

        $doctor = Doctor::where('id', $validated['doctor_id'])
            ->where('campus', session('campus'))
            ->where('specialization', 'Dentist')
            ->firstOrFail();

        $overlap = DoctorLeave::where('doctor_id', $doctor->id)
            ->whereDate('starts_on', '<=', $validated['ends_on'])
            ->whereDate('ends_on', '>=', $validated['starts_on'])
            ->exists();

        if ($overlap) {
            return back()->withErrors(['starts_on' => 'This dentist already has leave covering part of the selected dates.'])->withInput();
        }

        DoctorLeave::create([
            'doctor_id' => $doctor->id,
            'campus' => session('campus'),
            'starts_on' => $validated['starts_on'],
            'ends_on' => $validated['ends_on'],
            'reason' => $validated['reason'] ?? null,
            'announcement' => $validated['announcement'] ?: 'Dental appointments may be limited because the dentist is on leave.',
            'created_by' => session('employee_id'),
        ]);

        return back()->with('leave_success', 'Doctor leave and patient announcement added successfully.');
    }

    public function deleteLeave(DoctorLeave $leave)
    {
        abort_unless((string) $leave->campus === (string) session('campus'), 403);
        $leave->delete();

        return back()->with('leave_success', 'Doctor leave removed successfully.');
    }
   

}

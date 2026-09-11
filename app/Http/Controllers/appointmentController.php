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
use App\Providers;
use Carbon\Carbon;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use App\Http\Controllers\MedClientAddController;


class appointmentController extends Controller
{
    protected $aes;
    public function __construct(){
        $this->aes = new AESCipher;
    }
//Patient Portal 
    public function indexAppointment()
        {
            $pageConfigs = ['pageHeader' => true];
            $breadcrumbs = [
                ["link" => "/", "name" => "Home"],
                ["name" => "Set Appointment"]
            ];

            $appointments = DB::table('appointment')
                ->where('campus', session('campus'))
                ->first();

            return view('pages.appointment-search',['pageConfigs'=>$pageConfigs,'breadcrumbs'=>$breadcrumbs],compact('appointments'));
        }

    public function indexpatientAppointment()
    {
        $this->autoCancelPastAppointments();

        $appointments = DB::connection('mysql')->table('appointment')
            ->whereNull('deleted_at')
            ->where('campus', session('campus'))
            ->get();
        
        $reserve = $appointments->map(function($appointment) {
        $fullname = date('h:i A', strtotime($appointment->time));
       
        
        return [
            'title' => $fullname,
            'date' => $appointment->date,
            'time' => $appointment->time,
            'status' => $appointment->status,
            'patientId' => $appointment->patientId,
            'purpose' => $appointment->purpose,
            'id' => $appointment->id, 
        ];
    });
    

        return view('pages.calendar-patient-appointment',compact('appointments','reserve'));
    }


//Admin portal
    public function index()
    {
        $pageConfigs = ['pageHeader' => true];
        $breadcrumbs = [
            ["link" => "/", "name" => "Home"],
            ["name" => "Set Appointment"]
          ];

        $appointments = DB::table('appointment')
            ->where('campus', session('campus'))
            ->first();

        return view('pages.appointment-search',['pageConfigs'=>$pageConfigs,'breadcrumbs'=>$breadcrumbs],compact('appointments'));
    }
    public function setSched(Request $request){
        $pageConfigs = ['pageHeader' => true];
        $breadcrumbs = [
            ["link" => "/", "name" => "Home"],
            ["name" => "Set Appointment"]
          ];

        $connection = MedClientAddController::getCampusConnection();

        $course = DB::connection($connection)->table('course as c')
            ->select('c.id','c.course_title','c.accro', 's.*','r.Course','m.course_major','r.StudentYear')
            ->join('students as s','c.id','=','s.Course')
            ->join('registration as r','r.Course','=','s.Course')
            ->join('major as m','m.id','=','r.Major')
            ->where('s.StudentNo', $student->StudentNo)
            ->orderBy('r.StudentYear', 'desc')
            ->first();
        
        if($course->Sex === 'F'){
            $gender = 'Female';
        }elseif ($course->Sex === 'M'){
            $gender = 'Male';
        }

        $today = Carbon::today();

        $bdatetmp = explode(' ', $newday->BirthDate);
        $newbday = $bdatetmp[2].'-'.str_pad($bdatetmp[0], 2, "0", STR_PAD_LEFT).'-'.str_pad($bdatetmp[1], 2, "1", STR_PAD_LEFT);
        $age = $today->diff($newbday)->y;

        return view('pages.set-schedule',['pageConfigs'=>$pageConfigs,'breadcrumbs'=>$breadcrumbs],compact('appointments','student','age','newbday','course','gender'));
      }
      public function searchInfo(Request $request){ 
        try{
        $search = $request->input('search');

          if ($request->get('role') === 'Student') {

            $connection = MedClientAddController::getCampusConnection();
    
            $result = DB::connection($connection)
                ->table('students as s')
                ->select('s.*', 'r.SchoolLevel')
                ->leftJoin('registration as r', 's.StudentNo', '=', 'r.StudentNo') 
                ->where(function ($q) use ($search) {
                    $q->where('s.StudentNo', 'like', '%' . $search . '%')
                    ->orWhere('s.LastName', 'like', '%' . $search . '%')
                    ->orWhere('s.FirstName', 'like', '%' . $search . '%');
                })
                ->whereIn('r.SchoolLevel', ['Under Graduate', 'Masteral', 'Doctoral', 'Highschool'])
                ->where('s.notuse', 0)
                ->where('r.finalize', 1)
                ->where(function ($q) {
                    $q->where('s.bor', '=', '')
                    ->orWhereNull('s.bor');
                })
                ->distinct()
                ->get();

    
            $encryptedResults = $result->map(function ($student) {
                $student->encryptedStudentNo = $this->aes->encrypt($student->StudentNo);
                return $student;
            });
    
            $response = ['role' => $request->get('role'),'data' => $encryptedResults];
        
            return response()->json($response);
           }else if ($request->get('role') === 'Employee') {
            //  $record = Http::withToken('14240|DCz8jRB7WZUZswmk7tlIfYcQwkdNUiwYJcjC0F7z')->post("https://api.southernleytestateu.edu.ph/api/employee/search_clinic", [
            //     'Campus' => $this->aes->encrypt(session('campus')),
            //     'EmployeeName' => $request->id,
            // ])->json();
           
            $result =DB::connection('hrmis')
                ->table('employee')
                ->where(function ($query) use ($request) {
                    $query->where('AgencyNumber', 'like', '%' . $request->search . '%')
                    ->orWhere('LastName', 'LIKE', '%' . $request->search . '%')
                    ->orWhere('FirstName', 'LIKE', '%' . $request->search . '%')
                    ->orWhere('MiddleName', 'LIKE', '%' . $request->search . '%');
                })
                ->where('Campus',session('campus'))
                ->whereNull('deleted_at')
                ->distinct()
                ->get();

                $encryptedResults = $result->map(function ($employee) {
                $employee->encryptedEmployeeNo = $this->aes->encrypt($employee->AgencyNumber);
                return $employee;
            });
          
            $response = ['role' => $request->get('role'),'data' => $encryptedResults,];
    
            return response()->json($response);
               } else {
                       return response()->json('<tr><td colspan="5" style="text-align:center;">No records found</td></tr>');
                   }
             } catch (\Throwable $th) {
               dd('error',$th);
             }
      }
      public function setSchedIndex(Request $request){
        $pageConfigs = ['pageHeader' => true];
        $breadcrumbs = [
          ["link" => "/", "name" => "Home"],["link" => "/appointment-search","name" => "Search"],["name" => "Appointment"]
        ];

        if ($request->role === 'Student') {

            $connection = MedClientAddController::getCampusConnection();  

            $role='Student';
            $course = DB::connection($connection)->table('course as c')
                ->select('c.id','c.course_title','c.accro', 's.*','r.Course','m.course_major','r.StudentYear')
                ->join('students as s','c.id','=','s.Course')
                ->join('registration as r','r.Course','=','s.Course')
                ->join('major as m','m.id','=','r.Major')
                ->where('s.StudentNo',$this->aes->decrypt($request->id))
                ->orderBy('r.StudentYear', 'desc')
                ->first();
            //  dd($course);

            return view('pages.appointment', ['pageConfigs' => $pageConfigs,'breadcrumbs' => $breadcrumbs], compact('course','role'));
       
        }else if ($request->role=== 'Employee'){
           
            $record  = DB::connection('hrmis')
                ->table('employee as e')
                ->select('c.*', 'e.*','rc.*','rp.*')
                ->leftJoin('cscitemname as c', 'c.id', '=', 'e.Department')
                ->leftJoin('refcitymun as rc', 'rc.id', '=', 'e.rcitymun')
                ->leftJoin('refprovince as rp', 'rp.id', '=', 'e.rprovince')
                ->where('e.AgencyNumber',$this->aes->decrypt($request->id))
                ->where('e.Campus',session('campus'))
                ->whereNull('e.deleted_at') 
                ->first();


            $newencryptedId = $request->id;

            $today = Carbon::today('Asia/Manila');
            $dateofbirth =$this->aes->decrypt($record->DateOfBirth);
            $age = $today->diff($dateofbirth)->y;
            $role='Employee';
        
            return view('pages.appointment', ['pageConfigs' => $pageConfigs,'breadcrumbs' => $breadcrumbs], compact('record','newencryptedId','age','lastname','firstname','middlename','cellphone','AgencyNumber','role'));
        }       
    }
    public function autocompleteInfo(Request $request)
    {
        $role = $request->get('role');
        $query = $request->get('query');
    
        if ($role === 'Student') {
            $connection = MedClientAddController::getCampusConnection();

            $data = DB::connection($connection)
                ->table('students as s')
                ->select('s.*','r.SchoolLevel')
                ->leftJoin('registration as r', 's.StudentNo', '=', 'r.StudentNo') 
                ->where(function($queryBuilder) use ($query) {
                    $queryBuilder->where('s.LastName', 'like', '%' . $query . '%')
                        ->orWhere('s.FirstName', 'LIKE', '%' . $query . '%')
                        ->orWhere('s.MiddleName', 'LIKE', '%' . $query . '%')
                        ->orWhere('s.StudentNo', 'like', '%' . $query . '%');
                    })
                ->where(function($queryBuilder) {
                    $queryBuilder->where('s.bor', '=' , '')
                        ->orWhereNull('s.bor');
                })
                ->whereIn('r.SchoolLevel', ['Under Graduate', 'Masteral', 'Doctoral', 'Highschool'])
                ->where('s.notuse', 0)
                ->where('r.finalize',1)
                ->distinct()
                ->get();
        
            return response()->json($data);
        } elseif ($role === 'Employee') {
            $data = DB::table('employee_info')
                ->where(function($queryBuilder) use ($query) {
                    $queryBuilder->where('AgencyNumber', 'like', '%' . $query . '%')
                        ->orWhere('LastName', 'LIKE', '%' . $query . '%')
                        ->orWhere('FirstName', 'LIKE', '%' . $query . '%');
                })
                ->where('campus',session('campus'))
                ->get();
            return response()->json($data);
        } else {
            $data = [];
            return response()->json($data);
        }     
     }
    public function view(Request $request){
        $this->autoCancelPastAppointments();

        $pageConfigs = ['pageHeader' => true];
        $breadcrumbs = [
          ["link" => "/", "name" => "Home"],
          ["name" => "Schedule"]
        ];
        
        $today = Carbon::today();
        $activeScheduleStatuses = ['Pending', 'For Approval', 'Approved', 'Rescheduled'];

        $viewToday = DB::table('appointment')
            ->whereDate('date', $today)
            ->whereIn('status', $activeScheduleStatuses)
            ->where('campus', session('campus'))
            ->whereNull('deleted_at')
            ->orderBy('time')
            ->get();

        $upcomingSchedules = DB::table('appointment')
            ->whereDate('date', '>', $today)
            ->whereIn('status', $activeScheduleStatuses)
            ->where('campus', session('campus'))
            ->whereNull('deleted_at')
            ->orderBy('date')
            ->orderBy('time')
            ->take(10)
            ->get();

        $allSchedules = DB::table('appointment')
            ->where('campus', session('campus'))
            ->whereNull('deleted_at')
            ->orderBy('date', 'desc')
            ->orderBy('time', 'desc')
            ->get();

        $schedToday = DB::table('appointment')
                    ->whereDate('date', $today)
                    ->whereIn('status', $activeScheduleStatuses)
                    ->where('campus', session('campus'))
                    ->whereNull('deleted_at')
                    ->count();

        $upcomingCount = DB::table('appointment')
                    ->whereDate('date', '>', $today)
                    ->whereIn('status', $activeScheduleStatuses)
                    ->where('campus', session('campus'))
                    ->whereNull('deleted_at')
                    ->count();

        $pendingCount = DB::table('appointment')
                    ->whereIn('status', ['Pending', 'For Approval'])
                    ->where('campus', session('campus'))
                    ->whereNull('deleted_at')
                    ->count();

        $approvedCount = DB::table('appointment')
                    ->where('status', 'Approved')
                    ->where('campus', session('campus'))
                    ->whereNull('deleted_at')
                    ->count();

        $rescheduledCount = DB::table('appointment')
                    ->where('status', 'Rescheduled')
                    ->where('campus', session('campus'))
                    ->whereNull('deleted_at')
                    ->count();

        return view('pages.view-appointment',['pageConfigs'=>$pageConfigs,'breadcrumbs'=>$breadcrumbs],compact(
            'viewToday', 'upcomingSchedules', 'allSchedules', 'schedToday', 'upcomingCount',
            'pendingCount', 'approvedCount', 'rescheduledCount'
        ));
    }
    public function status(Request $request){
        $this->autoCancelPastAppointments();

        $pageConfigs = ['pageHeader' => true];
        $breadcrumbs = [
          ["link" => "/", "name" => "Home"],
          ["name" => "Status Appointment"]
        ];

        $statusAppointments = DB::table('appointment')
            ->whereIn('status', ['Pending', 'For Approval', 'Approved', 'Disapproved', 'Rescheduled', 'No Show'])
            ->where('campus', session('campus'))
            ->whereNull('deleted_at')
            ->orderByRaw("CASE WHEN status IN ('Pending', 'For Approval') THEN 0 ELSE 1 END")
            ->orderBy('date')
            ->orderBy('time')
            ->get();

        $statusCounts = [
            'all' => $statusAppointments->count(),
            'pending' => $statusAppointments->whereIn('status', ['Pending', 'For Approval'])->count(),
            'approved' => $statusAppointments->where('status', 'Approved')->count(),
            'disapproved' => $statusAppointments->where('status', 'Disapproved')->count(),
            'rescheduled' => $statusAppointments->where('status', 'Rescheduled')->count(),
            'no-show' => $statusAppointments->where('status', 'No Show')->count(),
        ];

        return view('pages.view-status-appointment', [
            'pageConfigs' => $pageConfigs,
            'breadcrumbs' => $breadcrumbs,
        ], compact('statusAppointments', 'statusCounts'));
    }
    public function viewModalPayment(Request $request){

        $paymentAll = DB::table('treatmentrecord as t')
            ->join('dentalchart as d', 't.patientId', '=', 'd.id')
            ->select('d.*', 't.*')
            ->where('t.id',$request->id)
            ->where('t.campus',session('campus'))
            ->first();

        return response()->json( $paymentAll);

    }
    public function reScheduled(Request $request){

        $paymentAll = DB::table('treatmentrecord as t')
            ->join('dentalchart as d', 't.patientId', '=', 'd.id')
            ->select('d.*', 't.*')
            ->where('t.id',$request->id)
            ->where('t.campus', session('campus'))
            ->first();

        return response()->json( $paymentAll);
    }
    public function paymentappointment(){
        $pageConfigs = ['pageHeader' => true];
        $breadcrumbs = [
          ["link" => "/", "name" => "Home"],
          ["link" => "/appointment", "name" => "Appointment"],
          ["name" => "View Appointment"]
        ];
        
        $today = Carbon::today();

        $payment = DB::table('dentalchart')
            ->where('campus',session('campus'))
            ->get();

        return view('pages.payment-appointment',['pageConfigs'=>$pageConfigs,'breadcrumbs'=>$breadcrumbs],compact('payment'));
    }
    public function payment(Request $request){

        $payment = DB::table('treatmentrecord')
            ->where('id',$request->id)
            ->update([ 
                'ORnumber' => $request->ORnumber,
                'ORcreated_at' => Carbon::now('Asia/Manila'),
            ]);

        return response()->json([
            'status' => 200,
            'success'   => 'Saved Successfully!'
        ]);
    }
    public function reschedule(Request $request){
        $request->validate([
            'id' => 'required|exists:appointment,id',
            'date' => 'required|date|after_or_equal:today',
            'time' => 'required|date_format:H:i',
            'reschedule_reason' => 'required|string|max:255',
        ]);

        $appointment = DB::table('appointment')
            ->where('id', $request->id)
            ->where('campus', session('campus'))
            ->whereNull('deleted_at')
            ->first();

        if (!$appointment) {
            return response()->json([
                'status' => 404,
                'error' => 'Appointment not found.',
            ], 404);
        }

        $slotIsOccupied = DB::table('appointment')
            ->where('id', '!=', $request->id)
            ->where('date', $request->date)
            ->where('time', $request->time)
            ->where('status', '!=', 'Cancelled')
            ->where('campus', session('campus'))
            ->whereNull('deleted_at')
            ->exists();

        if ($slotIsOccupied) {
            return response()->json([
                'status' => 409,
                'error' => 'The selected date and time are already occupied.',
            ], 409);
        }

        DB::table('appointment')
            ->where('id', $request->id)
            ->update([
                'original_date' => $appointment->original_date ?: $appointment->date,
                'original_time' => $appointment->original_time ?: $appointment->time,
                'date' => $request->date,
                'time' => $request->time,
                'status' => 'Rescheduled',
                'remarks' => trim($request->reschedule_reason),
                'reschedule_at' => Carbon::now('Asia/Manila'),
            ]);

        return response()->json([
            'status' => 200,
            'success' => 'Appointment rescheduled successfully!'
        ]);
    }
    public function create(Request $request){

        $existingAppointment = DB::table('appointment')
            ->where('date', $request->date)
            ->where('time', $request->time)
            ->where('status', '!=', 'Cancelled')
            ->where('campus',session('campus'))
            ->exists();

        if ($existingAppointment){
            return response()->json(['status' => 400,'error' => 'The requested date and time slot is already occupied.']);
        }else{
            DB::table('appointment')
            ->insert([
                'campus' => session('campus'),
                'patientId' => $request->patientId,
                'lastname' => $request->lastname,
                'firstname' => $request->firstname,
                'middlename' => $request->middlename,
                'contactNo' => $request->contactNo,
                'role' => $request->role,
                'date' => $request->date,
                'time' => $request->time,
                'purpose' => json_encode($request->purpose),
                'status' => $request->status,
                'created_at' => Carbon::now('Asia/Manila'),
            ]);
    
            return response()->json(['status' => 200,'success' => 'Appointment set successfully!']);
        }
    }
    public function update(Request $request){

        $appointment = Appointment::find($request->id);

        $appointment->title = $request->title;
        $appointment->start_time = $request->start;
        $appointment->end_time = $request->end;

        $appointment->save();

        return response()->json(['success' => true]);
    }
    public function ResultStatus(Request $request){

        $id = $request->input('id');
        $status = $request->input('status');
        $remarks = $request->input('stat_remarks');

        $cert = DB::table('appointment')
            ->where('id', $id)
            ->where('campus', session('campus'))
            ->whereNull('deleted_at')
            ->first();

        if (!$cert) {
            return response()->json([
                'error' => 'Appointment not found.'
            ], 404);
        }

            if ($status === 'Approved') {
                if ($cert->status === 'Rescheduled') {
                    return response()->json([
                        'success' => 'The appointment remains identified as Rescheduled.'
                    ]);
                }

                DB::table('appointment')->where('id', $id)
                ->update([
                    'status' => 'Approved',
                    'approve_at' => Carbon::now('Asia/Manila')
                ]);
                return response()->json([
                    'success' => 'Approved successfully.'
                ]);
            } elseif ($status === 'Disapproved') {
                if (empty($remarks)) {
                    return response()->json([
                        'error' => 'Remarks are required for disapproval.'
                    ]);
                }
                DB::table('appointment')->where('id', $id)
                ->update([
                    'status' => 'Disapproved',
                    'remarks' => $remarks,
                    'disapprove_at' => Carbon::now('Asia/Manila')
                ]);
                return response()->json([
                    'success' => 'Disapproved successfully.'
                ]);
            } elseif ($status === 'Cancelled') {
                if (empty(trim((string) $remarks))) {
                    return response()->json([
                        'error' => 'Remarks are required for cancellation.'
                    ]);
                }

                DB::connection('mysql')->table('appointment')->where('id', $id)->update([
                    'status' => 'Cancelled',
                    'remarks' => trim((string) $remarks),
                    'deleted_at' => Carbon::now('Asia/Manila')
                ]);
                return response()->json([
                    'success' => 'Cancelled successfully.'
                ]);
            } elseif (in_array($status, ['Done', 'No Show'], true)) {
                if ($cert->status !== 'Approved') {
                    return response()->json([
                        'error' => 'Only approved appointments can be marked as '.$status.'.'
                    ], 422);
                }

                $updated = DB::table('appointment')
                    ->where('id', $id)
                    ->where('campus', session('campus'))
                    ->whereNull('deleted_at')
                    ->where('status', 'Approved')
                    ->update(['status' => $status]);

                if (!$updated) {
                    return response()->json([
                        'error' => 'The appointment status has already changed. Please refresh the page.'
                    ], 409);
                }

                return response()->json([
                    'success' => $status === 'Done'
                        ? 'Appointment marked as done successfully.'
                        : 'Appointment marked as no show successfully.'
                ]);
            }

            return response()->json([
                'error' => 'Invalid appointment status.'
            ], 422);

     }
    public function indexCalendarAppointment(){
        $this->autoCancelPastAppointments();

        $appointments = DB::connection('mysql')->table('appointment')
        ->whereNull('deleted_at')
        ->where('campus', session('campus'))
        ->get();
    
        $reserve = $appointments->map(function($appointment) {
        $fullname = date('h:i A', strtotime($appointment->time));
       
        
        return [
            'title' => $fullname,
            'date' => $appointment->date,
            'time' => $appointment->time,
            'status' => $appointment->status,
            'patientId' => $appointment->patientId,
            'purpose' => $appointment->purpose,
            'id' => $appointment->id, 
        ];
    });
    
    return view('pages.calendar-appointment', compact('reserve'));
    }

    public function AcceptAppointment(Request $request){

            $data = DB::connection('mysql')
            ->table('appointment')
            ->where('id', $request->id)
            ->update([
                'status' => 'Pending',
                'accepted_at' => Carbon::now('Asia/Manila')
            ]);

        return response()->json([
            'status' => 200,
            'message' => 'Accepted Successfully!'
        ]);
    }

    public function cancelAppointment(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:appointment,id',
            'date' => 'required|date',
            'time' => 'required',
        ]);

        $appointment = Appointment::find($request->id);

        if ($appointment) {
            $appointment->status = 'Cancelled';
            $appointment->save();

            return response()->json([
                'status' => 200,
                'message' => 'Appointment successfully cancelled.',
            ]);
        }

        return response()->json([
            'status' => 400,
            'error' => 'Appointment not found or cannot be cancelled.',
        ]);
    }
    public function updateStatus(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:appointment,id',
            'status' => 'required|in:Done,Reschedule',
        ]);
    
        $appointment = Appointment::find($request->id);
    
        if ($appointment) {
            $appointment->status = $request->status;
            $appointment->save();
    
            return response()->json([
                'status' => 200,
                'message' => "Appointment status updated to '{$request->status}'.",
            ]);
        }
    
        return response()->json([
            'status' => 400,
            'error' => 'Appointment not found or cannot be updated.',
        ]);
    }
    

    public function scheduleAppointment(Request $request){
        $request->validate([
            'id' => 'required|exists:appointment,id',
            'date' => 'required|date',
            'time' => 'required',
        ]);

        $appointment = Appointment::find($request->id);

        if ($appointment) {
            $appointment->status = 'Rescheduled';
            $appointment->save();

            return response()->json([
                'status' => 200,
                'message' => 'Appointment successfully Rescheduled.',
            ]);
        }

        return response()->json([
            'status' => 400,
            'error' => 'Appointment not found or cannot be cancelled.',
        ]);
    }

    public function markAsDone(Request $request){
        $request->validate([
            'id' => 'required|exists:appointment,id',
            'date' => 'required|date',
            'time' => 'required',
        ]);

        $appointment = Appointment::find($request->id);

        if ($appointment) {
            $appointment->status = 'Done';
            $appointment->save();

            return response()->json([
                'status' => 200,
                'message' => 'Appointment successful.',
            ]);
        }

        return response()->json([
            'status' => 400,
            'error' => 'Appointment not found or cannot be cancelled.',
        ]);
    }

    private function autoCancelPastAppointments()
    {
        $processedAt = Carbon::now('Asia/Manila');
        $pastDate = $processedAt->toDateString();

        DB::connection('mysql')
            ->table('appointment')
            ->where('campus', session('campus'))
            ->where('status', 'For Approval')
            ->whereNull('deleted_at')
            ->update([
                'status' => 'Pending',
                'updated_at' => $processedAt,
            ]);

        DB::connection('mysql')
            ->table('appointment')
            ->where('campus', session('campus'))
            ->whereDate('date', '<', $pastDate)
            ->where('status', 'Approved')
            ->whereNull('deleted_at')
            ->update([
                'status' => 'Done',
                'updated_at' => $processedAt,
            ]);

        DB::connection('mysql')
            ->table('appointment')
            ->where('campus', session('campus'))
            ->whereDate('date', '<', $pastDate)
            ->whereIn('status', ['Pending', 'For Approval', 'Rescheduled'])
            ->whereNull('deleted_at')
            ->update([
                'status' => 'Cancelled',
                'remarks' => 'Automatically cancelled because the appointment date has passed.',
                'updated_at' => $processedAt,
            ]);
    }

}

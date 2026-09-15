<?php

namespace App\Http\Controllers;

use App\Appointment;
use App\Doctor;
use App\DoctorLeave; 
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class DentalAppointmentController extends Controller
    {
    protected $services = [
        'Consultation' => 'Dental Check-up/ Consultation',
        'Oral Restoration' => 'Cavity Filling/ Oral Restoration',
        'Oral Prophylaxis' => 'Oral Prophylaxis',
        'Tooth Extraction' => 'Tooth Extraction',
    ];

    protected $timeSlots = [
        '09:00', '10:00',
        '13:00', '14:00', '15:00'
    ];

    protected $dailyStudentLimit = 6;

    protected $activeStatuses = [
        'Pending',
        'For Approval',
        'Approved',
        'Confirmed',
        'Rescheduled'
    ];

    public function create()
    {
        $this->updatePastAppointmentStatuses();

        $user = Auth::user();
        $patientId = null;

        if ($user) {
            $patientId = $user->patientId
                ?? $user->StudentNo
                ?? $user->AgencyNumber
                ?? session('patientId')
                ?? session('username');
        } else {
            $patientId = session('patientId') ?? session('username');
        }

        $patientId = $this->resolveEmployeeSessionPatientId($patientId);

        $services = $this->services;
        $patientDetails = $this->getPatientDetails($patientId);
        $upcomingAppointment = null;
        $latestAppointment = null;
        $hasActiveRequest = false;
        $confirmedAppointment = null;
        $leaveAnnouncements = DoctorLeave::with('doctor')
            ->where('campus', session('campus'))
            ->where('ends_on', '>=', Carbon::today()->toDateString())
            ->where('starts_on', '<=', Carbon::today()->addDays(30)->toDateString())
            ->orderBy('starts_on')
            ->get();

        if (session('confirmed_appointment_id')) {
            $confirmedAppointment = Appointment::find(
                session('confirmed_appointment_id')
            );
        }

        if ($patientId) {
            $hasActiveRequest = Appointment::where('patientId', $patientId)
                ->where('campus', session('campus'))
                ->whereNotIn(DB::raw('LOWER(TRIM(status))'), [
                    'done',
                    'completed',
                    'disapproved',
                    'cancelled',
                    'canceled',
                ])
                ->exists();

            $latestAppointment = Appointment::withTrashed()
                ->where('patientId', $patientId)
                ->where('campus', session('campus'))
                ->orderBy('created_at', 'desc')
                ->orderBy('id', 'desc')
                ->first();

            $upcomingAppointment = Appointment::where('patientId', $patientId)
                ->where('campus', session('campus'))
                ->whereIn(DB::raw('LOWER(TRIM(status))'), [
                    'pending',
                    'for approval',
                    'approved',
                    'confirmed',
                    'rescheduled',
                ])
                ->where('date', '>=', Carbon::today()->format('Y-m-d'))
                ->orderBy('created_at', 'desc')
                ->orderBy('id', 'desc')
                ->first();

        }

        return view('pages.appointment-dental', compact(
            'user',
            'services',
            'patientDetails',
            'upcomingAppointment',
            'latestAppointment',
            'hasActiveRequest',
            'confirmedAppointment',
            'leaveAnnouncements'
        ));
    }

    public function availableTimes(Request $request)
    {
        $request->validate([
            'date' => 'required|date|after_or_equal:today',
            'patient_type' => 'nullable|in:Student,Employee',
        ]);

        $selectedDate = Carbon::parse($request->date);
        $leaveStatus = $this->getClinicLeaveStatus($selectedDate);

        if ($selectedDate->isWeekend()) {
            return response()->json([
                'available_times' => [],
                'message' => 'The SLSU clinic is closed on weekends.'
            ]);
        }

        if ($leaveStatus['clinic_closed']) {
            return response()->json([
                'available_times' => [],
                'message' => 'No dental appointments are available because the dentist is on leave.',
                'announcement' => $leaveStatus['announcement'],
            ]);
        }

        if ($request->patient_type === 'Student') {
            $studentAppointments = Appointment::whereDate('date', $request->date)
                ->where('campus', session('campus'))
                ->whereRaw('LOWER(TRIM(role)) = ?', ['student'])
                ->whereIn(DB::raw('LOWER(TRIM(status))'), [
                    'pending', 'for approval', 'approved', 'confirmed', 'rescheduled',
                ])
                ->count();

            if ($studentAppointments >= $this->dailyStudentLimit) {
                return response()->json([
                    'available_times' => [],
                    'message' => 'This date has reached the daily limit of 6 student appointments. Please select another date.',
                    'announcement' => $leaveStatus['announcement'],
                ]);
            }
        }

        $bookedTimes = Appointment::whereDate('date', $request->date)
            ->whereIn('status', $this->activeStatuses)
            ->pluck('time')
            ->toArray();

        $availableTimes = [];

        foreach ($this->timeSlots as $time) {
            $databaseTime = $time . ':00';
            $schedule = Carbon::parse($request->date . ' ' . $time);

            if (!in_array($databaseTime, $bookedTimes) && $schedule->isFuture()) {
                $availableTimes[] = [
                    'value' => $time,
                    'label' => date('h:i A', strtotime($time))
                ];
            }
        }

        return response()->json([
            'available_times' => $availableTimes,
            'announcement' => $leaveStatus['announcement'],
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'service' => 'required|array|min:1',
            'service.*' => 'required|in:' . implode(',', array_keys($this->services)),
            'appointment_date' => 'required|date|after_or_equal:today',
            'appointment_time' => 'required|in:' . implode(',', $this->timeSlots),
            'patient_type' => 'required|in:Student,Employee',
            'patient_id' => 'required|max:100',
            'full_name' => 'required|max:255',
            'course_department' => 'nullable|max:255',
            'contact_number' => 'required|max:20',
            'reason_for_visit' => 'nullable|max:200',
            'additional_notes' => 'nullable|max:200'
        ], [
            'service.required' => 'Please select at least one dental service.',
            'appointment_time.required' => 'Please select an available time.'
        ]);

        $selectedDate = Carbon::parse($request->appointment_date);

        if ($selectedDate->isWeekend()) {
            return back()
                ->withInput()
                ->withErrors(['appointment_date' => 'The clinic is closed on weekends.']);
        }

        $user = Auth::user();
        $activeRequestPatientId = $user
            ? ($user->patientId
                ?? $user->StudentNo
                ?? $user->AgencyNumber
                ?? session('patientId')
                ?? session('username'))
            : (session('patientId') ?? session('username'));

        $activeRequestPatientId = $this->resolveEmployeeSessionPatientId(
            $activeRequestPatientId
        ) ?: $request->patient_id;

        $hasActiveRequest = Appointment::where('patientId', $activeRequestPatientId)
            ->where('campus', session('campus'))
            ->whereNotIn(DB::raw('LOWER(TRIM(status))'), [
                'done',
                'completed',
                'disapproved',
                'cancelled',
                'canceled',
            ])
            ->exists();

        if ($hasActiveRequest) {
            return back()
                ->withInput()
                ->withErrors([
                    'appointment_date' => 'You already have an active dental appointment request. You may request again after it is Done, Disapproved, or Cancelled.'
                ]);
        }

        if ($this->getClinicLeaveStatus($selectedDate)['clinic_closed']) {
            return back()
                ->withInput()
                ->withErrors(['appointment_date' => 'No dental appointments are available on this date because the dentist is on leave.']);
        }

        if ($request->patient_type === 'Student') {
            $studentAppointments = Appointment::whereDate('date', $request->appointment_date)
                ->where('campus', session('campus'))
                ->whereRaw('LOWER(TRIM(role)) = ?', ['student'])
                ->whereIn(DB::raw('LOWER(TRIM(status))'), [
                    'pending', 'for approval', 'approved', 'confirmed', 'rescheduled',
                ])
                ->count();

            if ($studentAppointments >= $this->dailyStudentLimit) {
                return back()
                    ->withInput()
                    ->withErrors([
                        'appointment_date' => 'This date has reached the daily limit of 6 student appointments. Please select another date.'
                    ]);
            }
        }

        $schedule = Carbon::parse(
            $request->appointment_date . ' ' . $request->appointment_time
        );

        if ($schedule->isPast()) {
            return back()
                ->withInput()
                ->withErrors(['appointment_time' => 'Please select a future schedule.']);
        }

        $existingAppointment = Appointment::whereDate('date', $request->appointment_date)
            ->whereTime('time', $request->appointment_time)
            ->whereIn('status', $this->activeStatuses)
            ->first();

        if ($existingAppointment) {
            return back()
                ->withInput()
                ->withErrors(['appointment_time' => 'This time is already booked.']);
        }

        $name = explode(' ', trim($request->full_name));
        $firstname = array_shift($name);
        $lastname = count($name) > 0 ? array_pop($name) : $firstname;
        $middlename = count($name) > 0 ? implode(' ', $name) : null;

        $remarks = '';

        if ($request->reason_for_visit) {
            $remarks .= 'Reason for Visit: ' . $request->reason_for_visit . "\n";
        }

        if ($request->additional_notes) {
            $remarks .= 'Additional Notes: ' . $request->additional_notes;
        }

        $appointment = Appointment::create([
            'patientId' => $request->patient_id,
            'contactNo' => preg_replace('/[^0-9]/', '', $request->contact_number),
            'lastname' => $lastname,
            'firstname' => $firstname,
            'middlename' => $middlename,
            'role' => $request->patient_type,
            'date' => $request->appointment_date,
            'time' => $request->appointment_time,
            'purpose' => $request->service,
            'status' => 'Pending',
            'remarks' => trim(substr($remarks, 0, 255)),
            'campus' => session('campus')
        ]);

        $email = $this->resolvePatientEmail(
            $activeRequestPatientId,
            $request->patient_type
        );

        if ($email) {
            try {
                $html = view('mail.dental-appointment-submitted', [
                    'appointment' => $appointment,
                    'patientName' => trim(implode(' ', array_filter([
                        $appointment->firstname,
                        $appointment->middlename,
                        $appointment->lastname,
                    ]))),
                    'services' => is_array($appointment->purpose)
                        ? implode(', ', $appointment->purpose)
                        : (string) $appointment->purpose,
                ])->render();

                Mail::send([], [], function ($message) use ($email, $html) {
                    $message->to($email)
                        ->from(
                            config('mail.from.address'),
                            config('mail.from.name')
                        )
                        ->subject('Dental Appointment Request Received')
                        ->setBody($html, 'text/html');
                });
            } catch (\Throwable $exception) {
                Log::warning('Dental appointment confirmation email failed.', [
                    'appointment_id' => $appointment->id,
                    'email' => $email,
                    'error' => $exception->getMessage(),
                ]);
            }
        }

        return redirect()
            ->route('dental.appointment.create')
            ->with('appointment_confirmed', true)
            ->with('confirmed_appointment_id', $appointment->id);
    }

    public function index()
    {
        $this->updatePastAppointmentStatuses();

        $user = Auth::user();
        $patientId = null;

        if ($user) {
            $patientId = $user->patientId
                ?? $user->StudentNo
                ?? $user->AgencyNumber
                ?? session('patientId'); 
        } else {
            $patientId = session('patientId');
        }

        $patientId = $this->resolveEmployeeSessionPatientId($patientId);
        $appointments = Appointment::withTrashed()
            ->when($patientId, function ($query) use ($patientId) {
                $query->where('patientId', $patientId);
            }, function ($query) {
                $query->whereRaw('1 = 0');
            })
            ->orderBy('date', 'desc')
            ->orderBy('time', 'desc')
            ->paginate(10);

        return view('dental.my-appointments', compact('appointments'));
    }

    public function history()
    {
        $this->updatePastAppointmentStatuses();

        $user = Auth::user();
        $patientId = null;

        if ($user) {
            $patientId = $user->patientId
                ?? $user->StudentNo
                ?? $user->AgencyNumber
                ?? session('patientId')
                ?? session('username');
        } else {
            $patientId = session('patientId') ?? session('username');
        }

        $patientId = $this->resolveEmployeeSessionPatientId($patientId);
        $canViewCampusHistory = in_array(session('role'), [
            'Admin',
            'Super Admin',
            'Nurse',
            'Nurse Attendant',
            'Doctor',
            'Dentist',
            'Attendant',
        ], true);

        $appointments = Appointment::withTrashed()
            ->when($canViewCampusHistory, function ($query) {
                $query->where('campus', session('campus'));
            }, function ($query) use ($patientId) {
                $query->when($patientId, function ($patientQuery) use ($patientId) {
                    $patientQuery->where('patientId', $patientId);
                }, function ($patientQuery) {
                    $patientQuery->whereRaw('1 = 0');
                });
            })
            ->whereDate('date', '<', Carbon::today('Asia/Manila')->toDateString())
            ->orderBy('date', 'desc')
            ->orderBy('time', 'desc')
            ->paginate(10);

        $historyOnly = true;

        return view('dental.my-appointments', compact('appointments', 'historyOnly'));
    }

    public function respondToReschedule(Request $request)
    {
        $validated = $request->validate([
            'appointment_id' => 'required|integer',
            'response' => 'required|in:accepted,declined',
        ]);

        $user = Auth::user();
        $patientId = $user
            ? ($user->patientId
                ?? $user->StudentNo
                ?? $user->AgencyNumber
                ?? session('patientId')
                ?? session('username'))
            : (session('patientId') ?? session('username'));
        $patientId = $this->resolveEmployeeSessionPatientId($patientId);

        $appointment = Appointment::where('id', $validated['appointment_id'])
            ->where('patientId', $patientId)
            ->where('campus', session('campus'))
            ->firstOrFail();

        if (strcasecmp((string) $appointment->status, 'Rescheduled') !== 0) {
            return response()->json([
                'message' => 'This appointment is no longer awaiting a reschedule response.',
            ], 422);
        }

        $attendanceAccepted = stripos(
            (string) $appointment->remarks,
            'Patient response: Accepted'
        ) !== false;

        if ($attendanceAccepted) {
            if ($validated['response'] === 'declined') {
                return response()->json([
                    'message' => 'Attendance was already confirmed and can no longer be cancelled here.',
                ], 422);
            }

            return response()->json([
                'message' => 'Your attendance was already confirmed.',
            ]);
        }

        $responseText = $validated['response'] === 'accepted'
            ? 'Patient response: Accepted'
            : 'Patient response: Unable to attend';

        $remarks = trim((string) preg_replace(
            '/\R?Patient response:.*$/is',
            '',
            (string) $appointment->remarks
        ));

        $appointment->remarks = $remarks
            . ($remarks === '' ? '' : PHP_EOL)
            . $responseText;

        $appointment->status = $validated['response'] === 'accepted'
            ? 'Approved'
            : 'Cancelled';

        $appointment->save();

        return response()->json([
            'message' => $validated['response'] === 'accepted'
                ? 'The assigned appointment schedule has been approved.'
                : 'The appointment was cancelled. You may now choose another schedule.',
        ]);
    }

    private function updatePastAppointmentStatuses()
    {
        $processedAt = Carbon::now('Asia/Manila');
        $pastDate = $processedAt->toDateString();

        DB::table('appointment')
            ->where('campus', session('campus'))
            ->where('status', 'For Approval')
            ->whereNull('deleted_at')
            ->update([
                'status' => 'Pending',
                'updated_at' => $processedAt,
            ]);

        DB::table('appointment')
            ->where('campus', session('campus'))
            ->whereDate('date', '<', $pastDate)
            ->where('status', 'Approved')
            ->whereNull('deleted_at')
            ->update([
                'status' => 'Done',
                'updated_at' => $processedAt,
            ]);

        DB::table('appointment')
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

    private function resolveEmployeeSessionPatientId($patientId)
    {
        if ($patientId || !session('employee_id')) {
            return $patientId;
        }

        $employee = DB::connection('hrmis')
            ->table('employee')
            ->where(function ($query) {
                $query->where('AgencyNumber', session('employee_id'))
                    ->orWhere('id', session('employee_id'));
            })
            ->when(session('campus'), function ($query) {
                $query->where('Campus', session('campus'));
            })
            ->whereNull('deleted_at')
            ->first();

        if (!$employee) {
            return null;
        }

        session([
            'patientId' => $employee->AgencyNumber,
            'patient_type' => 'Employee',
        ]);

        return $employee->AgencyNumber;
    }

    private function getClinicLeaveStatus(Carbon $date)
    {
        $campus = session('campus');
        $dentists = Doctor::where('campus', $campus)
            ->whereRaw('LOWER(specialization) = ?', ['dentist'])
            ->get();

        if ($dentists->isEmpty()) {
            return ['clinic_closed' => false, 'announcement' => null];
        }

        $leaves = DoctorLeave::with('doctor')
            ->where('campus', $campus)
            ->whereIn('doctor_id', $dentists->pluck('id'))
            ->whereDate('starts_on', '<=', $date->toDateString())
            ->whereDate('ends_on', '>=', $date->toDateString())
            ->get();

        if ($leaves->isEmpty()) {
            return ['clinic_closed' => false, 'announcement' => null];
        }

        $doctorNames = $leaves->map(function ($leave) {
            if (!$leave->doctor) return null;
            return trim('Dr. '.$leave->doctor->FirstName.' '.$leave->doctor->LastName);
        })->filter()->unique()->values()->all();

        $customAnnouncements = $leaves->pluck('announcement')->filter()->unique()->implode(' ');
        $announcement = $customAnnouncements ?: implode(', ', $doctorNames).' '.(count($doctorNames) === 1 ? 'is' : 'are').' on leave.';

        return [
            'clinic_closed' => $leaves->pluck('doctor_id')->unique()->count() >= $dentists->count(),
            'announcement' => $announcement,
        ];
    }

    private function getPatientDetails($patientId)
    {
        $details = [
            'full_name' => '',
            'patient_id' => $patientId ?: '',
            'patient_type' => '',
            'course_department' => '',
            'contact_number' => '',
        ];

        if (!$patientId) {
            return $details;
        }

        $patientType = ucfirst(strtolower(trim((string) session('patient_type'))));

        if (!in_array($patientType, ['Employee', 'Student'], true)) 
            {
                $patientType = session('employee_id') ? 'Employee': (session('student_no') ? 'Student' : null);
            }

        if (!$patientType) {
            if (DB::table('employee_info')->where('username', $patientId)->exists()) {
                $patientType = 'Employee';
            } elseif (DB::table('student_info')->where('username', $patientId)->exists()) {
                $patientType = 'Student';
            }
        }

        if ($patientType === 'Employee') {
            $employee = DB::connection('hrmis')
                ->table('employee as e')
                ->select('e.*', 'd.DepartmentName')
                ->leftJoin('department as d', 'd.id', '=', 'e.Department')
                ->where('e.AgencyNumber', $patientId)
                ->when(session('campus'), function ($query) {
                    $query->where('e.Campus', session('campus'));
                })
                ->first();

            if (!$employee) {
                return $details;
            }

            $details['full_name'] = trim(implode(' ', array_filter([
                $employee->FirstName ?? '',
                $employee->MiddleName ?? '',
                $employee->LastName ?? '',
            ])));
            $details['patient_id'] = $employee->AgencyNumber;
            $details['patient_type'] = 'Employee';
            $details['course_department'] = $employee->DepartmentName ?? '';
            $details['contact_number'] = $employee->Cellphone ?? '';

            return $details;
        }

        if ($patientType === 'Student') {
            $year = (int) date('Y');
            $month = (int) date('n');
            $schoolYears = $month >= 6 ? [$year, $year - 1] : [$year - 1];
            $semesters = $month >= 6 ? [1, 9] : [2];
            $connection = MedClientAddController::getCampusConnection();

            $student = DB::connection($connection)
                ->table('students as s')
                ->select(
                    's.*',
                    'r.SchoolLevel',
                    'r.SchoolYear',
                    'r.Semester',
                    'r.StudentYear',
                    'c.accro'
                )
                ->leftJoin('registration as r', 's.StudentNo', '=', 'r.StudentNo')
                ->leftJoin('course as c', 'c.id', '=', 'r.Course')
                ->where('s.StudentNo', $patientId)
                ->whereIn('r.SchoolLevel', [
                    'Under Graduate', 'Masteral', 'Doctoral', 'Highschool',
                    'Senior High', 'Cross Enrolment'
                ])
                ->where('s.notuse', 0)
                ->where('r.finalize', 1)
                ->whereIn('r.SchoolYear', $schoolYears)
                ->whereIn('r.Semester', $semesters)
                ->where(function ($query) {
                    $query->where('s.bor', '')->orWhereNull('s.bor');
                })
                ->orderBy('r.SchoolYear', 'desc')
                ->orderBy('r.Semester', 'desc')
                ->first();

            if (!$student) {
                return $details;
            }

            $details['full_name'] = trim(implode(' ', array_filter([
                $student->FirstName ?? '',
                $student->MiddleName ?? '',
                $student->LastName ?? '',
            ])));
            $details['patient_id'] = $student->StudentNo;
            $details['patient_type'] = 'Student';
            $details['course_department'] = trim(($student->accro ?? '') .
                ($student->StudentYear ? ' - ' . $student->StudentYear : ''));
            $details['contact_number'] = $student->ContactNo ?? '';
        }

        return $details;
    }

    private function resolvePatientEmail($patientId, $patientType)
    {
        if (!$patientId) {
            return null;
        } 

        if (strcasecmp((string) $patientType, 'Employee') === 0) {
            $email = DB::table('employee_info')
                ->where(function ($query) use ($patientId) {
                    $query->where('AgencyNumber', $patientId)
                        ->orWhere('username', $patientId);
                })
                ->when(session('campus'), function ($query) {
                    $query->where('campus', session('campus'));
                })
                ->value('EmailAddress');

            return filter_var($email, FILTER_VALIDATE_EMAIL) ? $email : null;
        }

        $email = DB::table('student_info')
            ->where(function ($query) use ($patientId) {
                $query->where('StudentNo', $patientId)
                    ->orWhere('username', $patientId);
            })
            ->when(session('campus'), function ($query) {
                $query->where('campus', session('campus'));
            })
            ->value('emailAdd');

        return filter_var($email, FILTER_VALIDATE_EMAIL) ? $email : null;
    }
}

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
use App\Http\Controllers\AESCipher;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Schema;

class UserController extends Controller
{
    public function index(){
      $this->authorizeAccountManagement();

      $pageConfigs = ['pageHeader' => true];
      $breadcrumbs = [
        ["link" => "/", "name" => "Home"],["name" => "Clinic Accounts"]
      ];

      $search = trim(request('search', ''));
      $employees = DB::table('employee_info as employee')
        ->leftJoin('account as account', function ($join) {
          $join->on('account.employee_id', '=', 'employee.id')
            ->where('account.campus', '=', session('campus'))
            ->whereNull('account.deleted_at');
        })
        ->where('employee.campus', session('campus'))
        ->when($search === '', function ($query) {
          $query->whereRaw('1 = 0');
        })
        ->when($search !== '', function ($query) use ($search) {
          $query->where(function ($employeeQuery) use ($search) {
            $employeeQuery->where('employee.FirstName', 'like', "%{$search}%")
              ->orWhere('employee.MiddleName', 'like', "%{$search}%")
              ->orWhere('employee.LastName', 'like', "%{$search}%")
              ->orWhere('employee.AgencyNumber', 'like', "%{$search}%")
              ->orWhere('employee.EmailAddress', 'like', "%{$search}%");
          });
        })
        ->select(
          'employee.id',
          'employee.AgencyNumber',
          'employee.FirstName',
          'employee.MiddleName',
          'employee.LastName',
          'employee.EmailAddress',
          'account.role as clinic_role'
        )
        ->orderBy('employee.LastName')
        ->orderBy('employee.FirstName')
        ->paginate(12)
        ->appends(['search' => $search]);

      return view('pages.clinic-account-search', compact('pageConfigs', 'breadcrumbs', 'employees', 'search'));
    }

    public function searchEmployees(Request $request)
    {
      $this->authorizeAccountManagement();

      $search = trim($request->get('q', ''));
      if ($search === '') {
        return response()->json([]);
      }

      $employees = DB::table('employee_info')
        ->where('campus', session('campus'))
        ->where(function ($query) use ($search) {
          $query->where('FirstName', 'like', "%{$search}%")
            ->orWhere('MiddleName', 'like', "%{$search}%")
            ->orWhere('LastName', 'like', "%{$search}%")
            ->orWhere('AgencyNumber', 'like', "%{$search}%")
            ->orWhere('EmailAddress', 'like', "%{$search}%");
        })
        ->select('id', 'AgencyNumber', 'FirstName', 'MiddleName', 'LastName', 'EmailAddress')
        ->orderBy('LastName')
        ->orderBy('FirstName')
        ->get()
        ->map(function ($employee) {
          return [
            'name' => trim($employee->FirstName.' '.$employee->MiddleName.' '.$employee->LastName),
            'employee_id' => $employee->AgencyNumber,
            'email' => $employee->EmailAddress,
            'url' => route('clinic-accounts.manage', $employee->id),
          ];
        });

      return response()->json($employees);
    }

    public function manage($employee){
      $this->authorizeAccountManagement();

      $employeeRecord = DB::table('employee_info')
        ->where('id', $employee)
        ->where('campus', session('campus'))
        ->first();

      abort_if(!$employeeRecord, 404, 'Employee not found.');

      $accounts = DB::table('account')
        ->where('employee_id', $employeeRecord->id)
        ->whereNull('deleted_at')
        ->whereIn('campus', [1, 2, 3, 4, 5, 6])
        ->get();

      $account = $accounts->firstWhere('campus', session('campus')) ?: $accounts->first();
      $accountCampusIds = $accounts->pluck('campus')->map(function ($campus) {
        return (int) $campus;
      })->all();

      $roles = ['Admin', 'Attendant', 'Dentist', 'Doctor', 'Nurse', 'Nurse Attendant'];
      $supportsAccessPeriod = Schema::hasColumn('account', 'access_start')
        && Schema::hasColumn('account', 'access_end');
      $pageConfigs = ['pageHeader' => true];
      $breadcrumbs = [
        ['link' => '/', 'name' => 'Home'],
        ['link' => route('clinic-accounts.index'), 'name' => 'Clinic Accounts'],
        ['name' => $account ? 'Manage Role' : 'Register Account'],
      ];

      return view('pages.clinic-account-manage', compact(
        'pageConfigs', 'breadcrumbs', 'employeeRecord', 'account', 'accountCampusIds', 'roles', 'supportsAccessPeriod'
      ));
    }

    public function saveAccount(Request $request, $employee){
      $this->authorizeAccountManagement();

      $employeeRecord = DB::table('employee_info')
        ->where('id', $employee)
        ->where('campus', session('campus'))
        ->first();

      abort_if(!$employeeRecord, 404, 'Employee not found.');

      $validated = $request->validate([
        'role' => ['required', Rule::in(['Admin', 'Attendant', 'Dentist', 'Doctor', 'Nurse', 'Nurse Attendant'])],
        'campuses' => ['required', 'array', 'min:1'],
        'campuses.*' => ['integer', Rule::in([1, 2, 3, 4, 5, 6])],
        'access_start' => ['nullable', 'date'],
        'access_end' => ['nullable', 'date', 'after_or_equal:access_start'],
      ]);

      $accountValues = [
        'firstname' => $employeeRecord->FirstName,
        'middlename' => $employeeRecord->MiddleName,
        'lastname' => $employeeRecord->LastName,
        'email' => $employeeRecord->EmailAddress,
        'role' => $validated['role'],
        'deleted_at' => null,
        'updated_at' => Carbon::now('Asia/Manila'),
      ];

      if (Schema::hasColumn('account', 'access_start') && Schema::hasColumn('account', 'access_end')) {
        $accountValues['access_start'] = $validated['access_start'] ?? null;
        $accountValues['access_end'] = $validated['access_end'] ?? null;
      }

      $selectedCampuses = collect($validated['campuses'])->map(function ($campus) {
        return (int) $campus;
      })->unique()->values();

      DB::transaction(function () use ($employeeRecord, $accountValues, $selectedCampuses) {
        foreach ($selectedCampuses as $campus) {
          DB::table('account')->updateOrInsert(
            ['employee_id' => $employeeRecord->id, 'campus' => $campus],
            $accountValues
          );
        }

        DB::table('account')
          ->where('employee_id', $employeeRecord->id)
          ->whereIn('campus', [1, 2, 3, 4, 5, 6])
          ->whereNotIn('campus', $selectedCampuses->all())
          ->whereNull('deleted_at')
          ->update([
            'deleted_at' => Carbon::now('Asia/Manila'),
            'updated_at' => Carbon::now('Asia/Manila'),
          ]);
      });

      return redirect()->route('clinic-accounts.index', ['search' => $employeeRecord->AgencyNumber])
        ->with('success', 'Clinic account role and campus access saved successfully.');
    }

    private function authorizeAccountManagement()
    {
      abort_unless(in_array(session('role'), ['Admin', 'Super Admin'], true), 403, 'You are not allowed to manage clinic accounts.');
    }
#add user 
    public function addUser(Request $request){
      $user = DB::table('account')
        ->insert([
          'employee_id' =>$request->employee_id,
          'firstname' =>$request->firstname,
          'middlename' =>$request->middlename,
          'lastname' =>$request->lastname,
          'email' =>$request->email,
          'role' =>$request->role,
          'campus' => session('campus'),
          'created_at' => Carbon::now()
        ]);

      return response()->json([
          'success'   => 'Saved Successfully!'
      ]);
    }   
#view user
    public function viewUser(Request $request) {

      $viewModal = DB::table('account')
        ->where('employee_id',$request->employee_id)
        ->where('campus', session('campus'))
        ->first();
  
      return response()->json($viewModal);
    }
#update
    public function update(Request $request) {
      
      $viewModal = DB::table('account')
        ->where('campus',session('campus'))
        ->where('employee_id',$request->employee_id)
        ->update([
          'employee_id' =>$request->employee_id,
          'firstname' =>$request->firstname,
          'middlename' =>$request->middlename,
          'lastname' =>$request->lastname,
          'email' =>$request->email,
          'role' =>$request->role,
          'updated_at' => Carbon::now()
        ]);
  
      return response()->json($viewModal);
    }

#delete
public function deleteUser(Request $request){

       DB::table('account')
        ->where('employee_id', $request->id)
        ->where('campus',session('campus'))
        ->update([
            'deleted_at' =>  Carbon::now('Asia/Manila'),
        ]);

        return response()->json(['message' => 'Deleted successfully']);
    }



    
}

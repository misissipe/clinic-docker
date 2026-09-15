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
          $query->whereNotNull('account.employee_id');
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
          DB::raw("GROUP_CONCAT(DISTINCT account.role ORDER BY account.role SEPARATOR ', ') as clinic_role")
        )
        ->groupBy(
          'employee.id',
          'employee.AgencyNumber',
          'employee.FirstName',
          'employee.MiddleName',
          'employee.LastName',
          'employee.EmailAddress'
        )
        ->orderBy('employee.LastName')
        ->orderBy('employee.FirstName')
        ->get();

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

      $roles = ['Admin', 'Attendant', 'Dentist', 'Doctor', 'Nurse', 'Nurse Attendant'];
      $roleAssignments = collect($roles)->mapWithKeys(function ($role) use ($accounts) {
        $roleAccounts = $accounts->filter(function ($account) use ($role) {
          return in_array($role, RoleController::accountRoles($account->role), true);
        });

        return [$role => [
          'selected' => $roleAccounts->isNotEmpty(),
          'campuses' => $roleAccounts->pluck('campus')->map(function ($campus) {
            return (int) $campus;
          })->unique()->values()->all(),
        ]];
      })->all();

      $account = $accounts->first();
      $supportsAccessPeriod = Schema::hasColumn('account', 'access_start')
        && Schema::hasColumn('account', 'access_end');
      $pageConfigs = ['pageHeader' => true];
      $breadcrumbs = [
        ['link' => '/', 'name' => 'Home'],
        ['link' => route('clinic-accounts.index'), 'name' => 'Clinic Accounts'],
        ['name' => $account ? 'Manage Role' : 'Register Account'],
      ];

      return view('pages.clinic-account-manage', compact(
        'pageConfigs', 'breadcrumbs', 'employeeRecord', 'account', 'roles', 'roleAssignments', 'supportsAccessPeriod'
      ));
    }

    public function saveAccount(Request $request, $employee){
      $this->authorizeAccountManagement();

      $employeeRecord = DB::table('employee_info')
        ->where('id', $employee)
        ->where('campus', session('campus'))
        ->first();

      abort_if(!$employeeRecord, 404, 'Employee not found.');

      $allowedRoles = ['Admin', 'Attendant', 'Dentist', 'Doctor', 'Nurse', 'Nurse Attendant'];

      $validated = $request->validate([
        'assignments' => ['required', 'array'],
        'assignments.*.selected' => ['nullable', 'accepted'],
        'assignments.*.campuses' => ['nullable', 'array'],
        'assignments.*.campuses.*' => ['integer', Rule::in([1, 2, 3, 4, 5, 6])],
        'access_start' => ['nullable', 'date'],
        'access_end' => ['nullable', 'date', 'after_or_equal:access_start'],
      ]);

      $selectedAssignments = collect($validated['assignments'])
        ->only($allowedRoles)
        ->filter(function ($assignment) {
          return !empty($assignment['selected']);
        });

      if ($selectedAssignments->isEmpty()) {
        return back()->withInput()->withErrors(['assignments' => 'Select at least one account role.']);
      }

      foreach ($selectedAssignments as $role => $assignment) {
        if (empty($assignment['campuses'])) {
          return back()->withInput()->withErrors([
            "assignments.{$role}.campuses" => "Select at least one campus for {$role}.",
          ]);
        }

      }

      $accountValues = [
        'firstname' => $employeeRecord->FirstName,
        'middlename' => $employeeRecord->MiddleName,
        'lastname' => $employeeRecord->LastName,
        'email' => $employeeRecord->EmailAddress,
        'deleted_at' => null,
        'updated_at' => Carbon::now('Asia/Manila'),
      ];

      $supportsAccessPeriod = Schema::hasColumn('account', 'access_start')
        && Schema::hasColumn('account', 'access_end');

      // Group all selected roles by campus so each employee/campus has one row.
      $rolesByCampus = [];
      foreach ($selectedAssignments as $role => $assignment) {
        foreach ($assignment['campuses'] as $campus) {
          $rolesByCampus[(int) $campus][] = $role;
        }
      }

      DB::transaction(function () use ($employeeRecord, $accountValues, $rolesByCampus, $supportsAccessPeriod, $validated) {
        DB::table('account')
          ->where('employee_id', $employeeRecord->id)
          ->whereIn('campus', [1, 2, 3, 4, 5, 6])
          ->whereNotIn('campus', array_keys($rolesByCampus))
          ->whereNull('deleted_at')
          ->update([
            'deleted_at' => Carbon::now('Asia/Manila'),
            'updated_at' => Carbon::now('Asia/Manila'),
          ]);

        foreach ($rolesByCampus as $campus => $selectedRoles) {
          $selectedRoles = array_values(array_unique($selectedRoles));
          $hasAdminRole = in_array('Admin', $selectedRoles, true);

          $values = array_merge($accountValues, [
            'role' => json_encode($selectedRoles),
          ]);

          if ($supportsAccessPeriod) {
            $values['access_start'] = $hasAdminRole ? null : ($validated['access_start'] ?? null);
            $values['access_end'] = $hasAdminRole ? null : ($validated['access_end'] ?? null);
          }

          DB::table('account')->updateOrInsert(
            ['employee_id' => $employeeRecord->id, 'campus' => $campus],
            $values
          );
        }
      });

      return redirect()->route('clinic-accounts.manage', $employeeRecord->id)
        ->with('success', 'Clinic account roles and access period saved successfully.');
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

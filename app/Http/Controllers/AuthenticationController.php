<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\AESCipher;
use lluminate\Database\Query\Builder;
use Carbon\Carbon;
use App\Http\Controllers\MedClientAddController;
use Socialite;
use EmployeeHRMIS;

class AuthenticationController extends Controller
{
  //Login page
  // public function loginPage(){
  //   $pageConfigs = ['bodyCustomClass'=> 'bg-full-screen-image'];
  //   return view('pages.auth-login',['pageConfigs' => $pageConfigs]);
 // }
  //Register page
  // public function registerPage(){
  //   $pageConfigs = ['bodyCustomClass'=> 'bg-full-screen-image'];
  //   return view('pages.auth-register',['pageConfigs' => $pageConfigs]);
  // }
  //  //forget Password page
  //  public function forgetPasswordPage(){
  //   $pageConfigs = ['bodyCustomClass'=> 'bg-full-screen-image'];
  //   return view('pages.auth-forgot-password',['pageConfigs' => $pageConfigs]);
  // }
  //  //reset Password page
  //  public function resetPasswordPage(){
  //   $pageConfigs = ['bodyCustomClass'=> 'bg-full-screen-image'];
  //   return view('pages.auth-reset-password',['pageConfigs' => $pageConfigs]);
  // }
  //  //auth lock page
  //  public function authLockPage(){
  //   $pageConfigs = ['bodyCustomClass'=> 'bg-full-screen-image'];
  //   return view('pages.auth-lock-screen',['pageConfigs' => $pageConfigs]);
  // }
  // public function adminlogin(Request $request){
  //     $email = $request->email;
  //     $password = $request->password;
  //     $login = Http::post(env('APP_API                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                   '). "/api/login", [
  //       'email' => $email,
  //       'password' => $password,
  //     ])->json();
  //    if($login){
  //       if ($login['status'] == 200) {
  //         session([
  //           'token' => $login['data']['token'],
  //           'email' => $login['data']['email'],
  //         ]);
  //         return redirect('/');
  //       }
  //       if($login['status'] == 400){
  //         $error = $login['message'];
  //        // return redirect()->route('admin.login')->with( ['error' => $error ] );
  //         return view('pages.auth-lock-screen', compact('error'));
  //       }
  //     }
  // }


   public function authpatientLockPage(){
    $pageConfigs = ['bodyCustomClass'=> 'bg-full-screen-image'];
    return view('pages.patient-login',['pageConfigs' => $pageConfigs]);
  }

  public function authpatientSignUp(Request $request)
{
    $role = $request->role;

    $tables = [
        'Student'  => 'student_info',
        'Employee' => 'employee_info',
    ];

    $columns = [
        'Student'  => 'StudentNo',
        'Employee' => 'AgencyNumber',
    ];

    if (isset($tables[$role])) {

        $user = DB::connection('mysql')
            ->table($tables[$role])
            ->where($columns[$role], $request->username)
            ->where('campus', '1')
            ->update([
                'username' => $request->username,
                'password' => Hash::make($request->password),
                'account_created_at' => Carbon::today('Asia/Manila'),
            ]);

    }

    session([
        'role' => 'Appointment',
        'campus' => '1',
    ]);

    return redirect('/patient-appointment-dashboard');
}

  public function patientLogin(Request $request){
    $pageConfigs = ['bodyCustomClass'=> 'bg-full-screen-image'];

          $schoolyr = date('Y');
          $current_month = date('n');
       if ($current_month >= 6 && $current_month <= 12) {
            $semester = [1, 9];
            $schoolyr_start = [$schoolyr, $schoolyr - 1]; 
        } else {
            $semester = [2];
            $schoolyr_start = [$schoolyr - 1]; 
        }

        $connection = MedClientAddController::getCampusConnection();

    $idnumber = $request->username;
    $role = $request->role;
     
    if($role === 'Student'){

      $check = DB::connection($connection)
            ->table('registration as r')
            ->select(
                'c.id','c.course_title','c.accro','s.*','r.StudentNo',
                'r.Course','m.course_major','r.StudentYear','r.SchoolYear','r.Semester',
                'r.SchoolLevel','r.finalize','r.StudentStatus'
            )
            ->join('students as s', 'r.StudentNo', '=', 's.StudentNo')
            ->join('course as c', 'c.id', '=', 'r.Course')
            ->join('major as m', 'm.id', '=', 's.Major')
            ->where('r.StudentNo', $idnumber)
            ->where('r.SchoolYear', $schoolyr_start)
            ->where('r.Semester', $semester)
            ->orderBy('r.SchoolYear', 'desc')
            ->first();


       
    }elseif($role === 'Employee'){
      $check = DB::connection('hrmis')->table('employee')->where('AgencyNumber', $idnumber)->first();
    }

    $tables = [
        'Student'  => 'student_info',
        'Employee' => 'employee_info',
    ];
   
      if (!empty(isset($tables[$role]))){
      $login = DB::connection('mysql')->table($tables[$role])->where('username',$request->username)->where('password', $request->password)->wher('campus', '1')->first();
      }


    session([
            'username' => $request->username,
            'patientId' => $request->username,
            'password' => $request->password,
            'patient_type' => $role,
            'role' => 'Appointment',
            'campus' => '1',
          ]);

    return view('pages.appointment-patient-dashboard',['pageConfigs' => $pageConfigs]);
  }

   

  //frontend
  public function logout(){
    if (!empty(session('employee_id')) && !empty(session('available_workspaces'))) {
      session()->forget([
        'role',
        'campus',
        'access_start',
        'access_end',
        'unlimited_access',
      ]);

      return redirect()->route('workspace.choose');
    }

    session()->flush();
    return redirect('/login');
  }

  public function fullLogout(){
      session()->flush();
      return redirect('/login');
  }
  
  public function loginPage()
  {
    if (!empty(session('token'))) {
      return redirect('/');
    }
    $pageConfigs = ['bodyCustomClass' => 'bg-full-screen-image'];
    return view('pages.login', ['pageConfigs' => $pageConfigs]);
  }

  //Redirect to Google
  public function redirectToGoogle()
  {
    return Socialite::driver('google')->redirect();
  }

  
  public function handleGoogleCallback($retry=0)
  {
  
    try { 
      $user = Socialite::driver('google')->user(); 
 
      if($user){
        $email = $user->email;
       
        //  dd($findemployee);  
        // $login = Http::post(env('APP_API'). "/api/loginbygoogle",['email' => $email])->json();
       
        $findemployee = DB::connection('hrmis')->table('employee')->where('EmailAddress', $email)->first();
        if(!empty($findemployee)){
          if($findemployee){
            
            $accounts = DB::connection('mysql')->table('account')
              ->where(function ($query) use ($findemployee, $email) {
                $query->whereRaw('LOWER(TRIM(email)) = ?', [strtolower(trim($email))])
                  ->orWhere('employee_id', $findemployee->id);

                if (!empty($findemployee->AgencyNumber)) {
                  $query->orWhere('employee_id', $findemployee->AgencyNumber);
                }
              })
              ->whereNull('deleted_at')
              ->get();
            $found = $accounts->first();
            $administratorAccount = $accounts->first(function ($account) {
              return in_array('Admin', RoleController::accountRoles($account->role), true);
            });
            // $guest = 'jroa@southernleytestateu.edu.ph';

            if ($found) {
              if($administratorAccount){
                session([
                  'employee_id' => $findemployee->id,  
                  'name' => $findemployee->FirstName." ".$findemployee->MiddleName." ".$findemployee->LastName,
                  'firstname' => $findemployee->FirstName,
                  'lastname' =>$findemployee->LastName,
                  'department_id' => $findemployee->Department,
                  'photo' => $findemployee->profilephoto,
                  'role' => 'Admin',
                  'campus' => 1,
                ]);
              }
              // elseif($found->email === $guest ){
              //   session([
              //     'employee_id' => $findemployee->id,  
              //     'name' => $findemployee->FirstName." ".$findemployee->MiddleName." ".$findemployee->LastName,
              //     'firstname' => $findemployee->FirstName,
              //     'lastname' =>$findemployee->LastName,
              //     'department_id' => $findemployee->Department,
              //     'photo' => $findemployee->profilephoto,
              //     'role' => 'Guest',
              //     'campus' => 7,
              //   ]);
              // }
              else{ 
                $db = $accounts->firstWhere('email', $email) ?: $found;

                //  dd($db);

                session([
                  'employee_id' => $findemployee->id,
                  'name' => $findemployee->FirstName." ".$findemployee->MiddleName." ".$findemployee->LastName,
                  'firstname' => $findemployee->FirstName,
                  'lastname' =>$findemployee->LastName,
                  'department_id' => $findemployee->Department,
                  'photo' => $findemployee->profilephoto,
                  'role' => $db ->role,
                  'campus' => $db->campus,
                ]);
              }

              $today = Carbon::today('Asia/Manila');
              $workspaces = RoleController::assignedWorkspaces($accounts, $today);

              if ($administratorAccount) {
                $workspaces = RoleController::administratorWorkspaces($administratorAccount->campus);
              }

              if (!empty($workspaces)) {
                session(['available_workspaces' => $workspaces]);
                session()->forget('role');

                return redirect()->route('workspace.choose');
              }

              session()->forget(['available_workspaces', 'role', 'campus']);

              return redirect('/login')->withErrors([
                'access' => 'No active clinic workspace is available. Please check the account role and access dates.',
              ]);
            }
            return redirect('/login')->withErrors([
              'access' => 'No active clinic account was found.',
            ]);
          }
        }   
        $pageConfigs = ['bodyCustomClass' => 'bg-full-screen-image'];
        return view('pages.auth-login', ['pageConfigs' => $pageConfigs]);

      }
    } catch (\Throwable $th) {
      report($th);

      session()->forget(['available_workspaces', 'role', 'campus']);

      return redirect('/login')->withErrors([
        'access' => 'Sign-in could not prepare your clinic workspaces. Please try again.',
      ]);
    }
  }
}

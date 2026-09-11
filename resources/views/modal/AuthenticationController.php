<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\AESCipher;
use lluminate\Database\Query\Builder;
use Carbon\Carbon;
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


  //frontend
  public function logout(){
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
            
            $found = DB::connection('mysql')->table('account')->where('employee_id',$findemployee->id)->first();

            $admin = 'cperioles@southernleytestateu.edu.ph';

            if ($found) {
              if($found->email === $admin ){

                session([
                  'employee_id' => $findemployee->id,  
                  'name' => $findemployee->FirstName." ".$findemployee->MiddleName." ".$findemployee->LastName,
                  'firstname' => $findemployee->FirstName,
                  'lastname' =>$findemployee->LastName,
                  'department_id' => $findemployee->Department,
                  'photo' => $findemployee->profilephoto,
                  'role' => 'Admin',
                  'campus' => 2,
                ]);

              }else{ 

                $db = DB::connection('mysql')->table('account')->where('email',$email)->first();

                session([
                  'employee_id' => $findemployee->id,
                  'name' => $findemployee->FirstName." ".$findemployee->MiddleName." ".$findemployee->LastName,
                  'firstname' => $findemployee->FirstName,
                  'lastname' =>$findemployee->LastName,
                  'department_id' => $findemployee->Department,
                  'photo' => $findemployee->profilephoto,
                  'role' => $db ->role,
                  'campus' => $findemployee->Campus,
                ]);
              }
    
            }  else {
              $role = "Employee";
              $user = DB::connection('mysql')
                ->table('account')
                ->insert([
                  'employee_id' =>$findemployee->id,
                  'firstname' =>$findemployee->FirstName,
                  'middlename' =>$findemployee->MiddleName,
                  'lastname' =>$findemployee->LastName,
                  'email' =>$email,
                  'role' =>$role,
                  'campus' =>$findemployee->Campus,
                  'created_at' => Carbon::today('Asia/Manila')
                ]);

            }
            return redirect('/');
          }
        }
        $pageConfigs = ['bodyCustomClass' => 'bg-full-screen-image'];
        return view('pages.auth-login', ['pageConfigs' => $pageConfigs]);

      }
    } catch (\Throwable $th) {

     if($retry>0){
      return handleGoogleCallback($retry+1);
     }
      dd('error',$th);
    }
  }


}

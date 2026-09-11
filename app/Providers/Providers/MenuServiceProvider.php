<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class MenuServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {   // get all data from menu.json file


        view()->composer('*', function ($view) 
        {   

         
            $verticalMenuData = "";
            // if (!empty(session('role'))){
            //     $role =  session('role');
            // }
            $verticalMenuJson = '';
            $verticalMenuData = '';

            
           if (session('role') == 'Admin' ){
                $verticalMenuJson = file_get_contents(base_path('resources/data/menus/vertical-menu.json'));
                $verticalMenuData = json_decode($verticalMenuJson);
            } elseif (session('role') == 'Super Admin' ){
                $verticalMenuJson = file_get_contents(base_path('resources/data/menus/vertical-menu.json'));
                $verticalMenuData = json_decode($verticalMenuJson);
            }   elseif (session('role') == 'Nurse'){
                $verticalMenuJson = file_get_contents(base_path('resources/data/menus/nurse-menu.json'));
                $verticalMenuData = json_decode($verticalMenuJson);
            }   elseif  (session('role') == 'Nurse Attendant'){ 
                $verticalMenuJson = file_get_contents(base_path('resources/data/menus/nurse-attendant-menu.json'));
                $verticalMenuData = json_decode($verticalMenuJson);
            }  elseif (session('role') == 'Doctor'){
                $verticalMenuJson = file_get_contents(base_path('resources/data/menus/doctor-menu.json'));
                $verticalMenuData = json_decode($verticalMenuJson);
            }  elseif (session('role') == 'Dentist'){
                $verticalMenuJson = file_get_contents(base_path('resources/data/menus/dentist-menu.json'));
                $verticalMenuData = json_decode($verticalMenuJson);
            }  elseif (session('role') == 'Attendant'){
                $verticalMenuJson = file_get_contents(base_path('resources/data/menus/attendant-menu.json'));
                $verticalMenuData = json_decode($verticalMenuJson);
            }   elseif (session('role') == 'Employee'){
                $verticalMenuJson = file_get_contents(base_path('resources/data/menus/employee-menu.json'));
                $verticalMenuData = json_decode($verticalMenuJson);
            }  elseif (session('role') == 'Guest'){
                $verticalMenuJson = file_get_contents(base_path('resources/data/menus/guest-menu.json'));
                $verticalMenuData = json_decode($verticalMenuJson);
            }  


    //HORIZONTAL 
            $horizontalMenuJson = file_get_contents(base_path('resources/data/menus/horizontal-menu.json'));
            $horizontalMenuData = json_decode($horizontalMenuJson);
            $verticalMenuBoxiconsJson = file_get_contents(base_path('resources/data/menus/vertical-menu-boxicons.json'));
            $verticalMenuBoxiconsData = json_decode($verticalMenuBoxiconsJson);
            // $verticalOverlayMenu = file_get_contents(base_path('resources/data/menus/vertical-overlay-menu.json'));
            // $verticalOverlayMenuData = json_decode($verticalOverlayMenu);

            // share all menuData to all the views
            \View::share('menuData',[$verticalMenuData, $horizontalMenuData,$verticalMenuBoxiconsData]);
        });      
        // $verticalOverlayMenu = file_get_contents(base_path('resources/data/menus/vertical-overlay-menu.json'));
        // $verticalOverlayMenuData = json_decode($verticalOverlayMenu);

        // share all menuData to all the views
      
    }
}

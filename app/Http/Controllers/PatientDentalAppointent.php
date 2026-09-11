<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Collection;
use Illuminate\Pagination\Paginator;
use App\Student;
use App\Employee;
use App\Doctor;
use DataTables;
use App\Providers;
use Carbon\Carbon;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use App\Http\Controllers\AESCipher;
use App\Http\Controllers\MedClientAddController;
use Barryvdh\DomPDF\Facade\Pdf;

class DentalCertController extends Controller
{
  protected $aes;
  public function __construct(){
      $this->aes = new AESCipher;
  }
  public function index(){
    $pageConfigs = ['pageHeader' => true];
    $breadcrumbs = [
      ["link" => "/", "name" => "Home"],["name" => "Search"]
    ];
  
    return view('pages.dental-certificate',['pageConfigs'=>$pageConfigs,'breadcrumbs'=>$breadcrumbs]);
  }
  
}

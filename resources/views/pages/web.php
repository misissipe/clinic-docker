<?php
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
// dashboard Routes
Route::get('/','DashboardController@dashboardEcommerce')->middleware("authuser");

// 

Route::group(['prefix' => 'users'], function() {
    Route::get('/','UsersController@users');
});


//Authentication  Route
Route::get('/sign-in','AuthenticationController@loginPage')->middleware("authuser");
Route::get('/logout','AuthenticationController@logout')->middleware("authuser");
Route::get('/admin/login','AuthenticationController@authLockPage')->middleware("authuser");
Route::post('/adminlogin','AuthenticationController@adminlogin')->middleware("authuser");
//Miscellaneous
Route::get('/page-contact','MiscellaneousController@contactPage')->middleware("authuser");
Route::get('/page-coming-soon','MiscellaneousController@comingSoonPage')->middleware("authuser");
Route::get('/error-404','MiscellaneousController@error404Page')->middleware("authuser");
Route::get('/error-500','MiscellaneousController@error500Page')->middleware("authuser");
Route::get('/page-not-authorizedtieautocomplete','MiscellaneousController@notAuthPage')->middleware("authuser");
Route::get('/page-maintenance','MiscellaneousController@maintenancePage')->middleware("authuser");
//Auth
Route::get('auth/google', 'AuthenticationController@redirectToGoogle')->name('google.signin'); 
Route::get('auth/google/callback', 'AuthenticationController@handleGoogleCallback');

Auth::routes();

#Dashboard
Route::middleware(['authuser'])->group(function () {
    Route::get('/dashboard-ecommerce', 'DashboardController@dashboardEcommerce');
    Route::get('/nurse-dashboard', 'DashboardController@dashboardEcommerce');
    Route::get('/nurse-attendant-dashboard', 'DashboardController@dashboardEcommerce');
    Route::get('/attendant-dashboard', 'DashboardController@dashboardEcommerce');
    Route::get('/doctor-dashboard', 'DashboardController@dashboardEcommerce');
    Route::get('/dentist-dashboard', 'DashboardController@dashboardEcommerce');
});

#Add User
Route::middleware(['authuser'])->group(function () {
    Route::get('/add-new-user','AddUserController@index');
    Route::post('/addUser','AddUserController@addUser');
    Route::post('/viewUser','AddUserController@viewUser');
    Route::post('/updateUser','AddUserController@update');
});

#Student Information
Route::middleware(['authuser'])->group(function () {
    Route::get('/search-student','StudentController@index');
    Route::post('/search-student','StudentController@search');
    Route::get('/information-student','StudentController@data');
    Route::post('/edit-student-personal','StudentController@modalPersonal');
    Route::post('/updatePersonal','StudentController@updatePersonal');
    Route::post('/edit-student-family','StudentController@modalPersonal');
    Route::post('/updateFamily','StudentController@updateFamily');
    Route::post('/edit-student-emergency','StudentController@modalPersonal');
    Route::post('/updateEmergency','StudentController@updateEmergency');
    
    Route::get('/search-enrolledstudent','StudentController@indexEnrolled');
    Route::post('/search-enrolledstudent','StudentController@searchEnrolled');
    Route::get('/generate-validated','StudentController@indexGenerate');
    Route::post('/validated-student', 'StudentController@validatedStudent')->name('validated-student');
    Route::get('/generate-validated-list','StudentController@generatedListPDF');
});

#Employee Information
Route::middleware(['authuser'])->group(function () {
    Route::get('/search-employee','EmployeeController@index');
    Route::post('/search-employee','EmployeeController@search');
    Route::get('/information-employee','EmployeeController@data');
    Route::post('/edit-employee-personal','EmployeeController@modalPersonalEmp');
    Route::post('/updatePersonalEmp','EmployeeController@updatePersonalEmp');
});


#Appointment
Route::middleware(['authuser'])->group(function () {
    Route::get('/appointment-search','appointmentController@index');
    Route::post('/searchInfo', 'appointmentController@searchInfo');
    Route::get('/appointment','appointmentController@setSchedIndex');
    Route::get('/set-schedule','appointmentController@setSched');
    Route::post('/setAppointment','appointmentController@create');
    Route::get('/view-appointment','appointmentController@view');
    Route::post('/setStatus','appointmentController@ResultStatus');
    Route::post('/cancelStatus','appointmentController@cancelStatus');
    Route::get('/view-status-appointment','appointmentController@status');
    Route::post('/reschedule','appointmentController@reschedule');
    Route::get('/payment-appointment','appointmentController@paymentappointment');
    Route::post('/rescheduleModal','appointmentController@reScheduled');

    Route::get('/calendar-appointment','appointmentController@indexCalendarAppointment');
    Route::post('/AcceptAppointment', 'appointmentController@AcceptAppointment');
    Route::post('/cancelAppointment','appointmentController@cancelAppointment');
    Route::post('/updateStatus','appointmentController@updateStatus');
});


#Patient Information Route
Route::middleware(['authuser'])->group(function () {
    // {---Patient Information---}
    Route::get('/student-information','MedClientAddController@index');
    Route::post('/student-information','MedClientAddController@search');
    Route::get('/medical-and-social-health-history','MedClientAddController@healthHistory')->name('backtoHistory');
    Route::post('/updateStdentRecord','MedClientAddController@update');
    //Employee Information Route
    Route::get('/employee-information','EmployeeInformationController@index');
    Route::post('/employee-information','EmployeeInformationController@search');
    Route::get('/employee-health-history','EmployeeInformationController@healthHistory');
    Route::post('/updateEmployeeRecord','EmployeeInformationController@update');
});


#Medical Record Route
Route::middleware(['authuser'])->group(function () {
    Route::get('/patient-monitoring-record','PatientMedicalRecordController@index');
    Route::post('/addRecord','PatientMedicalRecordController@patientRecord');
    Route::post('/viewData','PatientMedicalRecordController@viewData');
    Route::post('/search', 'PatientMedicalRecordController@autocomplete')->name('autocomplete');
    Route::post('/searchItems','PatientMedicalRecordController@searchItems');
    //for record view
    Route::get('/patient-view-record','PatientViewMedicalRecordController@index');
    Route::post('/patient-view-record','PatientViewMedicalRecordController@searchView')->name('return');
    Route::post('/viewAll','PatientViewMedicalRecordController@viewAll');
    Route::post('/viewModal','PatientViewMedicalRecordController@viewModal');
    Route::post('/update-record','PatientViewMedicalRecordController@updateViewModal');
    Route::get('/patient-record','PatientViewMedicalRecordController@records');
    Route::post('/delete-record', 'PatientViewMedicalRecordController@delete');
    Route::get('/generate-pdf', 'PatientViewMedicalRecordController@generatePDF');
});


#Medical Certificate
Route::middleware(['authuser'])->group(function () {
    Route::get('/medical-certificate','MedicalCertController@index');
    Route::post('/medical-certificate','MedicalCertController@search')->name('backtoview1');
    Route::post('/view','MedicalCertController@view');
    Route::post('/update','MedicalCertController@updateRecord');
    Route::post('/addCert','MedicalCertController@saveCert');
    Route::post('/approve','MedicalCertController@approve');
    Route::post('/generatedCert','MedicalCertController@generatedCert');
    //for create new route
    Route::get('/medical-certificate-patient-information','MedicalCertController@create');
    //for approval new route
    Route::get('/medical-preview-certificate','MedicalCertController@viewForApprove');
    //for view new route
    Route::get('/medical-view-certificate','MedicalCertController@viewCertificate');
    //for print new route
    Route::get('/medical-generated-certificate','MedicalCertController@generateCertificate');
    //for status
    Route::get('/medical-status-certificate','MedicalCertController@statusCert');
    //for delete cert
    Route::post('/deleteRecordCert', 'MedicalCertController@deleteCert');
    //for cert generate
    Route::get('/preview-medical-certificate-pdf', 'MedicalCertController@generateMCPDF');
    Route::get('/generated-medical-certificate-pdf', 'MedicalCertController@generateMCPDFgen');
    //for cert view
    Route::get('/view-generated-certificate','ViewGeneratedCertController@index');
    Route::post('/review','ViewGeneratedCertController@reviewCert');
    Route::post('/approve-result', 'ViewGeneratedCertController@approveResult');
    Route::post('/search-generated-certificate', 'ViewGeneratedCertController@autoSearch')->name('autoSearch');
    Route::post('/result', 'ViewGeneratedCertController@result')->name('result');
    Route::get('/viewGeneratedCert','ViewGeneratedCertController@viewCert');

});

#Referral
Route::middleware(['authuser'])->group(function () {
    Route::get('/referral-slip','ReferralController@index');
    Route::post('/referral-slip','ReferralController@search')->name('backtoslip');
    Route::post('/saveReferral','ReferralController@saveRefer');
    Route::post('/approval','ReferralController@pendingSlip');
    Route::post('/modalView','ReferralController@view');
    Route::post('/modalUpload','ReferralController@modalUpload');
    Route::post('/upload','ReferralController@upload')->name('upload');
    Route::post('/saveEdit','ReferralController@saveEdit');
    Route::post('/generatedSlip','ReferralController@generatedSlip');
    //for create
    Route::get('/referral-patient-information','ReferralController@referalPatientInfo')->name('backtoReferral');
    //for approvalstar
    Route::get('/referral-preview-slip','ReferralController@previewReferral');
    //for status
    Route::get('/referral-status-slip','ReferralController@statusSlip');
    //for viewing records
    Route::get('/referral-view-record','ReferralController@viewMedicalRecord');
    //for uploading return slip
    Route::get('/referral-upload-return-slip','ReferralController@uploadReturnSlip');
    //for viewing status
    Route::get('/referral-view-status','ReferralController@viewStatus');
    //for print
    Route::get('/referral-generated-referral-slip','ReferralController@viewForPrint');
    //for pdf
    Route::get('/generated-referral-slip-pdf', 'ReferralController@generateRSPDF');
    
    #view referral slip
    Route::get('/view-generated-slip','ViewGeneratedSlipController@index');
    Route::post('/view-slip','ViewGeneratedSlipController@viewSlip');
    Route::post('/search-generated-slip', 'ViewGeneratedSlipController@autoSearchSlip')->name('autoSearchSlip');
    Route::post('/result-slip', 'ViewGeneratedSlipController@resultSlip')->name('resultSlip');
    Route::post('/approve-slip', 'ViewGeneratedSlipController@approveSlip');
    Route::get('/viewGeneratedSlip','ViewGeneratedSlipController@viewGenSlip');

    #view return slip
    Route::get('/view-return-slip','ViewReturnSlipController@index');
    Route::post('/search-return-slip','ViewReturnSlipController@autoSearchReturnSlip')->name('autoSearchReturnSlip');
    Route::post('/slip','ViewReturnSlipController@returnSlip')->name('returnSlip');
    Route::post('/files', 'ViewReturnSlipController@getFile')->name('files.');
    Route::post('/delete', 'ViewReturnSlipController@delete')->name('delete');
});

#Dental Certificate
Route::middleware(['authuser'])->group(function () {
    Route::get('/dental-certificate','DentalCertController@index');
    Route::post('/dental-certificate','DentalCertController@search')->name('backtoview');
    Route::get('/dental-certificate-patient-information','DentalCertController@view');
    Route::post('/saveCertificate','DentalCertController@save');
    Route::get('/dental-preview-certificate','DentalCertController@preview');
    Route::get('/dental-view-certificate','DentalCertController@viewRecord');
    Route::post('/modalEdit','DentalCertController@modalEdit');
    Route::post('/updateDentalCert','DentalCertController@updateRecord');
    Route::get('/dental-certificate-pdf', 'DentalCertController@generateDMPDF');
});

#Dental Services Route
Route::middleware(['authuser'])->group(function () {
    Route::get('/student-dental-record','DentalClientAddController@index');
    Route::post('/student-dental-record','DentalClientAddController@search');
    Route::get('/student-dental-chart','DentalClientAddController@dentalChart');
    Route::post('/addNewDentalRec','DentalClientAddController@create');
    Route::get('/dental-treatment-record','DentalClientAddController@treatmentRecord');
    Route::post('/edit-treatmentRecord','DentalClientAddController@editTreatmeant');
    Route::post('/payment','DentalClientAddController@payment');
    Route::post('/viewModalPayment','DentalClientAddController@viewModalPayment');
    Route::post('/update-treatment-record','DentalClientAddController@updateModal')->name('updateRecord');
    Route::post('/add-treatment-record', 'DentalClientAddController@saveModal')->name('addRecord');
    Route::post('/saveRecord','DentalClientAddController@treatment');
    Route::get('/treatment-record-status', 'DentalClientAddController@recordList');
    //employee
    Route::get('/employee-dental-record','EmployeeDentalController@index');
    Route::post('/employee-dental-record','EmployeeDentalController@search');
    Route::get('/employee-dental-chart','EmployeeDentalController@dentalChart');
    Route::post('/addNewDentalRecEmployee','EmployeeDentalController@create');
    //dependent
    Route::post('/addNewDental','DependentDentalController@index');
    Route::get('/new-dependent-dental-record','DependentDentalController@dependentChart');
    Route::get('/add-new-dependent','DependentDentalController@add');
    Route::post('/addnewDependent','DependentDentalController@addDependent');
    Route::post('/edit-Dependent','DependentDentalController@modaleditDependent');
    Route::post('/updateDependent','DependentDentalController@updateDependent');
    Route::post('/deleteDependent', 'DependentDentalController@deleteDependent');
    Route::get('/dependent-dental-record','DependentDentalController@index');
    Route::post('/dependent-dental-record','DependentDentalController@search');
    Route::get('/dependent-dental-chart','DependentDentalController@dependentChart');
    Route::post('/addDependent','DependentDentalController@create');

    #Dental Records
    Route::get('/records-of-visit','DentalRecordsController@index');
    Route::post('/records-of-visit','DentalRecordsController@allRecords')->name('allRecords');
    Route::post('/resultRecords', 'DentalRecordsController@resultRecords')->name('resultRecords');
    Route::get('/dental-total-patient','DentalRecordsController@total');
    Route::post('/dental-total-patient','DentalRecordsController@displaytotal');


    Route::get('/generated-record-of-visit','DentalRecordsController@RVgeneratedPDF');
    
    #Patient records
    Route::get('/treatment-records','DentalRecordsController@treatmentRec')->name('returntosearch');
    Route::post('/treatment-records', 'DentalRecordsController@search')->name('backtorecord');
    Route::get('/treatment-record-list', 'DentalRecordsController@treatmentList')->name('search');
    Route::post('/result-treatment-record', 'DentalRecordsController@resultDental')->name('resultDental');
    Route::post('/deleteRecord', 'DentalRecordsController@deleteRecord');
    // Route::get('F','DentalRecordsController@treatmentRecord')->middleware("authuser");
    // Route::post('/viewModalPayment','DentalRecordsController@viewModalPayment')->middleware("authuser");
    //Route::get('/med-client-record','MedClientRecordController@index');
    Route::post('/save-new-record','DentalClientAddController@update');
    Route::post('/view-modal','DentalClientAddController@viewModal');
    // Route::get('/dental-record-chart','DentalClientAddController@dentalChart');
});

#OVER THE COUNTER MEDICINES
Route::middleware(['authuser'])->group(function () {
    Route::get('/OTC-medicine','OTCMedController@medicine');
    Route::post('/OTC-medicine','OTCMedController@autoSearchOTC')->name('autoSearchOTC');
    Route::post('/createOTC','OTCMedController@createOTC');
    Route::get('/patient-OTC-record','OTCMedController@OTCRecordindex')->name('backtoOTC');
    Route::post('/patient-OTC-record','OTCMedController@searchOTC')->name('OTCreturn');
    Route::get('/view-OTC-Record','OTCMedController@viewOTC');
    Route::post('/viewModalOTC','OTCMedController@viewEditModal');
    Route::post('/deleteRecord-OTC', 'OTCMedController@deleteRecord');
    Route::post('/new-update-OTC-medicine', 'OTCMedController@updateOTCmedicine');
    Route::post('/searchMed','OTCMedController@searchMed');
});

#Report
Route::middleware(['authuser'])->group(function () {
    Route::get('/report-medical-services','ReportController@index')->name('report');
    Route::get('/report-records','ReportController@reportMedicalRecord');
    Route::get('/report-dental-services','ReportController@dentalindex');
    Route::get('/report-dental','ReportController@reportDentalRecord');
});

#Log-Books
Route::middleware(['authuser'])->group(function () {
    Route::get('/medical-record-of-visit','LogsController@recordsOfvisit');
    Route::post('/medical-record-of-visit','LogsController@recordsforVisit');
    Route::get('/medical-wound-dressing','LogsController@woundDressing');
    Route::post('/medical-wound-dressing','LogsController@recordsforWound');
    Route::get('/medical-blood-pressure','LogsController@bloodPressure');
    Route::post('/medical-blood-pressure','LogsController@recordsforBp');
    Route::get('/medical-provision-of-comfort','LogsController@provision');
    Route::post('/medical-provision-of-comfort','LogsController@recordsforProvision');
    Route::get('/medical-issuance-of-certificate','LogsController@certificate');
    Route::post('/medical-issuance-of-certificate','LogsController@recordsforCertificate');
    Route::get('/medical-issuance-of-slip','LogsController@slip');
    Route::post('/medical-issuance-of-slip','LogsController@recordsforSlip');
    Route::get('/medical-OTC-medicine','LogsController@OTCmed');
    Route::post('/medical-OTC-medicine','LogsController@recordsforOTCMed');
    Route::get('/medical-other-concern','LogsController@others');
    Route::post('/medical-other-concern','LogsController@recordsforOthers');

    Route::get('/medical-total-patient','LogsController@totalMedical');
    Route::post('/medical-total-patient','LogsController@displaytotalMedical');

    Route::get('/generate-record-of-visit','LogsController@RVgeneratePDF');
    Route::get('/generate-wound-dressing','LogsController@WDgeneratePDF');
    Route::get('/generate-blood-pressure','LogsController@BPgeneratePDF');
    Route::get('/generate-provision-of-comfort','LogsController@PCgeneratePDF');
    Route::get('/generate-issuance-of-certificate','LogsController@MCgeneratePDF');
    Route::get('/generate-issuance-of-slip','LogsController@RSgeneratePDF');
    Route::get('/generate-OTC-medicine','LogsController@OTCgeneratePDF');
    Route::get('/generate-other-concern','LogsController@OCgeneratePDF');

    #Dental Logbook
    Route::get('/records-of-checkup','LogsController@checkup');
    Route::post('/records-of-checkup','LogsController@recordsforcheckup');
    Route::get('/records-of-cavityfilling','LogsController@pasta');
    Route::post('/records-of-cavityfilling','LogsController@recordsforpasta');
    Route::get('/records-of-oralprophylaxis','LogsController@cleaning');
    Route::post('/records-of-oralprophylaxis','LogsController@recordsforcleaning');
    Route::get('/records-of-toothextraction','LogsController@extraction');
    Route::post('/records-of-toothextraction','LogsController@recordsforextraction');
});

#Laboratory result
Route::middleware(['authuser'])->group(function () {
    Route::get('/lab-results','LabResultController@index');
    Route::post('/lab-results','LabResultController@searchLab');
    Route::get('/lab-test-result-records','LabResultController@labRecords');
    Route::post('/uploadFiles','LabResultController@uploadFiles')->name('uploadFiles');
    Route::post('/deleteRecordResult', 'LabResultController@deleteLabResult');
});

#Inventory
Route::middleware(['authuser'])->group(function () {
    Route::get('/inventory','InventoryController@index');
    Route::get('/Inventory-report','InventoryController@totalInventory');
    Route::post('/Inventory-report','InventoryController@displaytotalInventory');
    // Route::post('/searchitem','InventoryController@searchitem')->name('searchitem');
    // Route::post('/searchUnit','InventoryController@searchUnit')->name('searchUnit');
    // Route::post('/addStock','InventoryController@add');
    // Route::post('/t', 'InventoryController@deleteLabResult');
});
#Stocks
Route::middleware(['authuser'])->group(function () {
    Route::get('/add-items','StocksController@index');
    Route::post('/searchitem','StocksController@searchitem')->name('searchitem');
    Route::post('/searchUnit','StocksController@searchUnit')->name('searchUnit');
    Route::post('/addStock','StocksController@add');
    Route::post('/viewModalStock','StocksController@viewModalStock');
    Route::post('/updateStock', 'StocksController@updateStock');
    Route::post('/deleteMed', 'StocksController@deleteMed');
});

#Product
Route::middleware(['authuser'])->group(function () {
    Route::get('/category-product','ProductController@index');
    Route::post('/addProduct','ProductController@add');
    Route::post('/editProduct','ProductController@edit');
    Route::post('/updateProduct','ProductController@update');
    Route::post('/deleteProduct', 'ProductController@delete');
});

#Unit of measurement
Route::middleware(['authuser'])->group(function () {
    Route::get('/category-measurement','MeasureController@index');
    Route::post('/addMeasurement','MeasureController@add');
    Route::post('/editMeasurement','MeasureController@edit');
    Route::post('/updateMeasure','MeasureController@update');
    // Route::post('/t', 'MeasureController@deleteLabResult');
});

#Doctors
Route::middleware(['authuser'])->group(function () {
    Route::get('/add-doctors','DoctorsController@indexDoctors');
    Route::post('/addDoctors','DoctorsController@addDoctors');
    Route::post('/editDoctors','DoctorsController@editDoctors');
    Route::post('/updateDoctors','DoctorsController@updateDoctors');
    Route::post('/deleteDoctors', 'DoctorsController@deleteDoctors');
});
#Signatories
Route::middleware(['authuser'])->group(function () {
    Route::get('/add-signatories','SignatoriesController@index');
    Route::post('/addSignatories','SignatoriesController@addSignatories');
    Route::post('/editSignatories','SignatoriesController@editSignatories');
    Route::post('/updateSignatories','SignatoriesController@updateSignatories');
    Route::post('/deleteSignatories', 'SignatoriesController@deleteSignatories');
});


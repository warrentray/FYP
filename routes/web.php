<?php
use App\Http\Controllers\adminController;
use App\Http\Controllers\loginController;
use App\Http\Controllers\trainingController;

use App\Http\Controllers\medicalClaimController;
use App\Http\Controllers\PayrollController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\attendanceController;
use App\Http\Controllers\ForgetPasswordController;


Route::redirect('/', '/login');

Route::get('/login', 'App\Http\Controllers\userController@index')->name('login');
Route::post('postLogin', 'App\Http\Controllers\loginController@postLogin')->name('postLogin');

Route::get('logout', [loginController::class, 'logout'])->name('logout');
Route::post('/logout', 'App\Http\Controllers\loginController@logout')->name('logout');
Route::get('/profile', 'App\Http\Controllers\userController@profile')->name('profile');
 
// Route::post('verifyEmail', 'App\Http\Controllers\forgetPasswordController@verifyEmail')->name('verifyEmail');
// Route::post('verifyLogin', 'App\Http\Controllers\forgetPasswordController@verifyLogin')->name('verifyLogin');
// Route::post('resetPassword', 'App\Http\Controllers\forgetPasswordController@resetPassword')->name('resetPassword');
// Route::post('reset', 'App\Http\Controllers\forgetPasswordController@reset')->name('reset');
Route::post('verifyEmail', 'App\Http\Controllers\forgetPasswordController@verifyEmail')->name('verifyEmail');
Route::get('/resetPassword', [ForgetPasswordController::class, 'index'])->name('resetPassword');
Route::post('/verifyEmail', [ForgetPasswordController::class, 'verifyEmail'])->name('verifyEmail');
Route::post('/resetPassword', [ForgetPasswordController::class, 'resetPassword'])->name('resetPassword');
Route::post('/reset', [ForgetPasswordController::class, 'reset'])->name('reset');

Route::get('/profile', 'App\Http\Controllers\userController@profile')->name('profile');


Route::get('/manage-staff', [adminController::class, 'manageStaff'])->name('manageStaff');
Route::post('/changeStatus', [adminController::class, 'changeStatus'])->name('changeStatus');
Route::post('/changeCustomerStatus', [adminController::class, 'changeCustomerStatus'])->name('changeCustomerStatus');

Route::get('/qrcode/{membershipCard}', 'App\Http\Controllers\userController@getQrCodeImage')->name('getQrCodeImage');


// register for customer 
Route::get('/register', 'App\Http\Controllers\loginController@registerindex')->name('register');
Route::post('/register', 'App\Http\Controllers\loginController@register')->name('register');
 Route::get('/manageCustomer', 'App\Http\Controllers\adminController@manageCusShow')->name('manageCusShow');
 

Route::get('/staffheader', 'App\Http\Controllers\staffController@index')->name('header');
 Route::get('/forgetPassword', 'App\Http\Controllers\forgetPasswordController@index2')->name('forgetPassword');

// admin 
Route::get('/manageStaff', 'App\Http\Controllers\adminController@manageStaff')->name('manageStaff');
Route::get('/addStaff', 'App\Http\Controllers\adminController@addStaff')->name('addStaff');
Route::post('/addStaff', 'App\Http\Controllers\adminController@register')->name('addStaff');

Route::get('/viewAttendance', 'App\Http\Controllers\adminController@index3')->name('viewAttendance');

//staff 
Route::get('/profileStaff', 'App\Http\Controllers\staffController@staffprofile')->name('profileStaff');
Route::get('/dailyattendance', 'App\Http\Controllers\staffController@index2')->name('dailyattendance');

//stock Management 
Route::get('/viewStock', 'App\Http\Controllers\stockController@viewStock')->name('viewStock');
Route::get('/get-deliveries', 'App\Http\Controllers\DeliveryController@getDeliveries');

Route::put('/update-stock/{id}', 'App\Http\Controllers\stockController@updateStock')->name('updateStock');

Route::get('/requestStock', 'App\Http\Controllers\stockController@requestStock')->name('requestStock');
Route::get('/editStock', 'App\Http\Controllers\stockController@index6')->name('editStock');
 Route::get('/infoStock/{deliveryId}', 'App\Http\Controllers\stockController@infoStock')->name('infoStock');
  Route::get('/stockin', 'App\Http\Controllers\stockController@getDeliveryDetails')->name('deliveryDetails');
   Route::post('/submit-stock-request', 'App\Http\Controllers\stockController@requestStockSubmit')->name('requestStockSubmit');

// Petrol Management
Route::get('/petrolDetail', 'App\Http\Controllers\stockController@petrolDetail')->name('petrolDetail');
Route::get('/addPetrol', 'App\Http\Controllers\stockController@addpetrol')->name('addPetrol');
Route::post('addPetrol', 'App\Http\Controllers\stockController@petrolRequest')->name('addPetrol');

Route::get('/editpetrol/{id}', 'App\Http\Controllers\stockController@editpetrol')->name('editPetrol');
Route::put('/editpetrol/{id}', 'App\Http\Controllers\stockController@updatePetrol')->name('updatePetrol');
Route::delete('/deletepetrol/{id}', 'App\Http\Controllers\stockController@destroy')->name('deletePetrol.destroy');

//Shift Management 
Route::get('/viewShift', 'App\Http\Controllers\shiftController@viewShift')->name('viewShift');
Route::get('/viewPendingShift', 'App\Http\Controllers\shiftController@viewPendingShift')->name('viewPendingShift');
Route::get('/applyShift', 'App\Http\Controllers\shiftController@applyShift')->name('applyShift');
Route::get('/editShift', 'App\Http\Controllers\shiftController@editShift')->name('editShift');
// staff view Shift
Route::get('/rescheduleViewShift', 'App\Http\Controllers\shiftController@rescheduleViewShift')->name('staffViewShift');
  Route::post('/applyShift', 'App\Http\Controllers\shiftController@applyShiftReq')->name('applyShiftReq');
  Route::get('/shift/approve/{id}','App\Http\Controllers\shiftController@approveShift')->name('shift.approve');
  Route::get('/shift/reject/{id}', 'App\Http\Controllers\shiftController@rejectShift')->name('shift.reject');
// training 
 

Route::get('/training', [trainingController::class, 'viewStock'])->name('trainings.index');
Route::get('/training/create', [trainingController::class, 'create'])->name('trainings.create');
Route::post('/training', [trainingController::class, 'store'])->name('trainings.store');
Route::get('/training/{id}', [trainingController::class, 'show'])->name('trainings.show');
Route::get('/training/{id}/edit', [trainingController::class, 'edit'])->name('trainings.edit');
Route::put('/training/{id}', [trainingController::class, 'update'])->name('trainings.update');
Route::delete('/training/{id}', [trainingController::class, 'destroy'])->name('trainings.destroy');

//leave Staff

Route::get('/applyLeave', 'App\Http\Controllers\leaveController@applyLeave')->name('applyLeave');
Route::get('/editLeave/{id}', 'App\Http\Controllers\leaveController@editLeave')->name('editLeave');
Route::get('/viewLeave', 'App\Http\Controllers\leaveController@viewLeave')->name('viewLeave');
Route::get('/leaveHistory', 'App\Http\Controllers\leaveController@leaveHistory')->name('leaveHistory');
 
Route::get('/dashApply', 'App\Http\Controllers\leaveController@dashApply')->name('dashApply');
 Route::put('/editLeave/{id}', 'App\Http\Controllers\leaveController@updateLeave')->name('updateLeave');
 
Route::post('/applyLeave', 'App\Http\Controllers\leaveController@storeApplyLeave')->name('applyLeave');
Route::get('/leave/approve/{leave_id}', 'App\Http\Controllers\leaveController@approveLeave')->name('leave.approve');
Route::get('/leave/reject/{leave_id}', 'App\Http\Controllers\leaveController@rejectLeave')->name('leave.reject');


// Medical Claim 
Route::post('/uploadMedical', [medicalClaimController::class, 'uploadMedical'])->name('uploadMedical');
Route::get('/medicalClaims', 'App\Http\Controllers\medicalClaimController@medicalClaims')->name('medicalClaims');
Route::get('/viewMediacalClaimStatus', 'App\Http\Controllers\medicalClaimController@viewmedicalClaimsStatus')->name('viewMediacalClaimStatus');
Route::get('/mediacalClaim/approve/{id}', 'App\Http\Controllers\medicalClaimController@approveMedicalClaim')->name('medicalClaim.approve');
Route::get('/mediacalClaim/reject/{id}', 'App\Http\Controllers\medicalClaimController@rejectMedicalClaim')->name('medicalClaim.reject');

//   Medical Claim staff
Route::get('/claimHistory', 'App\Http\Controllers\medicalClaimController@claimHistory')->name('claimHistory');
  Route::get('/generate-payslip/{id}', 'App\Http\Controllers\payrollController@generatePayslip')->name('generate-payslip');
  Route::get('/payslips/{filename}', 'App\Http\Controllers\payrollController@downloadPdf');

//staff payslip
 Route::get('/DashboardPayslip', 'App\Http\Controllers\payrollController@payDash')->name('DashboardPayslip');
Route::get('/generatePayslip', 'App\Http\Controllers\payrollController@generatePayslip')->name('generatePayslip');
Route::get('/salary/{id}', 'App\Http\Controllers\payrollController@salary')->name('salary');
Route::get('/download-pdf/{filename}', [payrollController::class, 'downloadPdf'])->name('download-pdf');

 Route::put('/salary/{id}', 'App\Http\Controllers\payrollController@updateSalary')->name('updateSalary');

Route::get('/viewPayslipInfo', 'App\Http\Controllers\payrollController@viewPayslipInfo')->name('viewPayslipInfo');
Route::get('/calculationPayslip', 'App\Http\Controllers\payrollController@calPayslip')->name('calPayslip');

//admin payslip
Route::get('/AdminDashboardPayslip', 'App\Http\Controllers\payrollController@AdminDashboardPayslip')->name('AdminDashboardPayslip');
 

//attendance
Route::get('/dailyattendance', 'App\Http\Controllers\attendanceController@signin')->name('dailyattendance');
Route::post('/attendance/store', 'App\Http\Controllers\attendanceController@storeAttendance')->name('attendance.store');
Route::get('/historyAttendance', 'App\Http\Controllers\attendanceController@historyAttendance')->name('historyAttendance');

Route::get('/attendance/status', [attendanceController::class, 'viewStatus']);

Route::get('/cal', 'App\Http\Controllers\payrollController@cal')->name('cal');

 

Route::post('/api/calculate-epf', 'App\Http\Controllers\payrollController@calculateEPFContributions');

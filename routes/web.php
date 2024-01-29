<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\managerController;
use App\Http\Controllers\userController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Di sini Anda dapat mendaftarkan rute web untuk aplikasi Anda. Rute-rute ini
| dimuat oleh RouteServiceProvider dalam grup yang berisi middleware "web".
| Sekarang buat sesuatu yang hebat!
|
*/



Route::middleware(['guest'])->group(function () {
  // Process Login
Route::get('/', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'login']);

});

Route::middleware(['auth'])->group(function () {
  Route::prefix('dashboard')->group(function () {
    Route::get('/', [DashboardController::class, 'index']);
    Route::get('/daily-format-report/{id}', [DashboardController::class, 'detailDailyReport']);
    Route::get('/detail-edit-daily-report/{id}', [DashboardController::class, 'editDailyReport']);
    Route::get('/edit-visiting-productivity/{id}', [DashboardController::class, 'editVisitingProductivity']);
    Route::put('/update-daily-report/{id}', [DashboardController::class, 'updateDailyReport']);
    Route::delete('/delete-daily-report/{id}', [DashboardController::class, 'deleteDailyReport']);
    Route::delete('/delete-visiting-productivity/{id}', [DashboardController::class, 'deleteVisitingProductivity']);
    Route::get('/datatable', [DashboardController::class, 'datatable']);
    Route::get('/datatable-productivity', [DashboardController::class, 'datatableProductivity']);
    Route::get('/visiting-productivity', [DashboardController::class, 'visiting']);
    Route::post('/create-daily-report', [DashboardController::class, 'createDailyReport']);
    Route::post('/create-visiting', [DashboardController::class, 'createVisitingProductivity']);
    Route::post('/create-visiting-productivity-report', [DashboardController::class, 'createVisitingProductivityReport']);
    Route::put('/update-visiting-productivity/{id}', [DashboardController::class, 'updateVisitingProductVisiting']);
    Route::get('/scan-barcode/{id}', [DashboardController::class, 'scanBarcode']);
    Route::get('/scan-barcode-checkout/{id}', [DashboardController::class, 'scanBarcodeCheckout']);
    Route::get('/detail-report/{id}', [DashboardController::class, 'detailReport']);
    Route::post('/process-scan-barcode/{id}', [DashboardController::class, 'processScanBarcode']);
    Route::post('/process-scan-barcode-checkout/{id}', [DashboardController::class, 'checkoutProcessScanBarcode']);
    Route::get('/check-depature', [DashboardController::class, 'checkDepatureFromOffice']);
    Route::get('/detail-report-information/{id}', [DashboardController::class, 'detailReportInformation']);
    Route::get('/recent-activity', [DashboardController::class, 'recentActivity']);
    Route::get('/datatable-report/{id}', [DashboardController::class, 'datatableReport']);
    Route::get('/edit-report-detail/{id}', [DashboardController::class, 'editReportDetail']);
    Route::put('/update-report-detail', [DashboardController::class, 'updateReportDetail']);
    Route::delete('/delete-report-detail/{id}', [DashboardController::class, 'deleteReportDetail']);
    Route::get('/working-type-information',[DashboardController::class, 'workingTypeInformation']);

    Route::put('/checkin-location/{id}', [DashboardController::class, 'checkinLocation']);
    Route::get('/check-report-visiting-productivity/{id}', [DashboardController::class, 'checkReportVisitingProductivity']);

    Route::get('/select-client', [DashboardController::class, 'selectClient']);
    Route::get('/select-pic', [DashboardController::class, 'selectPic']);
  });
  Route::prefix('dashboard-manager')->group(function () {
    Route::get('/', [managerController::class, 'index']);
    Route::get('/visiting-productivity', [managerController::class, 'visiting']);
  });
  Route::prefix('user')->group(function(){
    Route::get('/', [userController::class, 'index']);
  });

  Route::post('/logout', [LoginController::class, 'logout']);
});

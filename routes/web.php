<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\UserManagementController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\LinkController;
use App\Http\Controllers\ReconcileController;
use App\Http\Controllers\QualificationController;
use App\Http\Controllers\ClientApiDataController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\ExportDashboardController;
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

Route::get('/language', [UserController::class, 'language']);


Route::get('/', [UserController::class, 'login'])->name("login");
Route::post('/login', [UserController::class, 'postLogin']);

Route::get('/signup', [UserController::class, 'signup']);
Route::post('/postSignUp', [UserController::class, 'postSignUp']);

Route::get('/forget-password', [UserController::class, 'forgetPassword']);
Route::post('/post-forget-password', [UserController::class, 'postForgetPassword']);
Route::post('/upload-file', [SettingController::class, 'uploadFile']);


Route::get('/logout',function(){
    Auth::logout();
    return Redirect::to('/');
});



Route::group(["middleware"=>["auth"]],function(){
 Route::get('/api/get-self-parent',[ProjectController::class, 'getSelfParent']);

    
    Route::get('/dashboard',[AdminController::class, 'dashboard']);


    Route::post('/dashboard-init',[AdminController::class, 'dashboardInit']);
    Route::post('/dashboard-monthly-stastics',[AdminController::class, 'dashboardMonthlyStastics']);
    Route::post('/dashboard-project-status-init',[AdminController::class, 'dashboardProjectStatusInit']);

    Route::post('/dashboard-daily-stats-export',[AdminController::class, 'dailyStatsExport']);


    Route::get('/access-rights',[AdminController::class, 'accessRights']);
    Route::post('/store-right',[AdminController::class, 'saveAccess']);

    Route::group(["prefix" => "projects"], function(){
        Route::get('/', [ProjectController::class, 'index']);
        Route::post('index-init', [ProjectController::class, 'indexInit']);
        Route::post('get-project-detail', [ProjectController::class, 'getProjectDetail']);
        Route::get('/add/{id?}', [ProjectController::class, 'add']);
        Route::get('/add-init/{project_id?}', [ProjectController::class, 'addInit']);
        Route::post('/save-project', [ProjectController::class, 'saveProject']);
        Route::get('/edit/{id}', [ProjectController::class, 'edit']);
        Route::get('/delete/{project_id}', [ProjectController::class, 'deleteProject']);
        Route::get('/get-project-filter-data', [ProjectController::class, 'getProjectFilterData']);
        Route::get('/view-project-survey-details/{project_id}/{status?}', [ProjectController::class, 'viewProjectSurveyDetails']);

        Route::get('/get-project-survey-filter-data', [ProjectController::class, 'getProjectSurveyFilterData']);
        Route::get('/approved/{project_id}', [ProjectController::class, 'approved']);


        Route::post('/show-project-survey-details', [ProjectController::class, 'showProjectSurveyDetails']);
        Route::post('/save-status', [ProjectController::class, 'saveStatus']);
        Route::post('/copy-project', [ProjectController::class, 'copyProject']);
        Route::get('/download/{project_id}', [ProjectController::class, 'download']);

    });


    Route::group(["prefix"=> "users"],function(){
        Route::get('/',[UserManagementController::class,'index']);
        Route::post('/init',[UserManagementController::class,'init']);
        Route::post('/saveUser',[UserManagementController::class,'saveUser']);
        Route::get('/removeUser/{user_id}',[UserManagementController::class,'removeUser']);
        Route::post('/add-wallet-balance',[UserManagementController::class,'addWalletBalance']);
        Route::post('/get-wallet-history',[UserManagementController::class,'getWalletHistory']);
    });

    Route::group(["prefix"=> "setting"],function(){
        Route::get('/',[SettingController::class,'index']);
        Route::post('/store',[SettingController::class,'store']);
        Route::post('/init',[SettingController::class,'init']);
    });

    Route::group(["prefix" => "clients"], function(){
        Route::get('/', [ClientController::class, 'index']);
        Route::get('/add/{id?}', [ClientController::class, 'add']);
        Route::post('/store/{id?}', [ClientController::class, 'store']);
        Route::get('/edit/{id}', [ClientController::class, 'edit']);
        Route::get('/delete/{id}', [ClientController::class, 'delete']);
        Route::get('/links', [ClientController::class, 'links']);
    });

    Route::group(["prefix" => "vendors"], function(){
        Route::get('/', [VendorController::class, 'index']);
        Route::get('/add/{id?}', [VendorController::class, 'add']);
        Route::post('/store/{id?}', [VendorController::class, 'store']);
        Route::get('/edit/{id}', [VendorController::class, 'edit']);
        Route::get('/delete/{id}', [VendorController::class, 'delete']);
    });

    Route::group(["prefix" => "re-concile"], function(){
        Route::get('/{project_id}', [ReconcileController::class, 'index']);
    });

    Route::group(["prefix" => "supliers"], function(){
        Route::get('/{project_id}', [SupplierController::class, 'index']);
        Route::post('/init', [SupplierController::class, 'init']);
        Route::post('/saveSuplier', [SupplierController::class, 'saveSuplierData']);
        Route::get('/removeSuplier/{removeSuplier_id}', [SupplierController::class, 'removeSuplier']);
        Route::get('/add/{project_id}', [SupplierController::class, 'add']);
        Route::post('/store/{id?}', [SupplierController::class, 'store']);
        Route::post('/get-vendor-details', [SupplierController::class, 'getVendorDetails']);
        Route::post('/add-edit-init-data', [SupplierController::class, 'addEditInit']);
        Route::get('edit/{id}/{project_id}', [SupplierController::class, 'edit']);

        Route::post('/show-project-suplier-survey-details', [SupplierController::class, 'showProjectSurveyDetails']);
        Route::post('/export', [SupplierController::class, 'exportExcel']);
    });

    Route::group(["prefix" => "qualifications"], function(){
        Route::get('/{project_id}', [QualificationController::class, 'index']);
        Route::post('/init', [QualificationController::class, 'init']);
        Route::post('/store', [QualificationController::class, 'store']);
        Route::post('/edit-data', [QualificationController::class, 'edit']);
        Route::post('/apply-qualification', [QualificationController::class, 'applyQualification']);
        Route::get('/delete/{id}', [QualificationController::class, 'delete']);

        Route::post('/fetch-question', [QualificationController::class, 'fetchQuestion']);

        Route::post('/fetch-api-question', [QualificationController::class, 'fetchApiQuestion']);
        Route::post('/manage-option', [QualificationController::class, 'manageOption']);
        Route::post('/manage-option-answer', [QualificationController::class, 'manageOptionAnswer']);
    });

    Route::group(["prefix" => "client-api-data"], function(){
        Route::get('/', [ClientApiDataController::class, 'index']);
        Route::get('/fetch-data', [ClientApiDataController::class, 'fetchData']);
        Route::post('/init', [ClientApiDataController::class, 'init']);
        Route::post('/all-settings', [ClientApiDataController::class, 'allSettings']);
        Route::post('/save-api-settings', [ClientApiDataController::class, 'saveAPISettings']);
        Route::post('/get-clients', [ClientApiDataController::class, 'getClients']);
        Route::get('/delete/{project_id}', [ClientApiDataController::class, 'deleteProject']);
        Route::get('/get-country', [ClientApiDataController::class, 'getCountry']);
        Route::get('/client-wise-country', [ClientApiDataController::class, 'clientWiseCountry']);
        Route::post('/operation', [ClientApiDataController::class, 'operation']);
    });

    Route::group(["prefix" => "export-dashboard"], function(){
        Route::get('/', [ExportDashboardController::class, 'index']);
        Route::get('/export', [ExportDashboardController::class, 'ExportBulk']);
    });
    
});

Route::get('/survey-start', [LinkController::class, 'surveyStart']);

Route::post('/store-start-survey-information', [LinkController::class, 'storeStartSurveyInformation']);
Route::get('/client-redirect-url', [LinkController::class, 'surveyInitialize']);

<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JobVacancyController;
use App\Http\Controllers\JobFinderController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['middleware' => ['cors', 'json.response']], function () {
    // Authentication
    Route::post('/login', [AuthController::class, 'login']); // Login
    Route::post('/register/company', [AuthController::class, 'registerCompany']); // Register Company
    Route::post('/register/job_finder', [AuthController::class, 'registerJobFinder']); // Register Job Finder
    
    // All with token can access
    Route::middleware('auth:api')->group(function() {
        Route::get('/user', function (Request $request) {
            return $request->user();
        }); // Check User

        Route::resource('job-vacancy', JobVacancyController::class); // Job Vacancy        
    });

    // Only Company can access
    Route::middleware(['auth:api', 'api.company'])->group(function () {
        Route::resource('company', CompanyController::class); // Company
    });

    // Only Job Finder can access
    Route::middleware(['auth:api', 'api.job_finder'])->group(function () {
        Route::resource('job-finder', JobFinderController::class); // Job Finder
    });
});



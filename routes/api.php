<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JobVacancyController;
use App\Http\Controllers\JobFinderController;
use App\Http\Controllers\JobTrainingController;
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

    // PUBLIC CAN ACCESS
    Route::get('job-vacancy', [JobVacancyController::class, 'index']); // Get Job Vacancy
    Route::get('job-vacancy/{id}', [JobVacancyController::class, 'show']); // Get Detail Job Vacancy

    Route::get('/job-training', [JobTrainingController::class, 'index']); // Get All Job Training
    Route::get('/job-training/{id}', [JobTrainingController::class, 'show']); // Get Detail Job Training
    
    // All with token can access
    Route::middleware('auth:api')->group(function() {
        Route::get('user', [AuthController::class, 'getProfile']); // Get User Profile
        Route::put('user', [AuthController::class, 'updateProfile']); // Get User Profile
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



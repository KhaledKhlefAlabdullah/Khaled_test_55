<?php

use App\Http\Controllers\FileController;
use App\Http\Controllers\MapController;
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

// Route::get('/download-educational-file',[FileController::class,'download_files']);

<<<<<<< HEAD
Route::get('/map', [MapController::class, 'index']);
Route::get('/test',[FileController::class,'generatePDF']);
=======

Route::get('/test', [FileController::class, 'generate_pdf']);
>>>>>>> dev

//Route::get('/get-csv', [\App\Http\Controllers\EmployeeController::class,'export_csv_employees_file']);



<?php

use App\Http\Controllers\FileController;
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

Route::get('/test',[FileController::class,'generatePDF']);

//Route::get('/get-csv', [\App\Http\Controllers\EmployeeController::class,'export_csv_employees_file']);



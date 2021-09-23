<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\TodosController;

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

Route::get('/', function () { return view('search'); });
Route::get('/manage', function () { return view('manage'); });

Route::get('todos/list', [TodosController::class, 'list']);
Route::get('todos/get/id/{id}', [TodosController::class, 'getById']);
Route::put('todos/store', [TodosController::class, 'store']);
Route::get('todos/del/id/{id}', [TodosController::class, 'remove']);
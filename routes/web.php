<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Kangaroo;

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

Route::get('/', [Kangaroo::class, 'add'] );
Route::get('/add_kangaroo', [Kangaroo::class, 'add']);
Route::get('/view_all', [Kangaroo::class, 'allList']);
Route::get('/update_kangaroo/{id}', [Kangaroo::class, 'editForm'] );

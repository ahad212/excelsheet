<?php

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

Route::prefix('excelsheet')->group(function () {
    Route::get('/', function () {
        return view('welcome');
    });
    
    Route::get('/import_excel', function () {
        return view('import_excel');
    })->name('import_excel');
    Route::get('/getdata', 'ImportExcelController@index')->name('import_ex');
    Route::get('/getmatch', 'ImportExcelController@matched')->name('match');
    Route::get('/getunmatch', 'ImportExcelController@unmatched')->name('unmatch');
    Route::get('/registration', function () {
        return view( 'reg' );
    })->name('registration');
    
    Route::any('/log','ImportExcelController@login')->name('login');
    Route::get('/login', function () {
        return view( 'login' );
    })->name('logg');
    Route::any('/reg', 'ImportExcelController@register')->name('reg');
    Route::redirect('/','/excelsheet/login');
    Route::post('/import_excel/import', 'ImportExcelController@import');
});
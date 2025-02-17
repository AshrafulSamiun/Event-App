<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});




Route::resource('Menus','MenuController');
Route::resource('CountryApi','CountryApiController');
Route::resource('GroupApi','GroupApiController');
Route::resource('DivisionApi','DivisionApiController');
Route::resource('DepartmentApi','DepartmentApiController');
Route::resource('SectionApi','SectionApiController');
Route::resource('CompanyApi','CompanyApiController');
Route::resource('MenuApi','ManuApiController');
Route::resource('ModuleApi','ModuleApiController');


Route::get('DivisionByCompany/{company_id}', 'DivisionApiController@companyWisedivision');
Route::get('DepartmentByDivision/{division_id}', 'DepartmentApiController@divisionWiseDepartment');
Route::get('SectionByDepartment/{department_id}', 'SectionApiController@departmentWiseSection');
<?php

Route::resource('Calendars','CalendarController');
Route::get('CalendarList/{year}','CalendarController@CalendarLists');
Route::post('/events/import', 'CalendarController@importFromCSV');

























//========================Test Link===================================
use App\Mail\WelcomeMail;
use Illuminate\Support\Facades\Mail;
Route:: get ('/email', function () {
	Mail::to('a.i.bhouiyan@gmail.com')->send(new WelcomeMail());
   return new WelcomeMail();
});

//===========================End Test Link=============================

Route::middleware('web')->group(function () {
   // Route::get('/register', [RegisterController::class, 'create']);
    Route::post('/register', [RegisterController::class, 'create']);
});

Auth::routes();
Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');
Route::get('user/activation/{user_id}', 'Auth\RegisterController@userActivation');
Route::get('/', 'HomeRouteController@home_menu');
Route::get('verify/resend', 'Auth\TwoFactorController@resend')->name('verify.resend');
Route::resource('verify', 'Auth\TwoFactorController')->only(['index', 'store']);

Route::get('send/message', 'SendMessageController@getVerify');
Route::post('send/message', 'SendMessageController@postVerify');

// Forget User name routes
Route::get('username/request', 'Auth\SendsUserNameController@showLinkRequestForm')->name('username.request');
Route::post('username/email', 'Auth\SendsUserNameController@sendUsernameEmail')->name('username.email');
Route::get('pinCode/request', 'Auth\SendsUserNameController@showPinRequestForm')->name('pincode.request');
Route::post('pinCode/email', 'Auth\SendsUserNameController@sendPinCodeEmail')->name('pincode.email');

//=========================Captcha=====================================================
Route::get('refresh_captcha', 'Auth\RegisterController@refresh_captcha')->name('refresh_captcha');
//$this->post('password/reset', 'Auth\ResetPasswordController@reset');

Route::group(['middleware' => ['auth', 'twofactor']], function () { 

	
	Route::resource('Users','UserController');
	

});









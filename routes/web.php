<?php

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::post('/user/register', 'UserController@register');
Route::get('/user/delete', 'UserController@delete')->middleware('isadmin','auth','isConfirmed','google2fa');
Route::get('/user/browse', 'UserController@browse')->middleware('isadmin','auth','isConfirmed','google2fa');
Route::get('/inbox', 'UserController@demand')->middleware('isadmin','auth','isConfirmed','google2fa');
Route::post('/user/created/{id}', 'UserController@created')->middleware('isadmin','auth','isConfirmed','google2fa');
Route::post('/user/created', 'UserController@createUser')->middleware('isadmin','auth','isConfirmed','google2fa');
Route::post('/user/deleted/{id}', 'UserController@deleted')->middleware('isadmin','auth','isConfirmed','google2fa');
Route::get('/user/create', 'UserController@createView')->middleware('isadmin','auth','isConfirmed','google2fa');
Route::get('/user/account', 'UserController@account')->middleware('auth','google2fa');;
Route::post('/user/account/update', 'UserController@accountUpdate')->middleware('auth','google2fa');
Route::post('/user/results', 'UserController@results')->middleware('isadmin','auth','isConfirmed','google2fa');;
Route::get('/sendmail', 'UserController@sendmail')->middleware('isadmin','auth','isConfirmed','google2fa');;
//
Route::get('/user/sendmail', 'UserController@sendmail')->middleware('isadmin','auth','isConfirmed','google2fa');;
//files routes
Route::get('/files/private', 'FileController@privateBrows')->middleware('auth','isConfirmed');
Route::get('/files/public', 'FileController@publicBrows')->middleware('auth','isConfirmed');
Route::get('/files/specified', 'FileController@specifiedBrows')->middleware('auth','isConfirmed');
Route::post('/files/uploadPublic', 'FileController@publicUpload')->middleware('auth','isConfirmed');
Route::post('/files/uploadPrivate', 'FileController@PrivateUpload')->middleware('auth','isConfirmed');		
Route::post('/files/uploadspecified', 'FileController@specifiedUpload')->middleware('auth','isConfirmed');		
Route::post('/publicFile/results', 'FileController@publicResult')->middleware('auth','isConfirmed');
//2fa works 
Route::get('/2fa', 'PassworddSecurityController@show2faForm');
Route::post('/generate2faSecreteCode', ['uses'=>'PassworddSecurityController@generate2faSecreteCode',
	'as'=>'generate2faSecretecode'
]);

Route::post('/enable2fa', ['uses'=>'PassworddSecurityController@enable2fa',
	'as'=>'enable2fa'
]);



Route::post('/generate2faSecrete', ['uses'=>
	'PassworddSecurityController@disable2fa',
	'as'=>'disable2fa'
]);



Route::post('/2faVerify', function (){
	return redircet (URL()->previous());
}
)->name('2faVerify')->middleware('2fa');

Route::get('/user/logout',  function ( )
    {
      $user=Auth::user();
      $sec = DB::table('passwordd_securities')->where('user_id', $user->id)->update(['google2fa_enable' => 0]);
      Auth::logout();

      return redirect('/');    });


//
Route::get('/test',"HomeController@test");  














	
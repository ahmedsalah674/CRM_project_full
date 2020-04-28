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


Auth::routes();
//home route
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/', function () {
    return redirect(route('home'));
});
//user(admin,employee,customer) routes
//if sign =0 will display all users if sign >0 will be the customer id 
Route::get('/show/users/{role}','viewuserscontroller@index')->name('users');

Route::get('/show/user/{id}','viewuserscontroller@show')->name('user.data');
Route::delete('/user/delete','viewuserscontroller@destroy')->name('user.delete');
Route::get('/user/create','viewuserscontroller@create')->name('user.create');
Route::post('/user/create','viewuserscontroller@store')->name('user.store');
//profile routes
Route::get('/edit/profile','viewuserscontroller@edit')->name('edit.profile');
Route::put('/update/profile','viewuserscontroller@update')->name('profile.update');
Route::get('/changepassword','viewuserscontroller@ChangeForm')->name('profile.change.form');
Route::put('/ChangePassword','viewuserscontroller@ChangePassword')->name('password.change');
//complain routes
Route::get('complain/all/{state}','complaincontroller@index')->name('complain.all');
Route::post('complain/show','complaincontroller@show')->name('complain.details');
Route::get('/complain/create','complaincontroller@create')->name('complain.create');
Route::post('/complain/store','complaincontroller@store')->name('complain.store');
Route::put('/complain/sign','complaincontroller@sign')->name('complain.sign');
Route::get('complain/replies/{active}','complaincontroller@replies')->name('complain.replies');
Route::post('/complain/rate','complaincontroller@Rateview')->name('rate.view');
Route::post('/rate','complaincontroller@rate')->name('rate');
Route::put('/unsolved','complaincontroller@unsolved')->name('unsolved');
Route::put('/solved','complaincontroller@solved')->name('solved');
Route::post('/send/reply','complaincontroller@SendReply')->name('complain.send.reply');
Route::get('/system/rates','SystemRateController@index')->name('system.rates');
//var_code will be {0,1,2}->will refer to how will
//if it =0 it will rate employee  if it =1 it will rate the customer if it 2 it will rate the system 
// Route::get('/try','complaincontroller@try2');
// // function ()
// // {
// //     return view('complain.replay');
// // });

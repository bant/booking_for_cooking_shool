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

/*
Route::post('user/password/email', 'User\Auth\ForgotPasswordController@sendResetLinkEmail')->name('user.password.email');
Route::get('user/password/reset', 'User\Auth\ForgotPasswordController@showLinkRequestForm')->name('user.password.request');
Route::post('user/password/reset', 'User\Auth\ResetPasswordController@reset')->name('user.password.update');
Route::get('user/password/reset/{token}', 'User\Auth\ResetPasswordController@showResetForm')->name('user.password.reset');
*/
// ユーザー
Route::namespace('User')->prefix('user')->name('user.')->group(function () {

    // ログイン認証関連
    Auth::routes([
        'register' => true,
        'confirm'  => false,
        'reset'    => true,
        'verify'  => true
    ]);

    // ログイン認証後
    Route::middleware('auth:user')->group(function () {
        // TOPページ
        Route::resource('home', 'HomeController', ['only' => 'index']);

        // 教室予約関係
        Route::get('classroom_reservation', 'ClassRoomReservationController@index')->name('classroom_reservation.index');
        Route::get('classroom_reservation/{id?}/calendar', 'ClassRoomReservationController@calendar')->name('classroom_reservation.calendar');
        Route::get('classroom_reservation/create/{id?}', 'ClassRoomReservationController@create')->name('classroom_reservation.create');  
        Route::post('classroom_reservation/store', 'ClassRoomReservationController@store')->name('classroom_reservation.store');
        Route::post('classroom_reservation/{id?}/destroy', 'ClassRoomReservationController@destroy')->name('classroom_reservation.destroy');
        Route::delete('classroom_reservation/{id?}/destroy', 'ClassRoomReservationController@destroy')->name('classroom_reservation.destroy');

        // ZOOM予約関係
        Route::get('zoom_reservation', 'ZoomReservationController@index')->name('zoom_reservation.index');
        Route::get('zoom_reservation/{id?}/calendar', 'ZoomReservationController@calendar')->name('zoom_reservation.calendar');
        Route::get('zoom_reservation/create/{id?}', 'ZoomReservationController@create')->name('zoom_reservation.create');  
        Route::post('zoom_reservation/store', 'ZoomReservationController@store')->name('zoom_reservation.store');
        Route::post('zoom_reservation/{id?}/destroy', 'ZoomReservationController@destroy')->name('zoom_reservation.destroy');
        Route::delete('zoom_reservation/{id?}/destroy', 'ZoomReservationController@destroy')->name('zoom_reservation.destroy');
    

        Route::get('inquiry/{id?}/getClassrommSchedule', 'InquiryController@getClassrommSchedule');
        Route::get('inquiry/{id?}/getZommSchedule', 'InquiryController@getZommSchedule');
    });
});


// スタッフ
Route::namespace('Staff')->prefix('staff')->name('staff.')->group(function () {

    // ログイン認証関連
    Auth::routes([
        'register' => false,
        'confirm'  => false,
        'reset'    => true
    ]);

    // ログイン認証後
    Route::middleware('auth:staff')->group(function () {
        // TOPページ
        Route::resource('home', 'HomeController', ['only' => 'index']);

        // Roomページ
        Route::resource('room', 'RoomController');
        // Zoomページ
        Route::resource('zoom', 'ZoomController');
        // courseページ
        Route::resource('course', 'CourseController');
        // scheduleページ
        Route::resource('schedule', 'ScheduleController');

        // reservationページ
        Route::resource('reservation', 'ReservationController', ['only' => ['index', 'show']]);
        Route::get('reservation/{id?}/export_class', 'ReservationController@export_class')->name('reservation.export_class');
        Route::get('reservation/{id?}/export_zoom', 'ReservationController@export_zoom')->name('reservation.export_zoom');

        Route::get('inquiry/{id?}/get', 'InquiryController@get');
        Route::post('inquiry/destroy', 'InquiryController@destroy');
        Route::post('inquiry/store', 'InquiryController@store');
        Route::post('inquiry/update', 'InquiryController@update');

        Route::get('reservation/{id?}/show', 'InquiryController@show');

        /*

        Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('staff.password.email');
        Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('staff.password.request');
        Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('staff.password.update');
        Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('staff.password.reset');
*/
    });
});

// 管理者
Route::namespace('Admin')->prefix('admin')->name('admin.')->group(function () {

    // ログイン認証関連
    Auth::routes([
        'register' => false,
        'confirm'  => false,
        'reset'    => true
    ]);

    // ログイン認証後
    Route::middleware('auth:admin')->group(function () {
        // TOPページ
       Route::resource('home', 'HomeController', ['only' => 'index']);

        // Roomページ
        Route::resource('room', 'RoomController', ['only' => 'index']);

/*
        Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('admin.password.email');
        Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('admin.password.request');
        Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('admin.password.update');
        Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('admin.password.reset');
*/
    });

});
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

// ユーザー
Route::namespace('User')->prefix('user')->name('user.')->group(function () {

    // ログイン認証関連
    Auth::routes([
        'register' => true,
        'confirm'  => false,
        'reset'    => false
    ]);

    // ログイン認証後
    Route::middleware('auth:user')->group(function () {
        // TOPページ
        Route::resource('home', 'HomeController', ['only' => 'index']);

        // 教室予約関係
        Route::get('classroom_reservation', 'ClassRoomReservationController@index');
        Route::get('classroom_reservation/{id?}/calendar', 'ClassRoomReservationController@calendar');
        Route::get('classroom_reservation/create/{id?}', 'ClassRoomReservationController@create');  
        Route::post('classroom_reservation/store', 'ClassRoomReservationController@store');
        Route::post('classroom_reservation/{id?}/destroy', 'ClassRoomReservationController@destroy');
        Route::delete('classroom_reservation/{id?}/destroy', 'ClassRoomReservationController@destroy');

        // ZOOM予約関係
        Route::get('zoom_reservation', 'ZoomReservationController@index');
        Route::get('zoom_reservation/{id?}/calendar', 'ZoomReservationController@calendar');
        Route::get('zoom_reservation/create/{id?}', 'ZoomReservationController@create');  
        Route::post('zoom_reservation/store', 'ZoomReservationController@store');
        Route::get('zoom_reservation/{id?}/destroy', 'ZoomReservationController@destroy');  

        Route::get('inquiry/{id?}/getClassrommSchedule', 'InquiryController@getClassrommSchedule');

        Route::get('reservation/{id?}/create', 'ReservationController@create');
        Route::resource('reservation', 'ReservationController');
    });
});


// スタッフ
Route::namespace('Staff')->prefix('staff')->name('staff.')->group(function () {

    // ログイン認証関連
    Auth::routes([
        'register' => true,
        'confirm'  => false,
        'reset'    => false
    ]);

    // ログイン認証後
    Route::middleware('auth:staff')->group(function () {
        // TOPページ
        Route::resource('home', 'HomeController', ['only' => 'index']);

        // Roomページ
        Route::resource('room', 'RoomController');
        // Roomページ
        Route::resource('zoom', 'ZoomController');
        // courseページ
        Route::resource('course', 'CourseController');
        // scheduleページ
        Route::resource('schedule', 'ScheduleController');

        // reservationページ
        Route::resource('reservation', 'ReservationController');

        Route::get('inquiry/{id?}/get', 'InquiryController@get');
        Route::post('inquiry/destroy', 'InquiryController@destroy');
        Route::post('inquiry/store', 'InquiryController@store');
        Route::post('inquiry/update', 'InquiryController@update');

        Route::get('reservation/{id?}/show', 'InquiryController@show');
    });
});

// 管理者
Route::namespace('Admin')->prefix('admin')->name('admin.')->group(function () {

    // ログイン認証関連
    Auth::routes([
        'register' => true,
        'confirm'  => false,
        'reset'    => false
    ]);

    // ログイン認証後
    Route::middleware('auth:admin')->group(function () {
        // TOPページ
       Route::resource('home', 'HomeController', ['only' => 'index']);

        // Roomページ
        Route::resource('room', 'RoomController', ['only' => 'index']);

    });

});
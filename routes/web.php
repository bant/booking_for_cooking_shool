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

// ログインなし
Route::get('/', function () {
    return view('welcome');
});
Route::get('classroom/{id?}/calendar', 'HomeController@classroom_calendar')->name('classroom_calendar');
Route::get('zoom/{id?}/calendar', 'HomeController@zoom_calendar')->name('zoom_calendar');
Route::get('api/inquiry/{id?}/getClassrommSchedule', 'InquiryController@getClassrommSchedule');
Route::get('api/inquiry/{id?}/getZoomSchedule', 'InquiryController@getZoomSchedule');

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

        //
//        Route::resource('profile', 'ProfileController', ['only' => ['edit', 'update']]);
        Route::get('profile/edit', 'ProfileController@showForm')->name('profile.edit');
        Route::post('profile/{id?}/update', 'ProfileController@update')->name('profile.update');

        // 教室予約関係
        Route::get('classroom_reservation', 'ClassRoomReservationController@index')->name('classroom_reservation.index');
        Route::get('classroom/reservation/{id?}/calendar', 'ClassRoomReservationController@calendar')->name('classroom_reservation.calendar');
        Route::get('classroom/reservation/{id?}/create', 'ClassRoomReservationController@create')->name('classroom_reservation.create');  
        Route::post('classroom/reservation/store', 'ClassRoomReservationController@store')->name('classroom_reservation.store');
        Route::post('classroom/reservation/{id?}/destroy', 'ClassRoomReservationController@destroy')->name('classroom_reservation.destroy');
        Route::delete('classroom/reservation/{id?}/destroy', 'ClassRoomReservationController@destroy')->name('classroom_reservation.destroy');

        // ZOOM予約関係
        Route::get('zoom/reservation', 'ZoomReservationController@index')->name('zoom_reservation.index');
        Route::get('zoom/reservation/{id?}/calendar', 'ZoomReservationController@calendar')->name('zoom_reservation.calendar');
        Route::get('zoom/reservation/{id?}/create', 'ZoomReservationController@create')->name('zoom_reservation.create');  
        Route::post('zoom/reservation/store', 'ZoomReservationController@store')->name('zoom_reservation.store');
        Route::post('zoom/reservation/{id?}/destroy', 'ZoomReservationController@destroy')->name('zoom_reservation.destroy');
        Route::delete('zoom/reservation/{id?}/destroy', 'ZoomReservationController@destroy')->name('zoom_reservation.destroy');
    
        Route::get('inquiry/{id?}/getClassroomSchedule', 'InquiryController@getClassroomSchedule')->name('inquiry.get_classroom_schedule');
        Route::get('inquiry/{id?}/getZoomSchedule', 'InquiryController@getZoomSchedule')->name('inquiry.get_zomm_schedule');
    });
});


// スタッフ
Route::namespace('Staff')->prefix('staff')->name('staff.')->group(function () {

    // ログイン認証関連
    Auth::routes([
        'register' => true,
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
        Route::resource('schedule', 'ScheduleController', ['only' => ['index', 'destroy']]);
        Route::get('schedule/calendar', 'ScheduleController@calendar')->name('schedule.calendar');
        Route::resource('classroom_schedule', 'ClassRoomScheduleController');
        Route::resource('zoom_schedule', 'ZoomScheduleController');

        // reservationページ
        Route::resource('reservation', 'ReservationController', ['only' => ['index', 'show']]);
        Route::get('reservation/{id?}/is_contract_update', 'ReservationController@is_contract_update')->name('reservation.is_contract_update');
        Route::get('reservation/{id?}/export_class', 'ReservationController@export_class')->name('reservation.export_class');
        Route::get('reservation/{id?}/export_zoom', 'ReservationController@export_zoom')->name('reservation.export_zoom');

        Route::get('inquiry/{id?}/get', 'InquiryController@get');
        Route::post('inquiry/destroy', 'InquiryController@destroy');
        Route::post('inquiry/store', 'InquiryController@store');
        Route::post('inquiry/update', 'InquiryController@update');

        Route::get('reservation/{id?}/show', 'InquiryController@show');

        Route::get('user/{id?}/info', 'UserController@info')->name('user.info');

        Route::get('message/user', 'MessageController@user_index')->name('message.user_index');
        Route::get('message/user/search', 'MessageController@user_search')->name('message.user_search');

        Route::get('message/user/{id?}/send', 'MessageController@user_send')->name('message.user_send');

        Route::get('message/admin', 'MessageController@admin_index')->name('message.admin_index');
        Route::get('message/admin/{id?}/send', 'MessageController@admin_send')->name('message.admin_send');
        

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

//        Route::resource('point', 'PointController');
        Route::get('point', 'PointController@index')->name('point.index');
        Route::get('point/user/search', 'PointController@user_search')->name('point.user_search');
        Route::post('point/user/search', 'PointController@user_search')->name('point.user_search');
        Route::get('point/user/{id?}/edit', 'PointController@user_edit')->name('point.user_edit');
        Route::post('point/user/{id?}/update', 'PointController@user_update')->name('point.user_update');

        Route::get('point/staff/select', 'PointController@staff_select')->name('point.staff_select');
        Route::post('point/staff/select', 'PointController@staff_select')->name('point.staff_select');
        Route::get('point/staff/{id?}/check', 'PointController@staff_check')->name('point.staff_check');


        Route::resource('user', 'UserController');
        Route::post('user/search', 'UserController@search')->name('user.search');


/*
        Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('admin.password.email');
        Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('admin.password.request');
        Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('admin.password.update');
        Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('admin.password.reset');
*/
    });

});
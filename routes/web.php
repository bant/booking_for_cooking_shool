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
        'register' => false,
        'confirm'  => false,
        'reset'    => true,
        'verify'  => false
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

        Route::get('message/class_user/edit', 'MessageController@class_user_edit')->name('message.class_user_edit');
        Route::post('message/class_user/send', 'MessageController@classuser_send')->name('message.class_user_send');
        Route::get('message/admin/edit', 'MessageController@admin_edit')->name('message.admin_edit');
        Route::post('message/admin/send', 'MessageController@admin_send')->name('message.admin_send');

        Route::get('message/user/search', 'MessageController@user_search')->name('message.user_search');
        Route::post('message/user/search', 'MessageController@user_search')->name('message.user_search');

        Route::get('message/user/{id?}/send', 'MessageController@user_send')->name('message.user_send');

//        Route::get('message/admin', 'MessageController@admin_index')->name('message.admin_index');
//        Route::get('message/admin/{id?}/send', 'MessageController@admin_send')->name('message.admin_send');
 //       Route::get('message/admin/delete/{id?}', 'MessageController@admin_delete')->name('message.admin_delete');
    });
});

// 管理者
Route::namespace('Admin')->prefix('admin')->name('admin.')->group(function () {

    // ログイン認証関連
    Auth::routes([
        'register' => false,
        'confirm'  => false,
        'reset'    => true,
        'verify'  => false
    ]);

    // ログイン認証後
    Route::middleware('auth:admin')->group(function () {
        // TOPページ
        Route::resource('home', 'HomeController', ['only' => 'index']);

        // Roomページ
        Route::resource('room', 'RoomController', ['only' => 'index']);

        Route::get('point', 'PointController@index')->name('point.index');
        Route::get('point/user', 'PointController@user')->name('point.user');
        Route::post('point/user', 'PointController@user')->name('point.user');
        Route::post('point/reservation_search', 'PointController@reservation_search')->name('point.reservation_search');

        Route::get('point/user/{id?}/edit', 'PointController@user_edit')->name('point.user_edit');
        Route::post('point/user/{id?}/update', 'PointController@user_update')->name('point.user_update');
        Route::get('point/staff', 'PointController@staff')->name('point.staff');
        Route::post('point/staff', 'PointController@staff')->name('point.staff');
        Route::get('point/staff/{id?}/check', 'PointController@staff_check')->name('point.staff_check');
        Route::get('point/staff/{id?}/check/{date?}', 'PointController@staff_check_show')->name('point.staff_check_show');
        Route::get('point/check', 'PointController@check')->name('point.check');
        Route::get('point/check/{date?}', 'PointController@check_show')->name('point.check_show');
        Route::get('point/staff/{id?}/export_class/{date?}', 'PointController@staff_export_class')->name('point.staff_export_class');
        Route::get('point/staff/{id?}/export_zoom/{date?}', 'PointController@staff_export_zoom')->name('point.staff_export_zoom');
        Route::get('point/export/{date?}', 'PointController@export_point')->name('point.export_point');

        Route::get('user/check', 'UserController@check')->name('user.check');
        Route::get('user/search', 'UserController@search')->name('user.search');
        Route::post('user/search', 'UserController@search')->name('user.search');

        Route::get('user/{id?}/edit', 'UserController@edit')->name('user.edit');
        Route::get('user/{id?}/info', 'UserController@info')->name('user.info');
        Route::post('user/{id?}/update', 'UserController@update')->name('user.update');
        Route::get('user/{id?}/destroy', 'UserController@destroy')->name('user.destroy');
        Route::post('user/{id?}/destroy', 'UserController@destroy')->name('user.destroy');
        Route::delete('user/{id?}/destroy', 'UserController@destroy')->name('user.destroy');

        Route::get('user/{id?}/point_edit', 'UserController@point_edit')->name('user.point_edit');
        Route::post('user/{id?}/point_update', 'UserController@point_update')->name('user.point_update');

        Route::get('user/deleted_search', 'UserController@deleted_search')->name('user.deleted_search');
        Route::get('user/{id?}/restore', 'UserController@restore')->name('user.restore');
        Route::get('user/export_users', 'UserController@export_users')->name('user.export_users');
                
        Route::get('staff/create', 'StaffController@create')->name('staff.create');
        Route::get('staff/store', 'StaffController@store')->name('staff.store');
        Route::post('staff/store', 'StaffController@store')->name('staff.store');
        Route::get('staff/stop', 'StaffController@stop')->name('staff.stop');
        Route::post('staff/stop', 'StaffController@stop')->name('staff.stop');

        Route::get('staff/restore', 'StaffController@restore')->name('staff.restore');
        Route::post('staff/restore', 'StaffController@restore')->name('staff.restore');

        Route::get('message/staff/search', 'MessageController@staff_show')->name('message.staff_search');
        Route::post('message/staff/search', 'MessageController@staff_search')->name('message.staff_search');
        Route::post('message/staff/send', 'MessageController@send_to_staff_message')->name('message.send_to_staff_message');
        Route::post('message/staff/send', 'MessageController@send_to_staff_message')->name('message.send_to_staff_message');
        Route::get('message/staff/{id?}/delete', 'MessageController@delete_staff_message')->name('message.delete_staff_message');

        Route::get('message/user_search', 'MessageController@user_show')->name('message.user_search');
        Route::post('message/user_search', 'MessageController@user_search')->name('message.user_search');
        Route::post('message/user/send/message', 'MessageController@send_to_user_message')->name('message.send_to_user_message');

    });
});
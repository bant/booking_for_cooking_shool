@extends('layouts.staff.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-2">
            <!-- left menu -->
            @include('layouts.staff.menu')

            <div class="col-md-10">
                <div class="card">
                    <div class="card-header"><i class="fas fa-id-card"></i> {{ Auth::user()->name }}先生のスケジュール</div>
                    <div class="card-body">
                        @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                        @endif

                        <div id='calendar'></div>
                        <div style='clear:both'></div>
                    <br/>
                        @if ($room_count != 0)
                            <a href="{{route('staff.classroom_schedule.create')}}"><button type="submit" class="btn btn btn-warning"><i class="fas fa-edit"></i> 教室スケジュール新規登録</button></a>
                        @endif
                        @if ($zoom_count != 0)
                            <a href="{{route('staff.zoom_schedule.create')}}"><button type="submit" class="btn btn btn-warning"><i class="fas fa-edit"></i> ZOOMスケジュール新規登録</button></a>
                        @endif
                    </div>

                </div><!-- end card-body -->
            </div><!-- end card -->
        </div>
    </div>
</div>
@endsection

@section('scripts')
   <!-- full calendar -->
   <link href='https://unpkg.com/@fullcalendar/core@4.3.1/main.min.css' rel='stylesheet' />
    <link href='https://unpkg.com/@fullcalendar/daygrid@4.3.0/main.min.css' rel='stylesheet' />
    <link href='https://unpkg.com/@fullcalendar/timegrid@4.3.0/main.min.css' rel='stylesheet' />
    <link href='https://unpkg.com/@fullcalendar/list@4.3.0/main.min.css' rel='stylesheet' />
    <script src='https://unpkg.com/@fullcalendar/core@4.3.1/main.min.js'></script>
    <script src='https://unpkg.com/@fullcalendar/interaction@4.3.0/main.min.js'></script>
    <script src='https://unpkg.com/@fullcalendar/daygrid@4.3.0/main.min.js'></script>
    <script src='https://unpkg.com/@fullcalendar/timegrid@4.3.0/main.min.js'></script>
    <script src='https://unpkg.com/@fullcalendar/list@4.3.0/main.min.js'></script>
    <script src='https://unpkg.com/@fullcalendar/core/locales/ja'></script>
    <link href="{{ asset('css/calendar.css') }}" rel="stylesheet">
    
    <!-- UltraDateの読み込み -->
    <script src="{{ asset('js/UltraDate.js') }}"></script>
    <script src="{{ asset('js/UltraDate.ja.js') }}"></script>
    
    <script>
    document.addEventListener('DOMContentLoaded', function() {
    var Calendar = FullCalendar.Calendar;
    var containerEl = document.getElementById('external-events');
    var calendarEl = document.getElementById('calendar');
    var checkbox = document.getElementById('drop-remove');
 
    const date = new UltraDate();
    // initialize the calendar
    var calendar = new Calendar(calendarEl, {
        plugins: [ 'interaction', 'dayGrid', 'timeGrid','list' ],
        header: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
        },
        allDaySlot: true,
        forceEventDuration : true,
        eventColor: 'lavender',
        defaultTimedEventDuration: '01:00',
     //    defaultView: 'timeGridWeek',
        slotDuration: '00:30:00',
        minTime : '9:00',
        maxTime : '22:00',
        locale : 'ja',
        editable: true,
        selectable: true,
        allDaySlot: false,
        droppable: false, // this allows things to be dropped onto the calendar
        buttonText: {
            today:'今日',
            month:'月',
            week: '週',
            day:  '日',
            list: 'リスト'
        },
        
        events:'/staff/inquiry/{{ Auth::user()->id }}/get',
 
        dayRender: function(info) {
            date.setFullYear(
                info.date.getFullYear(),
                info.date.getMonth(),
                info.date.getDate()
            );
            const holiday = date.getHoliday();
            if (holiday !== "") {
                info.el.insertAdjacentHTML("afterbegin", "<div class=\"holiday-name\">" + holiday + "</div>");
                info.el.classList.add("fc-hol")
            }
        },
 
        select: function (info) {
            // カレンダーセルクリック、範囲指定された時のコールバック
            console.log('select');
        },
 
        // ドラッグドロップで操作
        eventReceive: function(info) {
            var start = moment(info.event.start).format("Y-MM-DD HH:mm");
            var end = moment(info.event.start).format("Y-MM-DD HH:mm");
            // csrf。Laravelお約束
            $.ajaxSetup({
                 headers: {
                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                 }
             });
             $.ajax({
                 type: 'post',
                 data: {
                     'title' : info.event.title,
                     'staff_id': '{{ Auth::user()->id }}',
                     'start': start,
                     'end': end
                 },
                 datatype: 'json',
                 url: '/staff/inquiry/store' /* identifierをキーに登録or更新 */
             })
             .done(function(data){
                 json = JSON.parse(data);
                 if ( json['result'] == 'success' ) {
                     // サーバサイドにて設定された背景色に変更
                     info.event.setProp('color',json['color']);
                 }
             })
             .fail(function(data){
                 alert('error');
             });
         },
 
         eventDrop: function (info) {
             var start = moment(info.event.start).format("Y-MM-DD HH:mm");
             var end = moment(info.event.end).format("Y-MM-DD HH:mm");
             // csrf。Laravelお約束
             $.ajaxSetup({
                 headers: {
                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                 }
             });
             $.ajax({
                 type: 'post',
                 data: {
                     'id': info.event.id,
                     'start': start,
                     'end': end
                 },
                 datatype: 'json',
                 url: '/staff/inquiry/update' /* identifierをキーに登録or更新 */
             })
             .done(function(data){
                 json = JSON.parse(data);
                 if ( json['result'] == 'success' ) {
                     // サーバサイドにて設定された背景色に変更
                     info.event.setProp('color',json['color']);
                 }
             })
             .fail(function(data){
                 alert('error');
             });
         },
 
         eventClick: function (info) {
                     var deleteMsg = confirm("Do you really want to delete?");
                     if (deleteMsg) {
                         // csrf。Laravelお約束
                         $.ajaxSetup({
                             headers: {
                                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                             }
                         });
                         $.ajax({
                             type: "POST",
                             url: '/staff/inquiry/destroy',
                             data: { 'id': info.event.id },
                             success: function (response) {
                                 if (parseInt(response) > 0) {
                                     info.event.remove(); 
                                 displayMessage("Deleted Successfully");
                         }
                         location.reload();
                     }
                 });
             }
         },
 
         eventResize: function(info) {
             // イベントがリサイズ（引っ張ったり縮めたり）された時のコールバック
             console.log('eventResize');
         },
         eventRender: function (info) {
           //wired listener to handle click counts instead of event type
           info.el.addEventListener('click', function() {
             clickCnt++;
             if (clickCnt === 1) {
                 oneClickTimer = setTimeout(function() {
                     clickCnt = 0;
                     // SINGLE CLICK
                     console.log('single click');
                 }, 400);
             } else if (clickCnt === 2) {
                 clearTimeout(oneClickTimer);
                 clickCnt = 0;
                 // DOUBLE CLICK
                 console.log('double click');
             }
           });
         }
     })
        calendar.render();
    });
 </script>
@endsection
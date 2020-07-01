@extends('layouts.staff.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <!-- left -->
        <div class="col-md-2">
            <div class="card">
                <div class="card-header"><i class="fas fa-th-list"></i></i> メニュー</div>
                    <div class="card-body">
                        <div class="panel panel-default">
                            <ul class="nav nav-pills nav-stacked" style="display:block;">
                                <li><i class="fas fa-user-alt"></i> <a href="room">プロフィール</a></li>
                                <li><i class="fas fa-user-alt"></i> <a href="room">教室情報</a></li>
                                <li><i class="fas fa-calendar"></i> <a href="schedule">スケジュール</a></li>
                                <li><i class="fas fa-calendar"></i> <a href="schedule">予約</a></li>
                            </ul>
                            <hr>
                            <div id='calendar-container'>
                                <div id='external-events'>
                                    <div class='fc-event'>教室設定</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

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
                    </div>
                </div><!-- end card-body -->
            </div><!-- end card -->
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
   var Calendar = FullCalendar.Calendar;
   var Draggable = FullCalendarInteraction.Draggable;

   var containerEl = document.getElementById('external-events');
   var calendarEl = document.getElementById('calendar');
   var checkbox = document.getElementById('drop-remove');

   // initialize the external events
    new Draggable(containerEl, {
        itemSelector: '.fc-event',
            eventData: function(eventEl) {
                return {
                    title: eventEl.innerText
                };
            }
    });

    // initialize the calendar
    var calendar = new Calendar(calendarEl, {
        plugins: [ 'interaction', 'dayGrid', 'timeGrid','list' ],
        header: {
          left: 'prev,next today',
          center: 'title',
          right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
        },
        allDaySlot: false,
        forceEventDuration : true,
        eventColor: 'lavender',
        defaultTimedEventDuration: '01:00',
        defaultView: 'timeGridWeek',
        slotDuration: '00:10:00',
        minTime : '10:00',
        maxTime : '22:10',
        locale : 'jaLocale',
        editable: true,
        selectable: true,
        allDaySlot: false,
        droppable: true, // this allows things to be dropped onto the calendar
            buttonText: {
                today:'今日',
                month:'月',
                week: '週',
                day:  '日',
                list: 'リスト'
            },

        events:'/staff/schedule/source/{{ Auth::user()->id }}/',

        select: function (info) {
            // カレンダーセルクリック、範囲指定された時のコールバック
            console.log('select');
        },

//        eventReceive: function(info) {
//            // イベントがexternal-eventからドロップされた時のコールバック
//            console.log('eventReceive');
//        },


        eventReceive: function(info) {
//            Create(info);

            var dt = new Date();
            info.event.setExtendedProp('identifier',dt.getTime());

            // csrf。Laravelお約束
            $.ajaxSetup({
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: 'post',
                data: {
                    'identifier': info.event.extendedProps.identifier,
                    'staff_id': info.event.extendedProps.staff_id,
                    'start': info.event.start,
                    'end': info.event.end
                },
                datatype: 'json',
//                events:'/staff/schedule/source/{{ Auth::user()->id }}/',
                url: '/staff/schedule/update' /* identifierをキーに登録or更新 */
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
            var start = moment(info.event.start).format("Y-MM-DD HH:mm:ss");
            var end = moment(info.event.start).format("Y-MM-DD HH:mm:ss");

            $.ajax({
                url: '/staff/schedule/edit',
                data: { start: start, end: end, id: id },
                type: "POST",
                success: function (response) {
                    displayMessage("Updated Successfully");
                }
            });
        },

///        '/staff/schedule/source/{{ Auth::user()->id }}


        eventClick: function (info) {
                    var deleteMsg = confirm("Do you really want to delete?");
                    if (deleteMsg) {
                        $.ajax({
                            type: "POST",
                            url: '/staff/schedule/delete',
                            data: { id: id },
                            success: function (response) {
                                if (parseInt(response) > 0) {
                                    info.event.remove(); 
                                    displayMessage("Deleted Successfully");
                                }
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
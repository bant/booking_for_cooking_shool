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
        locale : 'ja',
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
        events:'/staff/inquiry/{{ Auth::user()->id }}/get',

        select: function (info) {
            // カレンダーセルクリック、範囲指定された時のコールバック
            console.log('select');
        },

        // ドラッグドロップで操作
        eventReceive: function(info) {
            var start = moment(info.event.start).format("Y-MM-DD HH:mm");
            var end = moment(info.event.start).format("Y-MM-DD HH:mm");
//            var dt = new Date();
//            info.event.setExtendedProp('identifier',dt.getTime());
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
//                    'identifier': info.event.extendedProps.identifier,
                    'owner_id': '{{ Auth::user()->id }}',
//                    'description': ' ',
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
//                    displayMessage("Updated Successfully");
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
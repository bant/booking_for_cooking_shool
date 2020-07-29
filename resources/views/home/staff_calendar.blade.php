@extends('layouts.home.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
        <!-- 先生のカレンダ用スロット始まり -->
            <div class="card">
                <div class="card-header justify-content-left"><i class="fas fa-id-card"></i> {{ $staff->room->name }}({{ $staff->name }}先生)のスケジュール</div>
                <div class="card-body">
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif

                    <div id='calendar'></div>
                    <div style='clear:both'></div>

                </div>
                <!-- 先生のカレンダ用スロット終わり -->

            </div><!-- end card -->
        </div>
    </div>
</div>
@endsection

@section('scripts')
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
 //       defaultView: 'timeGridWeek',
        slotDuration: '00:30:00',
        minTime : '9:00',
        maxTime : '22:00',
        locale : 'ja',
        editable: false,
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
        events:'/api/inquiry/{{ $staff->id }}/getClassrommSchedule',

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
            // カレンダーセルクリック、範囲指定された時のコールバック
            console.log('eventReceive');
        },

        eventDrop: function (info) {
             // カレンダーセルクリック、範囲指定された時のコールバック
             console.log('eventDrop');
        },

        eventClick: function (info) {
             // カレンダーセルクリック、範囲指定された時のコールバック
             console.log('eventClick');
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
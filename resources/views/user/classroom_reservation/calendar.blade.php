@extends('layouts.user.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-2">
            <!-- left menu -->
            @include('layouts.user.menu')

            <div class="col-md-10">
                <!-- 先生のカレンダ用スロット始まり -->
                <div class="card">
                    <div class="card-header"><i class="fas fa-id-card"></i> {{ $staff->room->name }}のカレンダ</div>
                    <div class="card-body">
                        @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                        @endif

                        <div id='calendar'></div>
                        <div style='clear:both'></div>
                    </div>
                </div>
                <!-- 先生のカレンダ用スロット終わり -->
   
                <br/>
                <!-- 生徒さん様の予約リスト用スロット始まり -->
                <div class="card">
                    <div class="card-header"><i class="fas fa-id-card"></i> {{ Auth::user()->name }}さんのご予約状況</div>
                    <div class="card-body">


                      @if($reservations->count())
                      <table class="table table-sm table-striped">
                      <thead>
                        <tr>
                          <th class="text-center">#</th>
                          <th>コース名</th>
                          <th>教室</th>
                          <th>先生</th>
                          <th>価格</th>
                          <th>開始時間</th>
                          <th class="text-right">オプション</th>
                        </tr>
                      </thead>

                      <tbody>
                      @foreach($reservations as $reservation)
                        <tr>
                            <td></td>
                          <td>{{$reservation->course_name}}</td>
                          <td>{{$reservation->room_name}}</td>
                          <td>{{$reservation->staff_name}}</td>
                          <td>{{ number_format($reservation->course_price) }}円</td>
                          <td>{{$reservation->start}}</td>
                          <td class="text-right">

                          </td>
                        </tr>
                      @endforeach
                      </tbody>
                      </table>
   

                    @else
                        <h3 class="text-center alert alert-info">予約はありません。</h3>
                    @endif

                    </div>

                </div>
                 <!-- 生徒さん様の予約リスト用スロット終わり -->
            </div><!-- end card -->
          
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
   var Calendar = FullCalendar.Calendar;
//   var Draggable = FullCalendarInteraction.Draggable;
   var containerEl = document.getElementById('external-events');
   var calendarEl = document.getElementById('calendar');
   var checkbox = document.getElementById('drop-remove');

   // initialize the external events
//   new Draggable(containerEl, {
//        itemSelector: '.fc-event',
//            eventData: function(eventEl) {
//                return {
//                    title: eventEl.innerText
//                };
//            }
//    });

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
        minTime : '10:00',
        maxTime : '22:10',
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
        events:'/user/inquiry/{{ $staff->id }}/getClassrommSchedule',

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
@extends('layouts.user.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-2">
            <!-- left menu -->
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
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-10">
                <!-- 先生のカレンダ用スロット始まり -->
                <div class="card">
                    <div class="card-header"><i class="fas fa-id-card"></i> {{ $staff->room->name }}(主催:{{$staff->name}}先生)のスケジュール</div>
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


                    @if($courses->count())
                      <table class="table table-sm table-striped">
                      <thead>
                        <tr>
                          <th class="text-center">#</th>
                          <th>名称</th>
                          <th>単価</th>
                          <th class="text-right">オプション</th>
                        </tr>
                      </thead>

                      <tbody>
                      @foreach($reservations as $reservation)
                        <tr>
                          <td class="text-center"><strong>{{$reservation->id}}</strong></td>
                          <td>{{$reservation->name}}</td>
                          <td>{{$reservation->price}}</td>
                          <td class="text-right">
                            <a class="btn btn-sm btn-warning" href="{{ route('staff.course.edit', $course->id) }}"><i class="fas fa-edit"></i> 編集</a>
                            <form action="{{ route('staff.course.destroy', $course->id) }}" method="POST" style="display: inline;"
                                onsubmit="return confirm('削除しても良いですか?');">
                                {{csrf_field()}}
                                <input type="hidden" name="_method" value="DELETE">
                                <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i> 削除</button>
                            </form>
                          </td>
                        </tr>
                      @endforeach
                      </tbody>
                      </table>
                      <a class="btn btn-primary" href="{{ route('staff.course.create') }}"><i class="fas fa-edit"></i> 追加</a>

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
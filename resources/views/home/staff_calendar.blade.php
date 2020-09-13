@extends('layouts.home.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
        <!-- 先生のカレンダー用スロット始まり -->
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
                <!-- 先生のカレンダー用スロット終わり -->

            </div><!-- end card -->
        </div>
    </div>
</div>
@endsection

@section('scripts')
<!-- full calendar -->
<link href="{{ asset('js/fullcalendar/core/main.min.css') }}" rel="stylesheet">
<link href="{{ asset('js/fullcalendar/daygrid/main.min.css') }}" rel="stylesheet">
<link href="{{ asset('js/fullcalendar/timegrid/main.min.css') }}" rel="stylesheet">
<link href="{{ asset('js/fullcalendar/list/main.min.css') }}" rel="stylesheet">

<script src="{{ asset('js/fullcalendar/core/main.min.js') }}"></script>
<script src="{{ asset('js/fullcalendar/interaction/main.min.js') }}"></script>
<script src="{{ asset('js/fullcalendar/daygrid/main.min.js') }}"></script>
<script src="{{ asset('js/fullcalendar/timegrid/main.min.js') }}"></script>
<script src="{{ asset('js/fullcalendar/list/main.min.js') }}"></script>
<script src="{{ asset('js/fullcalendar/core/main.min.js') }}"></script>
<script src="{{ asset('js/fullcalendar/core/locales/ja.js') }}"></script>
   
<!-- UltraDateの読み込み -->
<link href="{{ asset('css/calendar.css') }}" rel="stylesheet">
<script src="{{ asset('js/UltraDate.js') }}"></script>
<script src="{{ asset('js/UltraDate.ja.js') }}"></script>

<script>
document.addEventListener("DOMContentLoaded", function () {
  var Calendar = FullCalendar.Calendar;
  var containerEl = document.getElementById("external-events");
  var calendarEl = document.getElementById("calendar");
  var checkbox = document.getElementById("drop-remove");

  // 休日データ
  const date = new UltraDate();
  // initialize the calendar
  var calendar = new Calendar(calendarEl, {
    plugins: ["interaction", "dayGrid", "timeGrid", "list"],
    header: {
      left: "prev,next today",
      center: "title",
      right: "dayGridMonth,timeGridWeek,timeGridDay,listWeek"
    },
    allDaySlot: true,
    forceEventDuration: true,
    eventColor: "lavender",
    defaultTimedEventDuration: "01:00",
    slotDuration: "00:30:00",
    minTime: "9:00",
    maxTime: "22:00",
    locale: "ja",
    editable: false,
    selectable: true,
    allDaySlot: false,
    droppable: false, // this allows things to be dropped onto the calendar
    buttonText: {
      today: "今日",
      month: "月",
      week: "週",
      day: "日",
      list: "リスト"
    },
    events: "/api/inquiry/{{ $staff->id }}/getClassroomSchedule",

    dayRender: function (info) {
      date.setFullYear(
        info.date.getFullYear(),
        info.date.getMonth(),
        info.date.getDate()
      );
      const holiday = date.getHoliday();
      if (holiday !== "") {
        info.el.insertAdjacentHTML(
          "afterbegin",
          '<div class="holiday-name">' + holiday + "</div>"
        );
        info.el.classList.add("fc-hol");
      }
    },

    eventRender: function (info) {
      $(info.el).tooltip({
        title:
          '<i class="fa fa-users"></i>&nbsp;<b>教室情報</b><br/>' +
          " 教室：" + info.event.extendedProps.place + "<br/>" +
          " 先生：" + info.event.extendedProps.staff_name + "<br/>" +
          " コース名：" + info.event.extendedProps.schedule_name + "<br/>" +
          " 日時：" + info.event.extendedProps.start_end + "<br/>" +
          " 残り：" + info.event.extendedProps.schedule_capacity + "名<br/>" +
          " 状態：" + info.event.extendedProps.status ,
        placement: "top",
        trigger: "hover",
        container: "body",
        html: true
      });
    }
  });
  calendar.render();
});
</script>
@endsection
@extends('layouts.user.app')

@section('content')
<div id="content">
    <div id="breadcrumbs">
        <a  href="{{route('user.home.index')}}"><i class="fas fa-home"></i> トップページ</a>  >
        {{ $staff->zoom->name }}の予約
    </div>  
<section>
<h1> {{ $staff->zoom->name }}の予約</h1>
<h2>{{ $staff->zoom->name }}の予定カレンダー</h2>
    <div class="row justify-content-center">
        <div class="col-md-10">
            <!-- 先生のカレンダー用スロット始まり -->
            <div class="card">
                <div class="card-header"><i class="fas fa-id-card"></i> {{ $staff->zoom->name }}のカレンダー</div>
                <div class="card-body">
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif
                    <div id='calendar'></div>
                    <div style='clear:both'></div>
                    ※残り0のときは、キャンセル待ちになります。
                </div>
                <!-- 先生のカレンダー用スロット終わり -->
            </div>
        </div>
    </div>

    <h3> {{ Auth::user()->name }}さんのオンライン教室のご予約状況</h3>
    {{--成功時のメッセージ--}}
                    @if (session('success'))
                      <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    {{-- エラーメッセージ --}}
                    @if ($errors->any())
                        <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        </div>
                    @endif
    @if($reservations->count())
        <table class="table table-sm table-striped">
            <thead>
                <tr>
                    <th>予約番号</th>
                    <th>状態</th>
                    <th>教室</th>
                    <th>コース名</th>
                    <th>先生</th>
                    <th>価格(税込み)</th>
                    <th>開始時間</th>
                    <th class="text-right"> アクション</th>
                </tr>
            </thead>

            <tbody>
            @foreach($reservations as $reservation)
                <tr>
                <td>{{$reservation->id}}</td>
                @if ($reservation->is_contract)
                    <td class="text-center text-white bg-success"><strong>確</strong></td>
                @else
                    <td class="text-center text-white bg-danger"><strong>仮</strong></td>
                @endif
                <td>{{$reservation->zoom_name}}</td>
                <td>{{$reservation->course_name}}</td>
                <td>{{$reservation->staff_name}}</td>
                <td>{{ number_format($reservation->course_price*1.1) }}円</td>
                <td>{{ date('Y年m月d日 H時i分', strtotime($reservation->start))}}</td>
                <td class="text-right">
                    <form action="{{route('user.message.send_cancel_message',$reservation->id)}}" method="POST" style="display: inline;"
                                onsubmit="return confirm('予約の取り消し依頼を送信しますか?');">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-paper-plane"></i>　取り消しメッセージ</button>
                    </form>
                </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @else
        <div class="text-center alert alert-info">予約はありません。</div>
    @endif

    @if($wait_list_reservations->count())
    <h3> {{ Auth::user()->name }}さんのキャンセル待ち状況</h3>
        <table class="table table-sm table-striped">
            <thead>
                <tr>
                    <th>教室</th>
                    <th>コース名</th>
                    <th>先生</th>
                    <th>価格(税込み)</th>
                    <th>開始時間</th>
                    <th class="text-right"> アクション</th>
                </tr>
            </thead>

            <tbody>
            @foreach($wait_list_reservations as $wait_list_reservation)
                <tr>
                <td>{{$wait_list_reservation->course_name}}</td>
                <td>{{$wait_list_reservation->zoom_name}}</td>
                <td>{{$wait_list_reservation->staff_name}}</td>
                <td>{{ number_format($wait_list_reservation->course_price*1.1) }}円</td>
                <td>{{ date('Y年m月d日 H時i分', strtotime($wait_list_reservation->start))}}</td>
                <td class="text-right">
                    <form action="{{route('user.message.send_cancel_message',$wait_list_reservation->id)}}" method="POST" style="display: inline;"
                                onsubmit="return confirm('キャンセル待ちの取り消し依頼をしますか?');">
                        @csrf
                         <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-paper-plane"></i>　取り消しメッセージ</button>
                    </form>
                </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @endif

 </section>
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
    events:"{{route('user.inquiry.get_zomm_schedule',$staff->id)}}",

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
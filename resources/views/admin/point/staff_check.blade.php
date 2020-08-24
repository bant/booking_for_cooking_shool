@extends('layouts.admin.app')

@section('content')
<div id="content">
  <section>
    <h2>{{$staff->name}}先生のポイント
        <a class="float-right btn btn-sm btn-primary" href="{{ route('admin.point.staff_check_show', ['id' => $staff->id, 'date' => $next_first_month_day])}}"> 次月 >></a>
        <a class="float-right btn btn-sm btn-primary" href="{{ route('admin.point.staff_check_show', ['id' => $staff->id, 'date' => $previous_first_month_day])}}"> << 前月</a>
    </h2>
    <h3>{{date('Y年m月', strtotime($now_first_month_day)) }}の{{$staff->room->name}}のポイント状況</h3>
    @if (session('status'))
      <div class="alert alert-success" role="alert">
        {{ session('status') }}
      </div>
    @endif

    @if($class_reservations->count())
      <table class="table table-sm table-striped">
        <thead>
          <tr>
            <th>#</th>
            <th>コース名</th>
            <th>料金</th>
            <th>開催日時</th>
            <th>参加生徒(ID)</th>
            <th class="text-center">予約状態</th>
            <th>終了</th>
            <th class="text-center">支払い方法</th>
            <th>ポイント</th>
          </tr>
        </thead>

        <tbody>
        @foreach($class_reservations as $class_reservation)
          <tr>
          <td>{{$class_reservation->id}}</td>
          <td>{{$class_reservation->course_name}}</td>
          <td>{{ number_format($class_reservation->course_price)}}円</td>
          <td>{{ date('Y年m月d日 H時i分', strtotime($class_reservation->start)) }}</td>
        @if (!is_null($class_reservation->deleted_at))
          <td><a href="{{ route('admin.user.info', ['id' => $class_reservation->user_id])}}">{{$class_reservation->user_name}}({{$class_reservation->user_id}})</a></td>
        @else
          <td>{{$class_reservation->user_name}}(停止)</td>
        @endif
        @if ($class_reservation->is_contract)
          <td class="text-center text-white bg-success"><strong>確</strong></td>
        @else
          <td class="text-center text-white bg-danger"><strong>仮</strong></td>
        @endif
        @if (strtotime($class_reservation->start) > strtotime('now'))
          <td>未</td>
        @else
          <td>済</td>
        @endif
        @if ($class_reservation->is_pointpay)
          <td class="text-center text-white bg-success"><strong>ポイント</strong></td>
        @else
          <td class="text-center text-white bg-danger"><strong>現金</strong></td>
        @endif
          <td>{{ number_format($class_reservation->spent_point)}}pt</td>
        </tr>
        @endforeach
      </tbody>
    </table>
    <a class="float-right btn btn-sm btn-warning" href="{{ route('admin.point.staff_export_class', ['id' => $staff->id, 'date' => $now_first_month_day])}}"><i class="fas fa-edit"></i> execelファイルでダウンロード</a>
    @else
      <div class="text-center alert alert-info">教室の予約はありません。</div>
    @endif

    <br/>

    @if ($staff->is_zoom)
    <h3>{{date('Y年m月', strtotime($now_first_month_day)) }}のオンライン教室の予約状況</h3>
      @if($zoom_reservations->count())
      <table class="table table-sm table-striped">
      <thead>
        <tr>
          <th>#</th>
          <th>コース名</th>
          <th>料金</th>
          <th>開催日時</th>
          <th>参加生徒(ID)</th>
          <th class="text-center">予約状態</th>
          <th>終了</th>
          <th class="text-center">支払い方法</th>
          <th>ポイント</th>
        </tr>
      </thead>
      
      <tbody>
        @foreach($zoom_reservations as $zoom_reservation)
          <tr>
                          <td>{{$zoom_reservation->id}}</td>
                          <td>{{$zoom_reservation->course_name}}</td>
                          <td>{{ number_format($zoom_reservation->course_price)}}円</td>
                          <td>{{ date('Y年m月d日 H時i分', strtotime($zoom_reservation->start)) }}</td>
                        @if (!is_null($zoom_reservation->deleted_at))
                          <td><a href="{{ route('admin.user.info', ['id' => $zoom_reservation->user_id])}}">{{$zoom_reservation->user_name}}({{$zoom_reservation->user_id}})</a></td>
                        @else
                          <td>{{$zoom_reservation->user_name}}(停止)</td>
                        @endif
                        @if ($zoom_reservation->is_contract)
                          <td class="text-center text-white bg-success"><strong>確</strong></td>
                        @else
                          <td class="text-center text-white bg-danger"><strong>仮</strong></td>
                        @endif
                        @if (strtotime($zoom_reservation->start) > strtotime('now'))
                          <td>未</td>
                        @else
                          <td>済</td>
                        @endif
                        @if ($zoom_reservation->is_pointpay)
                          <td class="text-center text-white bg-success"><strong>ポイント</strong></td>
                        @else
                          <td class="text-center text-white bg-danger"><strong>現金</strong></td>
                        @endif
                          <td>{{ number_format($zoom_reservation->spent_point)}}pt</td>
                        </tr>
                      @endforeach
                      </tbody>
                      </table>
                      <a class="float-right btn btn-sm btn-warning" href="{{ route('admin.point.staff_export_zoom', ['id' => $staff->id, 'date' => $now_first_month_day])}}"><i class="fas fa-edit"></i> execelファイルでダウンロード</a>
                     @else
                        <div class="text-center alert alert-info">ZOOMの予約はありません。</div>
                    @endif
  @endif
  </section>
</div>
@endsection